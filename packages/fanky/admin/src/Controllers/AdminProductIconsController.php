<?php namespace Fanky\Admin\Controllers;

use Fanky\Admin\Models\ProductIcon;
use Request;
use Validator;
use Text;

class AdminProductIconsController extends AdminController {

	public function getIndex() {
		$items = ProductIcon::orderBy('name', 'desc')->get();

		return view('admin::product_icons.main', ['items' => $items]);
	}

	public function getEdit($id = null) {
		$item = ProductIcon::findOrNew($id);
		return view('admin::product_icons.edit', ['item' => $item]);
	}

	public function postSave() {
		$id = Request::input('id');
		$data = Request::only(['name']);
		$image = Request::file('image');

		// валидация данных
		$validator = Validator::make(
			$data,
			[
				'name' => 'required',
			]
		);
		if ($validator->fails()) {
			return ['errors' => $validator->messages()];
		}

		// Загружаем изображение
		if ($image) {
			$file_name = ProductIcon::uploadImage($image);
			$data['image'] = $file_name;
		}

		// сохраняем страницу
		$article = ProductIcon::find($id);
		$redirect = false;
		if (!$article) {
			$article = ProductIcon::create($data);
			$redirect = true;
		} else {
			if ($article->image && isset($data['image'])) {
				$article->deleteImage();
			}
			$article->update($data);
		}

        return ['redirect' => route('admin.product-icons')];
	}

	public function postDelete($id) {
		$article = ProductIcon::find($id);
		$article->delete();

		return ['success' => true];
	}

	public function postDeleteImage($id) {
		$news = ProductIcon::find($id);
		if(!$news) return ['error' => 'news_not_found'];

		$news->deleteImage();
		$news->update(['image' => null]);

		return ['success' => true];
	}
}
