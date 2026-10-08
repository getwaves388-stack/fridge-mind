<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switchLang($lang)
    {
        // Save to the session only for supported languages ​​(en, ja).
        if (in_array($lang, ['en', 'ja'])) {
            Session::put('applocale', $lang);
        }
        
        // Return to the previous page
        return redirect()->back();
    }
}
