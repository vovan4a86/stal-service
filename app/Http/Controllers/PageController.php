<?php namespace App\Http\Controllers;

use App;
use Fanky\Admin\Models\Catalog;
use Fanky\Admin\Models\Page;
use SEOMeta;

class PageController extends Controller {

	public function page($alias = null) {
		$path = explode('/', $alias);
        if (!$alias) {
            $current_city = App::make('CurrentCity');
            $this->city = $current_city && $current_city->id ? $current_city : null;
            $page = $this->city->generateIndexPage();
        } else {
            $page = Page::getByPath($path);
            if (!$page) abort(404, 'Страница не найдена');
        }
        /** @var Page $page */
		$children = $page->getPublicChildren();
        $bread = $page->getBread();
        $page->h1 = $page->getH1();
        $page = $this->add_region_seo($page);
		$view = $page->getView();
		$page->ogGenerate();
        $page->setSeo();

        if($page->alias = 'sitemap') {
            $catalog = Catalog::public()->whereParentId(0)->get();
            $sitemap = Page::find(1)->getPublicChildren();
        }

		return response()->view($view, [
			'page'        => $page,
			'h1'          => $page->h1,
			'text'        => $page->text,
			'bread'       => $bread,
			'children'    => $children,
            'sitemap'     => $sitemap ?? null,
            'catalog' => $catalog ?? null,
		]);
	}

	public function robots() {
		$robots = new App\Robots();
		if (App::isLocal()) {
			$robots->addUserAgent('*');
			$robots->addDisallow('/');
		} else {
			$robots->addUserAgent('*');
			$robots->addDisallow('/admin');
			$robots->addDisallow('/ajax');
		}

		$robots->addHost(env('BASE_URL'));
		$robots->addSitemap(url('sitemap.xml'));

		$response = response($robots->generate())
			->header('Content-Type', 'text/plain; charset=UTF-8');
		$response->header('Content-Length', strlen($response->getOriginalContent()));

		return $response;
	}
}
