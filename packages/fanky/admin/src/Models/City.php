<?php namespace Fanky\Admin\Models;

use Cookie;
use Eloquent;
use Fanky\Admin\Settings;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Request;
use View;

/**
 * Class City
 *
 * @property integer id
 * @property string  name
 * @property string  alias
 * @property string  address
 * @property string  text
 * @property string  index_text
 * @property string  title
 * @property string  keywords
 * @property string  description
 * @property boolean on_footer
 * @package Fanky\Admin\Models
 * @property string|null                     $email
 * @property string                          $from_form
 * @property string|null                     $in_form
 * @property string                          $postal_code
 * @property float|null                      $lat
 * @property float|null                      $long
 * @property string|null                     $contact_text
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 * @property-read Collection|SxgeoCity[]     $sxgeo_cities
 * @method static Builder|City newModelQuery()
 * @method static Builder|City newQuery()
 * @method static Builder|City query()
 * @method static Builder|City whereAddress($value)
 * @method static Builder|City whereAlias($value)
 * @method static Builder|City whereContactText($value)
 * @method static Builder|City whereCreatedAt($value)
 * @method static Builder|City whereEmail($value)
 * @method static Builder|City whereFromForm($value)
 * @method static Builder|City whereId($value)
 * @method static Builder|City whereInForm($value)
 * @method static Builder|City whereIndexText($value)
 * @method static Builder|City whereLat($value)
 * @method static Builder|City whereLong($value)
 * @method static Builder|City whereName($value)
 * @method static Builder|City wherePostalCode($value)
 * @method static Builder|City whereUpdatedAt($value)
 * @mixin Eloquent
 */
class City extends Model {

	protected $fillable = ['name', 'alias', 'postal_code', 'index_text', 'contact_text',
		'email',
		'from_form', 'in_form', 'long', 'lat', 'address'];

	public function sxgeo_cities(): BelongsToMany {
		return $this->belongsToMany('Fanky\Admin\Models\SxgeoCity');
	}

	/** @return City */
	public static function check_region($alias) {
		$city = self::whereAlias($alias)->first();

		return $city;
	}

	/** return Page */
	public function generateIndexPage(): Page {
		$page = new Page();
		$main_page = Page::find(1);
		$page->parent_id = $main_page->id;

		$page->title = Settings::get('city_index_title');
		$page->keywords = $main_page->keywords;
		$page->description = $main_page->description;
		$page->name = Settings::get('city_index_h1');
//		$page->text = $this->index_text; //было
		$page->text = Settings::get('region_text') ?? 'Заполните текст в настройках сайта';

        return $page;
	}

	public function getSchemaOrganization() {
		$sxgeoCity = $this->sxgeo_cities()
			->where('sxgeo_cities.name_ru', $this->name)->first();
		if(!$sxgeoCity){
			$sxgeoCity = $this->sxgeo_cities()
				->orderBy(\DB::raw('LENGTH(okato)'), 'desc')
				->first();
		}

		$region = '';
		$country = '';
		$postalCode = $this->postal_code;
		if ($sxgeoCity && !$postalCode) {
			$region = $sxgeoCity->region->name_ru;
			$country = $sxgeoCity->region->country;
			$postalCode = $sxgeoCity->zip;
		}
		$streetAddress = 'г. ' . $this->name . ', ' . $this->address;

		return view('blocks.schemaOrganization', [
			'phone'         => Settings::get('phone'),
			'city'          => $this->name,
			'streetAddress' => $streetAddress,
			'region'        => $region,
			'country'       => $country,
			'postalCode'    => $postalCode,
		]);
	}

	public static function getDefaultSchemaOrganization() {

		return view('blocks.schemaOrganization', [
			'phone'         => Settings::get('phone'),
			'city'          => 'Федеральный',
			'streetAddress' => '',
			'region'        => '',
			'country'       => '',
			'postalCode'    => '',
		]);
	}

