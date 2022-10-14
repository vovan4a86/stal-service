<?php namespace App\Http\Controllers;

use DB;
use Fanky\Admin\Models\Catalog;
use Fanky\Admin\Models\City;
use Fanky\Admin\Models\Feedback;
use Fanky\Admin\Models\Order as Order;
use Fanky\Admin\Models\Page;
use Fanky\Admin\Models\Product;
use Fanky\Admin\Models\Setting;
use Illuminate\Http\Request;
use Mail;
use Mailer;
//use Settings;
use Cart;
use Session;
use SiteHelper;
use Validator;

class AjaxController extends Controller {
	private $fromMail = 'info@stalservis96.ru';
	private $fromName = 'Stal-Service';

    //РАБОТА С КОРЗИНОЙ

    public function postAddToCart(Request $request) {
        $id = $request->get('id');
        $count = $request->get('count', 1);
        /** @var Product $product */
        $product = Product::find($id);
        if($product) {

            $image = $product->image;
            $product_item = $product->toArray();
            $product_item['count'] = $count;
            $product_item['url'] = $product->url;
            $product_item['image'] = $image ? $image->thumb(2) : null;


            \Debugbar::log($product_item['image']);

            Cart::add($product_item);
        }
        $header_cart = view('blocks.header_cart')->render();
        $popup = view('blocks.product_added', $product_item)->render();

        return ['header_cart' => $header_cart, 'popup' => $popup];
    }

    public function postEditCartProduct(Request $request) {
        $id = $request->get('id');
        $count = $request->get('count', 1);
        /** @var Product $product */
        $product = Product::find($id);
        if($product) {
            $image = $product->image;
            $product_item = $product->toArray();
            $product_item['count'] = $count;
            $product_item['url'] = $product->url;
//            $product_item['image'] = $image ? $image->thumb(2) : null;

            Cart::add($product_item);
        }

        $popup = view('blocks.cart_popup', $product_item)->render();

        return ['cart_popup' => $popup];
    }

    public function postUpdateToCart(Request $request) {
        $id = $request->get('id');
        $count = $request->get('count', 1);
        Cart::updateCount($id, $count);

        $header_cart = view('blocks.header_cart')->render();

        return ['header_cart' => $header_cart];
    }

    public function postRemoveFromCart(Request $request) {
        $id = $request->get('id');
        Cart::remove($id);

        $sum = Cart::sum();

        $header_cart = view('blocks.header_cart')->render();
        $cart_values = view('blocks.cart_values', ['sum' => $sum ])->render();

        return ['header_cart' => $header_cart, 'cart_values' => $cart_values];
    }

    public function postPurgeCart() {
        Cart::purge();

//        $header_cart = view('cart.index', ['items' => []])->render();

        return [];
    }

    //заявка в свободной форме
    public function postRequest() {
        $data = Request::only(['name', 'phone', 'email', 'text']);
        $valid = Validator::make($data, [
            'name'  => 'required',
            'phone' => 'required',
            'text'  => 'required'
        ], [
            'name.required'  => 'Не заполнено поле Имя',
            'phone.required' => 'Не заполнено поле Телефон',
            'text.required'  => 'Не заполнено поле Сообщение',
        ]);

        if ($valid->fails()) {
            return ['errors' => $valid->messages()];
        } else {
            $feedback_data = [
                'type' => 1,
                'data' => $data
            ];
            $feedback = Feedback::create($feedback_data);
            Mail::send('mail.feedback', ['feedback' => $feedback], function ($message) use ($feedback) {
                $title = $feedback->id . ' | Заявка в свободной форме | Stal-Service';
                $message->from($this->fromMail, $this->fromName)
                    ->to(Settings::get('feedback_email'))
                    ->subject($title);
            });

            return ['success' => true];
        }
    }

