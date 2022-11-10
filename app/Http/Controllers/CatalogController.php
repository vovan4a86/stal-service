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

        $root = $category;
        while($root->parent_id !== 0) {
            $root = $root->findRootCategory($root->parent_id);
        }

        $per_page = Request::get('pages');
        $per_page = is_numeric($per_page) ? $per_page : \Settings::get('product_per_page');
        $data['per_page'] = $per_page;

        $parentIds = Catalog::where('parent_id', '=', '0')->pluck('id')->all();

        $ids = [];
        if(count($children)) {
            $ids = $category->getRecurseChildrenIds();
        } else {
            $ids = $category->getRecurseChildrenIdsInner();
        }

        $items = Product::public()->whereIn('catalog_id', $ids)
            ->orderBy('name')->paginate($per_page);

//        $ids = null;
//        if(in_array($category->id, $parentIds)) {
//            $ids = $category->getRecurseChildrenIds();
//            $items = Product::public()->whereIn('catalog_id', $ids)
//                ->orderBy('name', 'asc')->paginate($per_page);
//            $is_subcategory = false;
//        } else {
//            $items = $category->products()->paginate($per_page);
//            $is_subcategory = true;
//        }
//        dd($is_subcategory);


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
            'is_subcategory' => $is_subcategory ?? null,
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
            $column1 = Request::only('column1');
            $column2 = Request::only('column2');
            $filter_name1 = Request::get('filter_name1');
            $filter_name2 = Request::get('filter_name2');

            $queries = [];
            if (count($column1)) {
                foreach ($column1 as $name => $values) {
                    foreach ($values as $value) {
                        $queries[$filter_name1][] = [$value];
                    }
                }
            }

            if (count($column2)) {
                foreach ($column2 as $name => $values) {
                    foreach ($values as $value) {
                        $queries[$filter_name2][] = [$value];
                    }
                }
            }

            if(count($queries)) {
                $prods_id = []; //все найденные id продуктов
                foreach ($queries as $name => $values) {
                    foreach ($values as $value) {
                        $prods_id[] = Product::where('catalog_id', $category->id)->where($name, $value)->pluck('id');
                    }
                }

                $products_ids = [];
                foreach ($prods_id as $items) {
                    foreach ($items as $item) {
                        $products_ids[] = $item;
                    }
                }
                \Debugbar::log($products_ids);
                $items = Product::whereIn('id', $products_ids)
                    ->orderBy('name')->paginate($per_page);
            }
            $view_items = [];
            foreach ($items as $item) {
                $view_items[] = view('catalog.list_row', [
                    'item' => $item,
                    'category' => $category,
                    'sort' => $sort,
                    'root' => $root,
                    'filters' => $filters,
                    'per_page' => $per_page
                ])->render();
            }

            return response()->json([
                'items' => $view_items,
                'paginate' => view('catalog.list_pagination', [
                    'items' => $items,
                ])->render(),
//                'perpage' => view('catalog.views.per_page', [
//                    'category' => $category,
//                    'per_page' => $per_page
//                ])->render()
            ]);
        }

        return view('catalog.category', $data);
    }

    public function product(Product $product) {
        $bread = $product->getBread();
        $product = $this->add_region_seo($product);
        $product->setSeo();
        $features = ProductIcon::orderBy('order', 'asc')->get();

        $catalog = Catalog::whereId($product->catalog_id)->first();
        $maincat = Catalog::where('id', '=', $catalog->parent_id)->first();
        $params = $maincat->params()->get();

        $add_params = ProductAddParam::where('product_id', '=', $product->id)
            ->join('add_params', 'product_add_params.add_param_id', '=', 'add_params.id')
            ->groupBy('name')
            ->get();

        $related = $product->related()->get(); //похожие товары добавленные из админки

        //похожие товары, добавленные вручную + из той же подкатегории
        $related_from_cat = Product::whereCatalogId($catalog->id)
            ->where('id', '<>', $product->id)->get();

        //если товаров в подкатегории нет => 10 случайных в категории
        if(!count($related_from_cat)) {
            $related_cat = $maincat->getAllPublicChildren()->pluck('id')->all();
            //20 товаров из той же категории
            $related_from_cat = Product::whereIn('catalog_id', $related_cat)
                ->where('id', '<>', $product->id)->get()->random(10);
//            $related = $related->merge($related_from_cat);
        }

        $related = $related->merge($related_from_cat);

        $images = $product->images()->get();

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
