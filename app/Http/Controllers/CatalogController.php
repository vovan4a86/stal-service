<?php namespace App\Http\Controllers;

use Fanky\Admin\Models\AddParam;
use Fanky\Admin\Models\Catalog;
use Fanky\Admin\Models\CatalogParam;
use Fanky\Admin\Models\MaterialImage;
use Fanky\Admin\Models\Page;
use Fanky\Admin\Models\Product;
use Fanky\Admin\Models\ProductAddParam;
use Fanky\Admin\Models\ProductIcon;
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
            return $this->product($product);
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

        $ids = null;
        if(in_array($category->id, $parentIds)) {
            $ids = $category->getRecurseChildrenIds();
            $items = Product::public()->whereIn('catalog_id', $ids)
                ->orderBy('name', 'asc')->paginate($per_page);
            $is_subcategory = false;
        } else {
            $items = $category->products()->paginate($per_page);
            $is_subcategory = true;
        }
        if($category->parent_id !== 0) {
            $root = $category->findRootCategory($category->parent_id);
        } else {
            $root = $category;
        }

        $filters = $root->filters()->get();

        $sort = [];
        foreach ($filters as $filter) {
            if($filter->cat_id === null) {
                if($ids) {
                    $sort[$filter->alias] = Product::public()->whereIn('catalog_id', $ids)
                        ->orderBy($filter->alias, 'asc')
                        ->groupBy($filter->alias)
                        ->distinct()
                        ->pluck($filter->alias)
                        ->all();
                } else {
                    $sort[$filter->alias] = Product::public()->where('catalog_id', $category->id)
                        ->orderBy($filter->alias, 'asc')
                        ->groupBy($filter->alias)
                        ->distinct()
                        ->pluck($filter->alias)
                        ->all();
                }
            } else {
               $catalog_params = CatalogParam::where('catalog_id', '=', $filter->catalog_id)
                   ->pluck('param_id')->all();
               $prods = ProductAddParam::whereIn('add_param_id', $catalog_params)
                   ->pluck('product_id')->all();
               $sort[$filter->alias] = Product::whereIn('id', $prods)->get();
            }
        }

        $data = [
            'bread'    => $bread,
            'category' => $category,
            'children' => $children,
            'h1'       => $category->getH1(),
            'updated' => $items[0]->updated_at ?? null,
            'items' => $items,
            'root' => $root ?? null,
            'filters' => $filters,
            'sort' => $sort,
            'is_subcategory' => $is_subcategory,
        ];

        $view = Session::get('catalog_view', 'list') == 'list' ?
            'catalog.views.list' :
            'catalog.views.grid';

        $data['items'] = view($view, [
            'items' => $items,
            'category' => $category,
            'sort' => $sort,
            'root' => $root,
            'filters' => $filters,
            'per_page' => $per_page
        ]);

        if (Request::ajax()) {
            $view_items = [];
            foreach ($items as $item) {
                //добавляем новые элементы
                $view_items[] = view('news.list_item', [
                    'item' => $item,
                ])->render();
            }

            return [
                'items'      => $view_items,
                'paginate' => view('paginations.news_links_limit', ['paginator' => $items])->render()
            ];
        }

        return view('catalog.category', $data);
    }

    public function product(Product $product) {
        $bread = $product->getBread();
        $product = $this->add_region_seo($product);
        $product->setSeo();
//        $params = $product->params()
//            ->where('group', '!=', '')
//            ->get()
//            ->groupBy('group');
        $features = ProductIcon::orderBy('order', 'asc')->get();
        $related = $product->related()->get();

        $catalog = Catalog::whereId($product->catalog_id)->first();
        $maincat = Catalog::where('id', '=', $catalog->parent_id)->first();
        $params = $maincat->params()->get();
//        $add_params = AddParam::where('catalog_id', '=', $maincat->id)
//            ->join('add_params', 'product_add_params.add_param_id', '=', 'add_params.id')
//            ->get();
        $add_params = ProductAddParam::where('product_id', '=', $product->id)
            ->join('add_params', 'product_add_params.add_param_id', '=', 'add_params.id')
            ->groupBy('name')
            ->get();

        $images = $product->images()->get();
        if(!count($images)) {
            $cat_image = $maincat->image;
        }

        if(!$product->text) {
            $text = $maincat->text;
        }

        return view('catalog.product', [
            'product'    => $product,
            'text'       => $text ?? null,
            'bread'      => $bread,
            'name'       => $product->name,
            'specParams' => $product->params_on_spec,
            'params'     => $params ?? null,
            'add_params' => $add_params ?? null,
            'features' => $features,
            'related' => $related,
            'images' => $images ?? null,
            'cat_image' => $cat_image ?? null,
        ]);
    }

}