    //написать нам
    public function postWriteback() {
        $data = Request::only(['name', 'phone', 'text']);
        $valid = Validator::make($data, [
            'name'  => 'required',
            'phone' => 'required',
        ], [
            'name.required'  => 'Не заполнено поле Имя',
            'phone.required' => 'Не заполнено поле Телефон',
        ]);

        if ($valid->fails()) {
            return ['errors' => $valid->messages()];
        } else {
            $feedback_data = [
                'type' => 2,
                'data' => $data
            ];
            $feedback = Feedback::create($feedback_data);
            Mail::send('mail.feedback', ['feedback' => $feedback], function ($message) use ($feedback) {
                $title = $feedback->id . ' | Написать нам | Stal-Service';
                $message->from($this->fromMail, $this->fromName)
                    ->to(Settings::get('feedback_email'))
                    ->subject($title);
            });

            return ['success' => true];
        }
    }

    //заказать звонок
    public function postCallback() {
        $data = Request::only(['name', 'phone', 'time']);
        $valid = Validator::make($data, [
            'name'  => 'required',
            'phone' => 'required',
        ], [
            'name.required'  => 'Не заполнено поле Имя',
            'phone.required' => 'Не заполнено поле Телефон',
        ]);

        if ($valid->fails()) {
            return ['errors' => $valid->messages()];
        } else {
            $feedback_data = [
                'type' => 3,
                'data' => $data
            ];
            $feedback = Feedback::create($feedback_data);
            Mail::send('mail.feedback', ['feedback' => $feedback], function ($message) use ($feedback) {
                $title = $feedback->id . ' | Заказать звонок | Stal-Service';
                $message->from($this->fromMail, $this->fromName)
                    ->to(Settings::get('feedback_email'))
                    ->subject($title);
            });

            return ['success' => true];
        }
    }

    //быстрый заказ
    public function postFastRequest() {
        $data = Request::only(['name', 'phone']);
        $valid = Validator::make($data, [
            'name' => 'required',
            'phone' => 'required',
        ], [
            'name.required' => 'Не заполнено поле Имя',
            'phone.required' => 'Не заполнено поле Телефон',
        ]);

        if ($valid->fails()) {
            return ['errors' => $valid->messages()];
        } else {
            $feedback_data = [
                'type' => 4,
                'data' => $data
            ];
            $feedback = Feedback::create($feedback_data);
            Mail::send('mail.feedback', ['feedback' => $feedback], function ($message) use ($feedback) {
                $title = $feedback->id . ' | Быстрый заказ | Stal-Service';
                $message->from($this->fromMail, $this->fromName)
                    ->to(Settings::get('feedback_email'))
                    ->subject($title);
            });

            return ['success' => true];
        }
    }

    //остались вопросы?
    public function postQuestions() {
        $data = Request::only(['phone']);
        $valid = Validator::make($data, [
            'phone' => 'required',
        ], [
            'phone.required' => 'Не заполнено поле Телефон',
        ]);

        if ($valid->fails()) {
            return ['errors' => $valid->messages()];
        } else {
            $feedback_data = [
                'type' => 5,
                'data' => $data
            ];
            $feedback = Feedback::create($feedback_data);
            Mail::send('mail.feedback', ['feedback' => $feedback], function ($message) use ($feedback) {
                $title = $feedback->id . ' | Отались вопросы | Stal-Service';
                $message->from($this->fromMail, $this->fromName)
                    ->to(Settings::get('feedback_email'))
                    ->subject($title);
            });

            return ['success' => true];
        }
    }

    //заявка в свободной форме
    public function postContactUs() {
        $data = Request::only(['name', 'phone', 'text']);
        $valid = Validator::make($data, [
            'name'  => 'required',
            'phone' => 'required',
            'text'  => 'required'
        ], [
            'name.required'  => 'Не заполнено поле Имя',
            'phone.required' => 'Не заполнено поле Телефон',
            'text.required'  => 'Не заполнено поле Сообщение',
        ]);

        if ($valid->fails()) {
            return ['errors' => $valid->messages()];
        } else {
            $feedback_data = [
                'type' => 6,
                'data' => $data
            ];
            $feedback = Feedback::create($feedback_data);
            Mail::send('mail.feedback', ['feedback' => $feedback], function ($message) use ($feedback) {
                $title = $feedback->id . ' | Свяжитесь с нами | Stal-Service';
                $message->from($this->fromMail, $this->fromName)
                    ->to(Settings::get('feedback_email'))
                    ->subject($title);
            });

            return ['success' => true];
        }
    }