	public static function current($city_alias = null, $remember = true, \Illuminate\Http\Request $request) {
		$detect_city = SxgeoCity::detect();
		$first_visit = !Cookie::has('city_id');
		$federal_link = !$city_alias;
		$city = null;
		$region_page = true; //СТраница участвует в региональности
		$segments = $request->segments();
		if(count($segments) > 0){
			$start = array_shift($segments);
			if(in_array($start, Page::$excludeRegionAlias)){
				$region_page = false;
			}
		}

//		Проверка на главную страницу
		if (Request::path() == '/') {
			if ($city_alias = session('city_alias')) {
				return City::whereAlias($city_alias)->first();
			} else {
				$detect_city = SxgeoCity::detect();
				if (!$first_visit) { //если не первый визит
					$city_id = Cookie::get('city_id');
					$city = City::find($city_id);
					if ($city) { //если не первый визит и такой город есть, ничего не выводим
						session(['city_alias' => $city->alias]);

						return $city;
					} else if ($city_id === 0 || $city_id === '0') {
						session(['city_alias' => '']);

						return null;
					} else {//если не первый визит и такого города выводим свой город и показываем окно,

						View::share('show_small_region_confirm', true); //ПОказать маленькое окно в шапке

						return $detect_city;
					}
				} else { //Если первый визит - город ставим автоматом, выводим окно в шапке
					if ($detect_city) {
						session(['city_alias' => $detect_city->alias]);
						View::share('show_small_region_confirm', true); //ПОказать маленькое окно в шапке
					}

					return $detect_city;
				}
			}
		}
		//обработка остальных ссылок

		if ($first_visit) {
			if ($federal_link) {
				if ($remember) {
					session(['city_alias' => null]);
				}

			} else {
				View::share('show_small_region_confirm', true); //ПОказать маленькое окно в шапке
				if ($remember) {
					session(['city_alias' => $city_alias]);
				}
				$city = City::whereAlias($city_alias)->first();
			}
		} else {
			$city_id_by_cookie = Cookie::get('city_id', null);

			if ($federal_link) {

				if ($city_id_by_cookie === 0 || $city_id_by_cookie === '0') { //Ничего не показываем, оставляем как есть
					if ($remember) {
						session(['city_alias' => '']);
					}

					return null;
				} else { //Показываем большое окно - Вы у нас уже были, но в другом регионе
					$city_by_cookie = City::whereId(Cookie::get('city_id'))->first();
					if ($city_by_cookie && $region_page) {
						View::share('show_big_region_confirm', true); //ПОказать большое полупрозрачное окно
						View::share('big_region_confirm_city', $city_by_cookie);
						if ($remember) {
							session(['city_alias' => $city_alias]);
						}
					}

					$city = City::whereId($city_id_by_cookie)->first();

				}
			} else { //!federal_link
				$city_by_alias = City::whereAlias($city_alias)->first();
				if ($city_by_alias->id == $city_id_by_cookie) { //если регион совпадает с ранее сохраненным.
					if ($remember) {
						session(['city_alias' => $city_by_alias->alias]);
					}
				} else { //Если попали на другой регион
					$city_by_cookie = City::whereId(Cookie::get('city_id'))->first();
					if ($city_by_cookie && $region_page) { //город из куков в базе есть, но не совпадает с раннее выбранным
						View::share('show_big_region_confirm', true); //ПОказать большое полупрозрачное окно
						View::share('big_region_confirm_city', $city_by_cookie);
						if ($remember) {
							session(['city_alias' => $city_alias]);
						}

					} else { //города из куков в базе нет. покажем маленькое окно
						View::share('show_small_region_confirm', true); //ПОказать маленькое окно в шапке
						if ($remember) {
							session(['city_alias' => $city_alias]);
						}
					}
				}

				$city = $city_by_alias;
			}
		}

		return $city;
	}
}
