<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App;

class SelectorController extends Controller
{
    //
    public function getview()
    {
    	// dd(Auth::user());
    	return App::call('App\Http\Controllers\HomeController@selector');
    }
}