    //ОФОРМЛЕНИЕ ЗАКАЗА
    public function postOrder(Request $request) {
        $data = $request->only([
            'name',
            'phone',
            'email',
            'user',
            'text',
            'inn',
            'company',
            'address',
            'timing',
            'delivery_method',
            'summ',
//            'payment_method',
        ]);
        $file = $data['file'] = Request::file('file');

        $messages = array(
            'email.required'           => 'Не указан ваш e-mail адрес!',
            'email.email'              => 'Не корректный e-mail адрес!',
            'name.required'            => 'Не заполнено поле Имя',
            'phone.required'           => 'Не заполнено поле Телефон',
            'delivery_method.required' => 'Не выбран способ доставки',
//            'payment_method.required'  => 'Не выбран способ оплаты',
        );

        $valid = Validator::make($data, [
            'user' => 'required|numeric',
            'name' => 'required',
            'phone' => 'required',
            'inn' => 'required_if:user,0',
            'company' => 'required_if:user,0',
            'delivery_method' => 'required',
			'summ'     => 'required|min:1',
            'address' => 'required_if:delivery_method,0',
            'file'    => 'nullable|max:5120|mimes:jpg,jpeg,png,pdf,doc,docs,xls,xlsx',
		], $messages);
        if($valid->fails()){
            return ['errors' => $valid->messages()];
        }
        if($file) {
            $file_name = md5(uniqid(rand(), true)) . '.' . $file->getClientOriginalExtension();
            $file->move(base_path() . Order::UPLOAD_PATH, $file_name);
            $data['file'] = $file_name;
        }

        $order = Order::create($data);
        $items = Cart::all();
        $summ = 0;
        $all_count = 0;
        foreach ($items as $item) {
            $order->products()->attach($item['id'], [
                'count' => $item['count'],
                'price' => $item['price']
            ]);
            $summ += $item['count'] * $item['price'];
            $all_count += $item['count'];
        }
        $order->update(['summ' => $summ]);

//        $data['total_sum'] = Cart::getRawTotalSum();
//        $order = Order::create($data);
//        $cart = Cart::getCart();
//        foreach ($cart as $item){
//            $product = array_get($item, 'model');
//            $product->update(['order_count' => $product->order_count +1]);
//            $size = array_get($item, 'size') ? array_get($item, 'size'): $product->param_size;
//            $order_item_data = [
//                'order_id'	=> $order->id,
//                'product_id'	=> array_get($item, 'id'),
//                'product_name'	=> $product->name,
//                'size'	=> $size,
//                'count'	=> array_get($item, 'count'),
//                'price'	=> array_get($item, 'price'),
//            ];
//            OrderItem::create($order_item_data);
//        }

//        if($data['payment_method'] == 3) {
//            return ['success' => true, 'redirect' => route('pay.order', ['id' => $order->id])];
//        }

        Mail::send('mail.new_order', ['order' => $order], function ($message) use ($order) {
            $title = $order->id . ' | Новый заказ | Stal-Service';
            $message->from($this->fromMail, $this->fromName)
                ->to(Settings::get('feedback_email'))
                ->subject($title);
        });

        Cart::purge();

        return ['success' => true, 'redirect' => url('/order-success', ['id' => $order->id])];
    }

    //РАБОТА С ГОРОДАМИ
    public function postSetCity() {
        $city_id = Request::get('city_id');
        $city = City::find($city_id);
        session(['change_city' => true]);
        if($city) {
            $result = [
                'success' => true,
            ];
            session(['city_alias' => $city->alias]);

            return response(json_encode($result))->withCookie(cookie('city_id', $city->id));
        } elseif($city_id == 0) {
            $result = [
                'success' => true,
            ];
            session(['city_alias' => '']);

            return response(json_encode($result))->withCookie(cookie('city_id', 0));
        }

        return ['success' => false, 'msg' => 'Город не найден'];
    }

