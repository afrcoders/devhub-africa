<?php

namespace App\Http\Controllers\Africoders\Help;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        return view('africoders.help.home');
    }
}
