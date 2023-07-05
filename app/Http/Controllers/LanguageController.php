<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
	public function setLanguage($lang): JsonResponse
	{
		if (array_key_exists($lang, Config::get('languages'))) {
			Session::put('locale', $lang);

			return response()->json(['messages' => [__('validation.language_changed_successfully')]]);
		}

		return response()->json(['messages' => __('validation.something_went_wrong')]);
	}
}
