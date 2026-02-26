<?php

namespace App\Http\Controllers\Africoders\Id;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        // Refresh user to get latest data from database
        $user->refresh();

        return view('africoders.id.dashboard', [
            'user' => $user,
            'emailVerified' => $user->hasVerifiedEmail(),
            'verification' => $user->verifications()->where('type', 'identity')->first(),
        ]);
    }
}
