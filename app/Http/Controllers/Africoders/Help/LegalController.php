<?php

namespace App\Http\Controllers\Africoders\Help;

use App\Http\Controllers\Controller;
use App\Models\Help\LegalDocument;
use Illuminate\Http\Request;

class LegalController extends Controller
{
    public function document($slug)
    {
        $document = LegalDocument::where('slug', $slug)
            ->where('published', true)
            ->firstOrFail();

        return view('africoders.help.legal', [
            'document' => $document,
            'slug' => $slug,
            'title' => $document->title
        ]);
    }
}
