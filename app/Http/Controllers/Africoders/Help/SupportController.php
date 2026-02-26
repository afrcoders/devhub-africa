<?php

namespace App\Http\Controllers\Africoders\Help;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index()
    {
        return view('africoders.help.support');
    }

    public function faq()
    {
        return view('africoders.help.faq');
    }

    public function articles()
    {
        return view('africoders.help.articles');
    }

    public function article($slug)
    {
        $category = $this->getCategoryForSlug($slug);
        return view('africoders.help.article', compact('slug', 'category'));
    }

    private function getCategoryForSlug($slug)
    {
        $categories = [
            'getting-started' => 'getting-started',
            'creating-account' => 'getting-started',
            'platform-overview' => 'getting-started',
            'account-security' => 'security',
            'password-management' => 'security',
            'account-verification' => 'accounts',
            'privacy-settings' => 'privacy',
            'data-export' => 'privacy',
            'account-deletion' => 'privacy',
            'business-guidelines' => 'business',
        ];
        return $categories[$slug] ?? 'general';
    }
}
