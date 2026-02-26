<?php

namespace App\Http\Controllers\Africoders\Admin;

use App\Http\Controllers\Controller;
use App\Models\Help\ContactMessage;
use App\Models\Help\Article;
use App\Models\Help\Faq;
use App\Models\Help\LegalDocument;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HelpManagementController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_messages' => ContactMessage::count(),
            'unread_messages' => ContactMessage::where('status', 'pending')->count(),
            'total_articles' => Article::count(),
            'published_articles' => Article::where('published', true)->count(),
            'total_faqs' => Faq::count(),
            'active_faqs' => Faq::where('published', true)->count(),
            'recent_messages' => ContactMessage::orderBy('created_at', 'desc')->limit(5)->get(),
            'popular_articles' => Article::where('published', true)
                ->orderBy('views', 'desc')
                ->limit(5)
                ->get()
        ];

        // Messages by month (last 12 months)
        $messagesChart = ContactMessage::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->where('created_at', '>=', Carbon::now()->subYear())
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        return view('admin.help.dashboard', compact('stats', 'messagesChart'));
    }

    // Contact Messages Management
    public function messages(Request $request)
    {
        $query = ContactMessage::query();

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by type
        if ($request->has('type') && $request->type !== '') {
            $query->where('type', $request->type);
        }

        // Search by name, email, or subject
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('subject', 'LIKE', "%{$search}%");
            });
        }

        $messages = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.help.messages.index', compact('messages'));
    }

    public function showMessage(ContactMessage $message)
    {
        // Mark as read if it was pending
        if ($message->status === 'pending') {
            $message->update(['status' => 'read', 'read_at' => now()]);
        }

        return view('admin.help.messages.show', compact('message'));
    }

    public function updateMessageStatus(ContactMessage $message, Request $request)
    {
        $request->validate([
            'status' => 'required|in:pending,read,replied,resolved,archived'
        ]);

        $message->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes
        ]);

        return redirect()->back()->with('success', 'Message status updated successfully.');
    }

    public function deleteMessage(ContactMessage $message)
    {
        $message->delete();
        return redirect()->route('admin.help.messages.index')->with('success', 'Message deleted successfully.');
    }

    // Articles Management
    public function articles(Request $request)
    {
        $query = Article::query();

        // Filter by status (published/unpublished)
        if ($request->has('status') && $request->status !== '') {
            $published = $request->status === 'published';
            $query->where('published', $published);
        }

        // Filter by category
        if ($request->has('category') && $request->category !== '') {
            $query->where('category', $request->category);
        }

        // Search by title or content
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('content', 'LIKE', "%{$search}%");
            });
        }

        $articles = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.help.articles.index', compact('articles'));
    }

    public function createArticle()
    {
        return view('admin.help.articles.create');
    }

    public function storeArticle(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|max:255|unique:help_articles,slug',
            'category' => 'required|max:100',
            'content' => 'required',
            'excerpt' => 'required|max:500',
            'published' => 'boolean'
        ]);

        $article = Article::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'category' => $request->category,
            'content' => $request->content,
            'excerpt' => $request->excerpt,
            'published' => $request->boolean('published'),
            'meta' => [
                'meta_description' => $request->meta_description,
                'meta_keywords' => $request->meta_keywords
            ]
        ]);

        return redirect()->route('admin.help.articles.index')->with('success', 'Article created successfully.');
    }

    public function showArticle(Article $article)
    {
        return view('admin.help.articles.show', compact('article'));
    }

    public function editArticle(Article $article)
    {
        return view('admin.help.articles.edit', compact('article'));
    }

    public function updateArticle(Article $article, Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|max:255|unique:help_articles,slug,' . $article->id,
            'category' => 'required|max:100',
            'content' => 'required',
            'excerpt' => 'required|max:500',
            'published' => 'boolean'
        ]);

        $article->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'category' => $request->category,
            'content' => $request->content,
            'excerpt' => $request->excerpt,
            'published' => $request->boolean('published'),
            'meta' => [
                'meta_description' => $request->meta_description,
                'meta_keywords' => $request->meta_keywords
            ]
        ]);

        return redirect()->route('admin.help.articles.index')->with('success', 'Article updated successfully.');
    }

    public function deleteArticle(Article $article)
    {
        $article->delete();
        return redirect()->route('admin.help.articles.index')->with('success', 'Article deleted successfully.');
    }

    // FAQs Management
    public function faqs(Request $request)
    {
        $query = Faq::query();

        // Filter by status (published/unpublished)
        if ($request->has('status') && $request->status !== '') {
            $published = $request->status === 'published';
            $query->where('published', $published);
        }

        // Filter by category
        if ($request->has('category') && $request->category !== '') {
            $query->where('category', $request->category);
        }

        // Search by question or answer
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('question', 'LIKE', "%{$search}%")
                  ->orWhere('answer', 'LIKE', "%{$search}%");
            });
        }

        $faqs = $query->orderBy('order')->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.help.faqs.index', compact('faqs'));
    }

    public function createFaq()
    {
        return view('admin.help.faqs.create');
    }

    public function storeFaq(Request $request)
    {
        $request->validate([
            'question' => 'required|max:500',
            'answer' => 'required',
            'category' => 'required|max:100',
            'published' => 'boolean',
            'order' => 'integer|min:0'
        ]);

        Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
            'category' => $request->category,
            'published' => $request->boolean('published'),
            'order' => $request->order ?? 0
        ]);

        return redirect()->route('admin.help.faqs.index')->with('success', 'FAQ created successfully.');
    }

    public function showFaq(Faq $faq)
    {
        return view('admin.help.faqs.show', compact('faq'));
    }

    public function editFaq(Faq $faq)
    {
        return view('admin.help.faqs.edit', compact('faq'));
    }

    public function updateFaq(Faq $faq, Request $request)
    {
        $request->validate([
            'question' => 'required|max:500',
            'answer' => 'required',
            'category' => 'required|max:100',
            'published' => 'boolean',
            'order' => 'integer|min:0'
        ]);

        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer,
            'category' => $request->category,
            'published' => $request->boolean('published'),
            'order' => $request->order ?? 0
        ]);

        return redirect()->route('admin.help.faqs.index')->with('success', 'FAQ updated successfully.');
    }

    public function deleteFaq(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('admin.help.faqs.index')->with('success', 'FAQ deleted successfully.');
    }

    // Legal Documents Management
    public function legalDocuments(Request $request)
    {
        $documents = LegalDocument::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.help.legal.index', compact('documents'));
    }

    public function createLegalDocument()
    {
        return view('admin.help.legal.create');
    }

    public function storeLegalDocument(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|max:255|unique:help_legal_documents,slug',
            'content' => 'required',
            'status' => 'required|in:active,inactive',
            'version' => 'required|max:20'
        ]);

        LegalDocument::create($request->all());

        return redirect()->route('admin.help.legal.index')->with('success', 'Legal document created successfully.');
    }

    public function showLegalDocument(LegalDocument $document)
    {
        return view('admin.help.legal.show', compact('document'));
    }

    public function editLegalDocument(LegalDocument $document)
    {
        return view('admin.help.legal.edit', compact('document'));
    }

    public function updateLegalDocument(LegalDocument $document, Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|max:255|unique:help_legal_documents,slug,' . $document->id,
            'content' => 'required',
            'status' => 'required|in:active,inactive',
            'version' => 'required|max:20'
        ]);

        $document->update($request->all());

        return redirect()->route('admin.help.legal.index')->with('success', 'Legal document updated successfully.');
    }

    public function deleteLegalDocument(LegalDocument $document)
    {
        $document->delete();
        return redirect()->route('admin.help.legal.index')->with('success', 'Legal document deleted successfully.');
    }
}
