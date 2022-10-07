<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Fanky\Admin\Models\Catalog;
use Fanky\Admin\Models\CatalogParam;
use Fanky\Admin\Models\Param;
use Fanky\Admin\Models\Product;
use Fanky\Admin\Text;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use SiteHelper;
use Symfony\Component\DomCrawler\Crawler;

class ParseAllProducts extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse';
    private $baseUrl = 'https://www.spk.ru';
    public $client;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->client = new Client();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
//        $this->parseProfileTubes( 'https://www.spk.ru/catalog/metalloprokat/trubniy-prokat/truba-profilnaya/');

//		foreach ($this->getOtherTubesList() as $categoryUrl) {
//            $this->parseOtherTubes($categoryUrl);
//		}

//        $this->parseShvellers( 'https://www.spk.ru/catalog/metalloprokat/fasonniy-prokat/shveller/');

//        $this->parseUgolok( 'https://www.spk.ru/catalog/metalloprokat/fasonniy-prokat/ugolok/');
//        $this->parseArmatura( 'https://www.spk.ru/catalog/metalloprokat/sortovoy-prokat/armatura/');
        $this->parseKatanka( 'https://www.spk.ru/catalog/metalloprokat/sortovoy-prokat/katanka/');

        $this->info('The command was successful!');
        /**
        $products = Engine::whereNotNull('parse_url')
            ->whereNotIn('parse_url', [''])
//			->whereId(12)
//			->whereNull('parse_date')
            ->get();
        foreach ($products as $product) {
            $this->parseProduct($product);
        }
        */
    }

    public function parseProduct(Product $product) {
        $this->info("product_id: {$product->id}, url: {$product->parse_url}");
        $res = $this->client->get($product->parse_url);
        $html = $res->getBody()->getContents();
        $crawler = new Crawler($html);
        $articul = $crawler->filter('.vendorcode')->text();
        $data = [];
        $data['articul'] = str_after($articul, 'Артикул: Двигатель Deutz ');
        $data['brand'] = 'Deutz';
        $crawler->filter('.main_info table tr')->each(function (Crawler $node, $i) use (&$data) {
            $name = trim($node->filter('td')->eq(0)->text(), ":\ \t\n\r\0\x0B");
            $val = trim($node->filter('td')->eq(1)->text(), ":\ \t\n\r\0\x0B");
            switch ($name) {
                case 'Тип двигателя':
                    $data['engine_type'] = $val;
                    break;
                case 'Мощность генератора (LTP) 50 Гц, кВт':
                case 'Мощность, кВт':
                    $data['power'] = $val;
                    break;
                case 'Объем, л':
                    $data['capacity'] = $val;
                    break;
            }
        });
        $specifications = '<table><tbody>';
        $crawler->filter('.specifications__table .specifications__table-row')->each(function (Crawler $node, $i) use (&$specifications) {
            $name = trim($node->filter('.specifications__table-row-col')->eq(0)->text(), ":\ \t\n\r\0\x0B");
            $val = trim($node->filter('.specifications__table-row-col')->eq(1)->text(), ":\ \t\n\r\0\x0B");
            $specifications .= "<tr><td>$name</td><td>$val</td></tr>";
        });
        $specifications .= '</tbody></table>';
        $data['specifications'] = $specifications;
        $data['text_description'] = trim($crawler->filter('.allspecifications-tabs .tab-content .tab-pane')->eq(1)->html());
        $data['text_description'] = preg_replace('/ style=\'[^\']+\'/', '', $data['text_description']);
        if(!count($crawler->filter('.price_noauth .price'))){
            $price = 0;
        } else {
            $price = trim($crawler->filter('.price_noauth .price')->first()->text());
            $price = preg_replace("/[^0-9]/", '', $price);
        }
        $data['price'] = $price;
        $data['parse_date'] = Carbon::now();
        $product->fill($data)->save();
        if (!$product->images()->count()) {
            $src = $this->baseUrl . $crawler->filter('.product_slider_img-one .item img')->first()->attr('src');
            $image = SiteHelper::uploadImage($src, 'engine_images');
            if ($image) {
                EngineImage::create([
                    'engine_id' => $product->id,
                    'order'     => 0,
                    'image'     => $image
                ]);
            }
        }
    }



    //Труба профильная
    public function parseProfileTubes($categoryUrl) {
        $this->info('parse url: ' . $categoryUrl);
        $res = $this->client->get($categoryUrl);
        $html = $res->getBody()->getContents();
        $crawler = new Crawler($html);
        $categoryNameRaw = strip_tags(trim(($crawler->filter('h1')->first()->text())));
        $categoryName = trim(str_ireplace('в Екатеринбурге', '', $categoryNameRaw));
        $catalog = $this->getCatalogByName($categoryName);

        $crawler->filter('.product-card__wrap_list-alt-wrap .product-card')->each(function (Crawler $node, $i) use ($catalog) {
            $name = trim($node->filter('a.product-card__title-link')->first()->text());

            if($node->filter('.product__stock-in')->count()) {
                $in_stock = 1;
            } else {
                $in_stock = 0;
            }

            $url = $this->baseUrl . trim($node->filter('a.product-card__title-link')->first()->attr('href'));

            $inner_product = $this->client->get($url);
            $inner_html = $inner_product->getBody()->getContents();
            $inner_crawler = new Crawler($inner_html);
            $price = preg_replace("/[^,.0-9]/", '', $inner_crawler->filter('.product-multiple__price-item')->first()->text());

            $length_elem = $inner_crawler->filter('.product-multiple__item-wrap .form__select')->first();
            $length = preg_replace("/[^,.0-9]/", '', $length_elem->filter('.form__select-element option')->first()->text());

            $chars = [];
            $inner_crawler->filter('.product__char')->each(function (Crawler $node, $i) use (&$chars){
                $chars[$i] = $node->filter('.product__char-val')->first()->text();
            });

            $subname = 'Труба профильная ' . $chars[0];
            $sub_catalog = $this->getSubCatalogByName($subname, $catalog->id);

            $product = Product::whereParseUrl($url)->first();
            if (!$product) {
                Product::create([
                    'name'        => $name,
                    'catalog_id' =>  $sub_catalog->id,
                    'title'       => $name,
                    'alias'       => Text::translit($name),
                    'parse_url'   => $url,
                    'published'   => 1,
                    'order'       => $catalog->products()->max('order') + 1,
                    'width1'      => $chars[0],
                    'width2'      => $chars[1],
                    'wall'        => $chars[2],
                    'ploskoval'   => $chars[3],
                    'gost'        => $chars[5],
                    'condition'   => $chars[6],
                    'length'      => $length,
                    'price'       => $price,
                    'in_stock'    => $in_stock,
                ]);
            }
        });

        if ($crawler->filter('a.pager__right')->count()) {
            $nextUrl = $this->baseUrl . $crawler->filter('a.pager__right')->first()->attr('href');
            $this->parseCategory($nextUrl);
        }
    }

    //Труба ЭС, труба ВГП
    public function getOtherTubesList() {
        return [
            'https://www.spk.ru/catalog/metalloprokat/trubniy-prokat/truba-e-s/',
            'https://www.spk.ru/catalog/metalloprokat/trubniy-prokat/truba-vgp/'
        ];
    }
    public function parseOtherTubes($categoryUrl) {
        $this->info('parse url: ' . $categoryUrl);
        $res = $this->client->get($categoryUrl);
        $html = $res->getBody()->getContents();
        $crawler = new Crawler($html);
        $categoryNameRaw = strip_tags(trim(($crawler->filter('h1')->first()->text())));
        $categoryName = trim(str_ireplace('в Екатеринбурге', '', $categoryNameRaw));
        $catalog = $this->getCatalogByName($categoryName);

        $crawler->filter('.product-card__wrap_list-alt-wrap .product-card')->each(function (Crawler $node, $i) use ($catalog, $categoryName) {
            $name = trim($node->filter('a.product-card__title-link')->first()->text());

            if($node->filter('.product__stock-in')->count()) {
                $in_stock = 1;
            } else {
                $in_stock = 0;
            }

            $url = $this->baseUrl . trim($node->filter('a.product-card__title-link')->first()->attr('href'));

            $inner_product = $this->client->get($url);
            $inner_html = $inner_product->getBody()->getContents();
            $inner_crawler = new Crawler($inner_html);
            $price = preg_replace("/[^,.0-9]/", '', $inner_crawler->filter('.product-multiple__price-item')->first()->text());

            $length_elem = $inner_crawler->filter('.product-multiple__item-wrap .form__select')->first();
            if($length_elem->filter('.form__select-element option')->count() !== 0) {
                $length = preg_replace("/[^,.0-9]/", '', $length_elem->filter('.form__select-element option')->first()->text());
            } else {
                $length = null;
            }

            $chars = [];
            $inner_crawler->filter('.product__char')->each(function (Crawler $node, $i) use (&$chars){
                $chars[$i] = $node->filter('.product__char-val')->first()->text();
            });

            $subname = $categoryName . ' ' . $chars[0];
            $sub_catalog = $this->getSubCatalogByName($subname, $catalog->id);

            $product = Product::whereParseUrl($url)->first();
            if (!$product) {
                Product::create([
                    'name'        => $name,
                    'catalog_id' =>  $sub_catalog->id,
                    'title'       => $name,
                    'alias'       => Text::translit($name),
                    'parse_url'   => $url,
                    'published'   => 1,
                    'order'       => $catalog->products()->max('order') + 1,
                    'diameter'      => $chars[0],
                    'wall'        => $chars[1],
                    'was_used'   => $chars[2],
                    'condition'   => $chars[3],
                    'length'      => $length,
                    'price'       => $price,
                    'in_stock'    => $in_stock,
                ]);
            } else {
//                $product->price = $price;
//                $product->in_stock = $in_stock;
//                $product->save();
            }
        });

        if ($crawler->filter('a.pager__right')->count()) {
            $nextUrl = $this->baseUrl . $crawler->filter('a.pager__right')->first()->attr('href');
            $this->parseOtherTubes($nextUrl);
        }
    }

    //Швеллер
    public function parseShvellers($categoryUrl) {
        $this->info('parse url: ' . $categoryUrl);
        $res = $this->client->get($categoryUrl);
        $html = $res->getBody()->getContents();
        $crawler = new Crawler($html);
        $categoryNameRaw = strip_tags(trim(($crawler->filter('h1')->first()->text())));
        $categoryName = trim(str_ireplace('в Екатеринбурге', '', $categoryNameRaw));
        $catalog = $this->getCatalogByName($categoryName);

        $crawler->filter('.product-card__wrap_list-alt-wrap .product-card')->each(function (Crawler $node, $i) use ($catalog) {
            $name = trim($node->filter('a.product-card__title-link')->first()->text());

            if($node->filter('.product__stock-in')->count()) {
                $in_stock = 1;
            } else {
                $in_stock = 0;
            }

            $url = $this->baseUrl . trim($node->filter('a.product-card__title-link')->first()->attr('href'));

            $inner_product = $this->client->get($url);
            $inner_html = $inner_product->getBody()->getContents();
            $inner_crawler = new Crawler($inner_html);
            $price = preg_replace("/[^,.0-9]/", '', $inner_crawler->filter('.product-multiple__price-item')->first()->text());

//            $length_elem = $inner_crawler->filter('.product-multiple__item-wrap .form__select')->first();
//            $length = preg_replace("/[^,.0-9]/", '', $length_elem->filter('.form__select-element option')->first()->text());

            $chars = [];
            $inner_crawler->filter('.product__char')->each(function (Crawler $node, $i) use (&$chars){
                $chars[$i] = $node->filter('.product__char-val')->first()->text();
            });

            $subname = 'Швеллер ' . $chars[0];
            $sub_catalog = $this->getSubCatalogByName($subname, $catalog->id);

            $product = Product::whereParseUrl($url)->first();
            if (!$product) {
                Product::create([
                    'name'        => $name,
                    'catalog_id' =>  $sub_catalog->id,
                    'title'       => $name,
                    'alias'       => Text::translit($name),
                    'parse_url'   => $url,
                    'published'   => 1,
                    'order'       => $catalog->products()->max('order') + 1,
                    'profile'      => $chars[0],
                    'steel'      => $chars[1],
                    'length'        => $chars[2],
                    'condition'   => $chars[3],
                    'mark'        => $chars[4],
                    'price'       => $price,
                    'in_stock'    => $in_stock,
                ]);
            }
        });

        if ($crawler->filter('a.pager__right')->count()) {
            $nextUrl = $this->baseUrl . $crawler->filter('a.pager__right')->first()->attr('href');
            $this->parseShvellers($nextUrl);
        }
    }

    //Уголок
    public function parseUgolok($categoryUrl) {
        $this->info('parse url: ' . $categoryUrl);
        $res = $this->client->get($categoryUrl);
        $html = $res->getBody()->getContents();
        $crawler = new Crawler($html);
        $categoryNameRaw = strip_tags(trim(($crawler->filter('h1')->first()->text())));
        $categoryName = trim(str_ireplace('в Екатеринбурге', '', $categoryNameRaw));
        $catalog = $this->getCatalogByName($categoryName);

        $crawler->filter('.product-card__wrap_list-alt-wrap .product-card')->each(function (Crawler $node, $i) use ($catalog) {
            $name = trim($node->filter('a.product-card__title-link')->first()->text());

            if($node->filter('.product__stock-in')->count()) {
                $in_stock = 1;
            } else {
                $in_stock = 0;
            }

            $url = $this->baseUrl . trim($node->filter('a.product-card__title-link')->first()->attr('href'));

            $inner_product = $this->client->get($url);
            $inner_html = $inner_product->getBody()->getContents();
            $inner_crawler = new Crawler($inner_html);
            $price = preg_replace("/[^,.0-9]/", '', $inner_crawler->filter('.product-multiple__price-item')->first()->text());

//            $length_elem = $inner_crawler->filter('.product-multiple__item-wrap .form__select')->first();
//            $length = preg_replace("/[^,.0-9]/", '', $length_elem->filter('.form__select-element option')->first()->text());

            $chars = [];
            $inner_crawler->filter('.product__char')->each(function (Crawler $node, $i) use (&$chars){
                $chars[$i] = $node->filter('.product__char-val')->first()->text();
            });

            $subname = 'Уголок ' . $chars[0];
            $sub_catalog = $this->getSubCatalogByName($subname, $catalog->id);

            $product = Product::whereParseUrl($url)->first();
            if (!$product) {
                Product::create([
                    'name'        => $name,
                    'catalog_id' =>  $sub_catalog->id,
                    'title'       => $name,
                    'alias'       => Text::translit($name),
                    'parse_url'   => $url,
                    'published'   => 1,
                    'order'       => $catalog->products()->max('order') + 1,
                    'width1'      => $chars[0],
                    'width2'      => $chars[1],
                    'wall'        => $chars[2],
                    'length'   => $chars[3],
                    'steel'        => $chars[4],
                    'condition'        => $chars[5],
                    'price'       => $price,
                    'in_stock'    => $in_stock,
                ]);
            }
        });

        if ($crawler->filter('a.pager__right')->count()) {
            $nextUrl = $this->baseUrl . $crawler->filter('a.pager__right')->first()->attr('href');
            $this->parseUgolok($nextUrl);
        }
    }

    //Арматура
    public function parseArmatura($categoryUrl) {
        $this->info('parse url: ' . $categoryUrl);
        $res = $this->client->get($categoryUrl);
        $html = $res->getBody()->getContents();
        $crawler = new Crawler($html);
        $categoryNameRaw = strip_tags(trim(($crawler->filter('h1')->first()->text())));
        $categoryName = trim(str_ireplace('в Екатеринбурге', '', $categoryNameRaw));
        $catalog = $this->getCatalogByName($categoryName);

        $crawler->filter('.product-card__wrap_list-alt-wrap .product-card')->each(function (Crawler $node, $i) use ($catalog) {
            $name = trim($node->filter('a.product-card__title-link')->first()->text());

            //если товар не в наличии, то следующий
            if($node->filter('.product__stock-in')->count()) {
                $in_stock = 1;

                $url = $this->baseUrl . trim($node->filter('a.product-card__title-link')->first()->attr('href'));

                $inner_product = $this->client->get($url);
                $inner_html = $inner_product->getBody()->getContents();
                $inner_crawler = new Crawler($inner_html);
                $price = preg_replace("/[^,.0-9]/", '', $inner_crawler->filter('.product-multiple__price-item')->first()->text());

//            $length_elem = $inner_crawler->filter('.product-multiple__item-wrap .form__select')->first();
//            $length = preg_replace("/[^,.0-9]/", '', $length_elem->filter('.form__select-element option')->first()->text());

                $chars = [];
                $inner_crawler->filter('.product__char')->each(function (Crawler $node, $i) use (&$chars){
                    $chars[$i] = $node->filter('.product__char-val')->first()->text();
                });

                $subname = 'Арматура ' . $chars[0];
                $sub_catalog = $this->getSubCatalogByName($subname, $catalog->id);

                $product = Product::whereParseUrl($url)->first();
                if (!$product) {
                    Product::create([
                        'name'        => $name,
                        'catalog_id' =>  $sub_catalog->id,
                        'title'       => $name,
                        'alias'       => Text::translit($name),
                        'parse_url'   => $url,
                        'published'   => 1,
                        'order'       => $catalog->products()->max('order') + 1,
                        'diameter'      => $chars[0],
                        'length'      => $chars[1],
                        'class'        => $chars[2],
                        'steel'   => $chars[3],
                        'condition'        => $chars[4],
                        'gost'        => $chars[5],
                        'price'       => $price,
                        'in_stock'    => $in_stock,
                    ]);
                }
            }
        });

        if ($crawler->filter('a.pager__right')->count()) {
            $nextUrl = $this->baseUrl . $crawler->filter('a.pager__right')->first()->attr('href');
            $this->parseArmatura($nextUrl);
        }
    }

    //Арматура
    public function parseKatanka($categoryUrl) {
        $this->info('parse url: ' . $categoryUrl);
        $res = $this->client->get($categoryUrl);
        $html = $res->getBody()->getContents();
        $crawler = new Crawler($html);
        $categoryNameRaw = strip_tags(trim(($crawler->filter('h1')->first()->text())));
        $categoryName = trim(str_ireplace('в Екатеринбурге', '', $categoryNameRaw));
        $catalog = $this->getCatalogByName($categoryName);

        $crawler->filter('.product-card__wrap_list-alt-wrap .product-card')->each(function (Crawler $node, $i) use ($catalog, $categoryName) {
            $name = trim($node->filter('a.product-card__title-link')->first()->text());

            //если товар не в наличии, то следующий
            if($node->filter('.product__stock-in')->count()) {
                $in_stock = 1;

                $url = $this->baseUrl . trim($node->filter('a.product-card__title-link')->first()->attr('href'));

                $inner_product = $this->client->get($url);
                $inner_html = $inner_product->getBody()->getContents();
                $inner_crawler = new Crawler($inner_html);
                $price = preg_replace("/[^,.0-9]/", '', $inner_crawler->filter('.product-multiple__price-item')->first()->text());

//            $length_elem = $inner_crawler->filter('.product-multiple__item-wrap .form__select')->first();
//            $length = preg_replace("/[^,.0-9]/", '', $length_elem->filter('.form__select-element option')->first()->text());

                $char_keys = [];
                $chars = [];
                $inner_crawler->filter('.product__char')->each(function (Crawler $node, $i) use (&$chars, &$char_keys){
                    $char_keys[$i] = trim($node->filter('.product__char-key')->first()->text());
                    $chars[$i] = trim($node->filter('.product__char-val')->first()->text());
                });

                $subname = $categoryName . ' ' . $chars[0];
                $sub_catalog = $this->getSubCatalogByName($subname, $catalog->id);

                $data = [];
                foreach ($char_keys as $i => $key) {
                    $data[Text::translit($key)] = $chars[$i];
                    $param = Param::whereName($key)->first();
                    if(!$param) {
                        $param = Param::create([
                            'name' => $key,
                            'alias' => Text::translit($key)
                        ]);
                        CatalogParam::create([
                            'catalog_id' => $catalog->id,
                            'param_id' => $param->id,
                            'order' => CatalogParam::where('catalog_id', '=', $catalog->id)->max('order') + 1,
                        ]);
                    } else {
                        $used = CatalogParam::where('catalog_id', '=', $catalog->id)->pluck('param_id')->all();
                        if(!in_array($param->id, $used)) {
                            CatalogParam::create([
                                'catalog_id' => $catalog->id,
                                'param_id' => $param->id,
                                'order' => CatalogParam::where('catalog_id', '=', $catalog->id)->max('order') + 1,
                            ]);
                        }
                    }
                }

                $product = Product::whereParseUrl($url)->first();
                if (!$product) {
                    Product::create(array_merge([
                        'name'        => $name,
                        'catalog_id' =>  $sub_catalog->id,
                        'title'       => $name,
                        'alias'       => Text::translit($name),
                        'parse_url'   => $url,
                        'published'   => 1,
                        'order'       => $catalog->products()->max('order') + 1,
                        'price'       => $price,
                        'in_stock'    => $in_stock,
                    ], $data));
                }
            }
        });

        if ($crawler->filter('a.pager__right')->count()) {
            $nextUrl = $this->baseUrl . $crawler->filter('a.pager__right')->first()->attr('href');
            $this->parseKatanka($nextUrl);
        }
    }


    /**
     * @param string $categoryName
     *
     * @return Catalog
     */
    private function getCatalogByName($categoryName) {
        $catalog = Catalog::whereName($categoryName)->first();
        if (!$catalog) {
            $catalog = Catalog::create([
                'name'      => $categoryName,
                'title'     => $categoryName,
                'h1' => $categoryName,
                'parent_id' => 0,
                'alias'     => Text::translit($categoryName),
                'slug'      => Text::translit($categoryName),
                'order'     => Catalog::whereParentId(0)->max('order') + 1,
                'published' => 1,
            ]);
        }

        return $catalog;
    }

    private function getSubCatalogByName($categoryName, $parent_id) {
        $catalog = Catalog::whereName($categoryName)->first();
        if (!$catalog) {
            $catalog = Catalog::create([
                'name'      => $categoryName,
                'title'     => $categoryName,
                'h1'        => $categoryName,
                'parent_id' => $parent_id,
                'alias'     => Text::translit($categoryName),
                'slug'      => Text::translit($categoryName),
                'order'     => Catalog::whereParentId($parent_id)->max('order') + 1,
                'published' => 1,
            ]);
        }

        return $catalog;
    }
}
