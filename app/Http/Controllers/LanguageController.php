<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switch(Request $request) {
        $language = $request->input('language');
        

        if(in_array($language, ['en', 'id'])) {
            App::setLocale($language);
            Session::put('locale', $language);
        }

        return redirect()->back();
    }
}
