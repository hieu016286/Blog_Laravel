<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Localization extends Controller
{
    public function index(Request $request): RedirectResponse
    {
        session()->put('locale', $request->lang);
        return redirect()->back();
    }
}
