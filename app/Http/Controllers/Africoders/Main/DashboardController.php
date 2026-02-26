<?php

namespace App\Http\Controllers\Africoders\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the user dashboard.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        return view('africoders.main.dashboard', [
            'user' => $user,
        ]);
    }

    /**
     * Show the user account page.
     */
    public function account(Request $request): View
    {
        $user = $request->user();

        return view('africoders.main.account', [
            'user' => $user,
        ]);
    }
}
