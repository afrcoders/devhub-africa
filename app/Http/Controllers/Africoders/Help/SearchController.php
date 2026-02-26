<?php

namespace App\Http\Controllers\Africoders\Help;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q');
        $searchResults = [];

        if ($query) {
            $searchResults = $this->mockSearchResults($query);
        }

        return view('africoders.help.search', compact('query', 'searchResults'));
    }

    private function mockSearchResults($query)
    {
        $query = strtolower(trim($query));
        $allResults = [
            [
                'title' => 'Getting Started with Africoders',
                'description' => 'Complete guide to getting started on our platform',
                'content' => 'Learn how to create your account, set up your profile, and navigate the Africoders platform. This comprehensive guide covers everything you need to know.',
                'url' => route('help.article', 'getting-started'),
                'type' => 'Article',
                'type_color' => 'primary',
                'category' => 'Getting Started'
            ],
            [
                'title' => 'Account Security Best Practices',
                'description' => 'Keep your account safe and secure',
                'content' => 'Follow these essential security practices to protect your Africoders account from unauthorized access and keep your data safe.',
                'url' => route('help.article', 'account-security'),
                'type' => 'Article',
                'type_color' => 'success',
                'category' => 'Security'
            ],
            [
                'title' => 'How do I reset my password?',
                'description' => 'Steps to reset your forgotten password',
                'content' => 'Visit the login page, click "Forgot Password", enter your email address, and follow the instructions in the email we send you.',
                'url' => route('help.faq') . '#password-reset',
                'type' => 'FAQ',
                'type_color' => 'info',
                'category' => 'Account'
            ],
            [
                'title' => 'Privacy Settings Guide',
                'description' => 'Control your privacy and data sharing preferences',
                'content' => 'Learn how to manage your privacy settings, control who can see your profile, and customize your communication preferences.',
                'url' => route('help.article', 'privacy-settings'),
                'type' => 'Article',
                'type_color' => 'warning',
                'category' => 'Privacy'
            ],
            [
                'title' => 'Data Download and Export',
                'description' => 'How to download your personal data',
                'content' => 'Learn how to request and download a copy of your personal data stored on Africoders, including your profile information, posts, and activity history.',
                'url' => route('help.article', 'data-export'),
                'type' => 'Article',
                'type_color' => 'info',
                'category' => 'Privacy'
            ],
            [
                'title' => 'Contact Support',
                'description' => 'Get help from our support team',
                'content' => 'Need personalized assistance? Contact our support team through our contact form and we\'ll get back to you within 24 hours.',
                'url' => route('help.contact'),
                'type' => 'Support',
                'type_color' => 'secondary',
                'category' => null
            ]
        ];

        // Filter results based on query
        if (empty($query)) {
            return [];
        }

        return array_filter($allResults, function($result) use ($query) {
            return stripos($result['title'], $query) !== false ||
                   stripos($result['description'], $query) !== false ||
                   stripos($result['content'], $query) !== false ||
                   ($result['category'] && stripos($result['category'], $query) !== false);
        });
    }
}
