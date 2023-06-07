<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function setLanguage($lang): JsonResponse
    {
        if  (array_key_exists($lang, Config::get('languages'))) {
            Session::put('locale', $lang);
            return response()->json(['messages' => ['language changed successfully.'] ]);
        }
        return response()->json(['messages' => 'something went wrong.']);
    }
}
