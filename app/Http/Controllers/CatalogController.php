<?php namespace App\Http\Controllers;

use Fanky\Admin\Models\Catalog;
use Fanky\Admin\Models\MaterialImage;
use Fanky\Admin\Models\Page;
use Fanky\Admin\Models\Product;
use Fanky\Admin\Settings;
use Illuminate\Database\Eloquent\Collection;
//use Illuminate\Http\Request;
use SEOMeta;
use Session;
use View;
use Request;

class CatalogController extends Controller {

    public function index() {
        $page = Page::getByPath(['catalog']);
        if(!$page) return abort(404);
        $bread = $page->getBread();
        $page->h1 = $page->getH1();
        $page = $this->add_region_seo($page);
        $page->setSeo();
        $categories = Catalog::getTopLevelOnList();

        return view('catalog.index', [
            'h1'         => $page->h1,
            'text'       => $page->text,
            'bread'      => $bread,
            'categories' => $categories,
        ]);
    }

    public function view($alias) {
        $path = explode('/', $alias);
        /* проверка на продукт в категории */
        $product = null;
        $end = array_pop($path);
        $category = Catalog::getByPath($path);
        if($category && $category->published) {
            $product = Product::whereAlias($end)
                ->public()
                ->whereCatalogId($category->id)->first();
        }
        if($product) {
            return $product->is_kit
                ? $this->kit($product)
                : $this->product($product);
        } else {
            array_push($path, $end);

            return $this->category($path + [$end]);
        }
    }

    public function category($path) {
        /** @var Catalog $category */
        $category = Catalog::getByPath($path);
        if(!$category || !$category->published) abort(404, 'Страница не найдена');
        $bread = $category->getBread();
        $category = $this->add_region_seo($category);
        $children = $category->public_children;
        $category->setSeo();

        $per_page = Request::get('pages');
        $per_page = is_numeric($per_page) ? $per_page : \Settings::get('product_per_page');
        $data['per_page'] = $per_page;

        $parentIds = Catalog::where('parent_id', '=', '0')->pluck('id')->all();

        if(in_array($category->id, $parentIds)) {
            $ids = $category->getRecurseChildrenIds();
            $items = Product::public()->whereIn('catalog_id', $ids)->paginate($per_page);
            $is_subcategory = false;
        } else {
            $items =  $category->products()->paginate($per_page);
            $is_subcategory = true;
        }

        $data = [
            'bread'    => $bread,
            'category' => $category,
            'children' => $children,
            'h1'       => $category->getH1(),
            'items' => $items,
            'is_subcategory' => $is_subcategory,
        ];

        $view = Session::get('catalog_view', 'list') == 'list' ?
            'catalog.views.list' :
            'catalog.views.grid';

        $data['items'] = view($view, ['items' => $items, 'category' => $category, 'per_page' => $per_page]);

        return view('catalog.category', $data);

    }

    public function product(Product $product) {
        $bread = $product->getBread();
        $product = $this->add_region_seo($product);
        $product->setSeo();
        $params = $product->params()
            ->where('group', '!=', '')
            ->get()
            ->groupBy('group');

        return view('catalog.product', [
            'product'    => $product,
            'bread'      => $bread,
            'name'       => $product->name,
            'specParams' => $product->params_on_spec,
            'params'     => $params,
        ]);
    }

}