    public function postGetCorrectRegionLink() {
        $city_id = Request::get('city_id');
        $city = City::find($city_id);
        $cur_url = Request::get('cur_url');

        if($cur_url != '/') {
            $url = $cur_url;
            $path = explode('/', $cur_url);
            $cities = getCityAliases();
            /* проверяем - региональная ссылка или федеральная */
            if(in_array($path[0], $cities)) {
                if($city) {
                    $path[0] = $city->alias;
                } else {
                    array_shift($path);
                }
            } else {
                if($city && !in_array($path[0], Page::$excludeRegionAlias)) {
                    array_unshift($path, $city->alias);
                }
            }
            $url = '/' . implode('/', $path);
        } else { //Если на главной
//			if($city){
//				$url = '/' . $city->alias;
//			} else {
//				$url = $cur_url;
//			}
            $url = '/';
        }

        return ['redirect' => $url];
    }

    public function showCitiesPopup() {
        $cities = City::query()->orderBy('name')
            ->get(['id', 'alias', 'name', DB::raw('LEFT(name,1) as letter')]);
        $citiesArr = [];
        if(count($cities)) {
            foreach($cities as $city) {
                $citiesArr[$city->letter][] = $city; //Группировка по первой букве
            }
        }

        $mainCities = City::query()->orderBy('name')
            ->whereIn('id', [
                3, // msk
                5, //spb
            ])->get(['id', 'alias', 'name']);
        $curUrl = url()->previous() ?: '/';
        $curUrl = str_replace(url('/') . '/', '', $curUrl);

        $current_city = SiteHelper::getCurrentCity();

        return view('blocks.popup_cities', [
            'cities' => $citiesArr,
            'mainCities' => $mainCities,
            'curUrl' => $curUrl,
            'current_city' => $current_city,
        ]);
    }

    public function search(Request $request) {
        $data = $request->only(['search']);

        $items = null;

        $page = Page::getByPath(['search']);
        $bread = $page->getBread();

        return [
            'success' => true,
            'redirect' => url('/search', [
                'bread' => $bread,
                'items' => $items,
                'data' => $data,
            ])];

//        return view('search.index', [
//            'bread' => $bread,
//            'items' => $items,
//            'data' => $data,
//        ]);

    }

    public function changeProductsPerPage(Request $request) {
        $count = $request->only('num');

        $setting = Setting::find(9);
        if($setting) {
            $setting->value = $count['num'];
            $setting->save();
            return ['result' => true];
        } else {
            return ['result' => false];
        }
    }

    public function postSetView($view) {
        $view = $view == 'list' ? 'list': 'grid';
        session(['catalog_view' => $view]);

        return ['success' => true];
    }

    public function postUpdateFilter(Request $request) {
        $column1 = $request->only('column1');
        $column2 = $request->get('column2');
        $category_id = $request->get('category_id');
        $filter_name = $request->get('filter_name');

        \Debugbar::log($column1);
        \Debugbar::log($column2);
        \Debugbar::log($category_id);
        \Debugbar::log($filter_name);

        $category = Catalog::find($category_id)->first();

        if($category->parent_id !== 0) {
            $root = $category->findRootCategory($category->parent_id);
        } else {
            $root = $category;
        }

        if ($category->parent_id == 0) {
            $ids = $category->getRecurseChildrenIds();
            $items = Product::public()->whereIn('catalog_id', $ids)
                ->where($filter_name, '=', $column2)
                ->orderBy('name', 'asc')
                ->paginate(10);
        } else {
            $items = $category->products()->where($filter_name, '=', 100)->paginate(10);
        }

        $filters = $root->filters()->get();
        $sort = [];
        foreach ($filters as $filter) {
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
        }

//        $list = view('catalog.views.list', [
//            'items' => $items,
//            'category' => $category,
//            'filters' => $filters,
//            'sort' => $sort,
//            'root' => $root,
//            'per_page' => 10,
//        ])->render();

        $list = [];
        foreach ($items as $item) {
            $list[] = view('catalog.list_row', [
                'item' => $item,
                'filters' => $filters,
                'sort' => $sort,
                'root' => $root,
                'per_page' => 10,
            ])->render();
        }

        return ['success' => true, 'list' => $list];

    }
}
