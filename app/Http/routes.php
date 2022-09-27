<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Http\Controllers\AjaxController;

$cities = getCityAliases();
$cities = implode('|', $cities);

Route::pattern('alias', '([A-Za-z0-9\-\/_]+)');
Route::pattern('id', '([0-9]+)');
Route::pattern('city', $cities);
Route::get('robots.txt', 'PageController@robots')->name('robots');

Route::group(['prefix' => 'ajax', 'as' => 'ajax.'], function () {
    Route::post('add-to-cart', [AjaxController::class, 'postAddToCart']);
    Route::post('update-to-cart', [AjaxController::class, 'postUpdateToCart']);
    Route::post('remove-from-cart', [AjaxController::class, 'postRemoveFromCart']);
    Route::post('purge-cart', [AjaxController::class, 'postPurgeCart']);
    Route::post('order', [AjaxController::class, 'postOrder'])->name('order');
	Route::post('request', 'AjaxController@postRequest')->name('request');
    Route::post('fast-request', 'AjaxController@postFastRequest')->name('fast-request');
    Route::post('questions', 'AjaxController@postQuestions')->name('questions');
	Route::post('writeback', 'AjaxController@postWriteback')->name('writeback');
	Route::post('contact-us', 'AjaxController@postContactUs')->name('contact-us');
	Route::post('callback', 'AjaxController@postCallback')->name('callback');
    Route::post('set-city', 'AjaxController@postSetCity')->name('set-city');
    Route::post('get-correct-region-link', 'AjaxController@postGetCorrectRegionLink')->name('get-correct-region-link');
    Route::get('show-popup-cities', [AjaxController::class, 'showCitiesPopup'])
        ->name('show-popup-cities');
    Route::get('search', [AjaxController::class, 'showCitiesPopup'])
        ->name('search');
});
Route::group(['middleware' => ['redirects', 'regions']], function() {
	Route::get('/', 'WelcomeController@index')
		->name('main');

//    Route::controller('cart', 'CartController');
//    Route::get('cart-success', ['as' => 'cart-success', 'uses' => 'CartController@showSuccess']);

    Route::get('cart', ['as' => 'cart', 'uses' => 'CartController@getIndex']);
    Route::get('order-success/{id?}', ['as' => 'order-success', 'uses' => 'CartController@showSuccess'])
        ->name('order-success');

    Route::group(['prefix' => '{city}', 'as' => 'region.',], function () {
        Route::any('catalog', ['as' => 'catalog.index', 'uses' => 'CatalogController@index']);
        Route::any('catalog/{alias}', ['as' => 'catalog.view', 'uses' => 'CatalogController@view'])
            ->where('alias', '([A-Za-z0-9\-\/_]+)');

        Route::any('{alias?}', ['as' => 'default', 'uses' => 'PageController@page'])
            ->where('alias', '([A-Za-z0-9\-\/_]+)');
    });

    Route::get('search', ['as' => 'search', 'uses' => 'SearchController@getIndex']);

    Route::any('news', 'NewsController@index')
		->name('news');
	Route::get('news/{alias}', ['as' => 'news.item', 'uses' => 'NewsController@item']);

    Route::any('vacancy', 'VacancyController@index')
		->name('vacancy');

    Route::any('reviews', 'ReviewsController@index')
		->name('reviews');

    Route::any('partners', 'PartnersController@index')
		->name('partners');

    Route::any('suppliers', 'SuppliersController@index')
		->name('suppliers');

    Route::any('gosts', 'GostsController@index')
		->name('gosts');

    Route::any('answers', 'AnswersController@index')
		->name('answers');

	Route::any('offers', 'OfferController@index')
		->name('offers');
	Route::get('offers/{alias}', ['as' => 'offers.item', 'uses' => 'OfferController@item']);

	Route::any('publications', ['as' => 'publications', 'uses' => 'PublicationController@index']);
	Route::get('publications/{alias}', ['as' => 'publications.item', 'uses' =>    'PublicationController@item']);

	Route::any('catalog', ['as' => 'catalog.index', 'uses' => 'CatalogController@index']);
	Route::any('catalog/{alias}', ['as' => 'catalog.view', 'uses' => 'CatalogController@view'])
		->where('alias', '([A-Za-z0-9\-\/_]+)');

	Route::any('services', ['as' => 'services.index', 'uses' => 'ServiceController@index']);
	Route::any('services/{alias}', ['as' => 'services.view', 'uses' => 'ServiceController@view'])
		->where('alias', '([A-Za-z0-9\-\/_]+)');

	Route::any('actions', ['as' => 'actions.index', 'uses' => 'ActionController@index']);
	Route::any('action/{alias}', ['as' => 'action.view', 'uses' => 'ActionController@view'])
		->where('alias', '([A-Za-z0-9\-\/_]+)');

	Route::any('{alias}', ['as' => 'default', 'uses' => 'PageController@page'])
		->where('alias', '([A-Za-z0-9\-\/_]+)');
});