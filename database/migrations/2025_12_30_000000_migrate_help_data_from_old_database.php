<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Migrate Help Articles
        $oldArticles = DB::connection('mysql')->select('
            SELECT id, title, slug, content, excerpt, category, `order`, published, created_at, updated_at
            FROM africoders_help.articles
        ');

        foreach ($oldArticles as $article) {
            DB::table('help_articles')->insert([
                'id' => $article->id,
                'title' => $article->title,
                'slug' => $article->slug,
                'content' => $article->content,
                'excerpt' => $article->excerpt,
                'category' => $article->category,
                'published' => (bool) $article->published,
                'created_at' => $article->created_at,
                'updated_at' => $article->updated_at,
            ]);
        }

        echo "Migrated " . count($oldArticles) . " help articles\n";

        // Migrate Help FAQs
        $oldFaqs = DB::connection('mysql')->select('
            SELECT id, question, answer, category, `order`, helpful_count, unhelpful_count, published, created_at, updated_at
            FROM africoders_help.faqs
        ');

        foreach ($oldFaqs as $faq) {
            DB::table('help_faqs')->insert([
                'id' => $faq->id,
                'question' => $faq->question,
                'answer' => $faq->answer,
                'category' => $faq->category,
                'order' => $faq->order ?? 0,
                'helpful_votes' => $faq->helpful_count ?? 0,
                'unhelpful_votes' => $faq->unhelpful_count ?? 0,
                'published' => (bool) $faq->published,
                'created_at' => $faq->created_at,
                'updated_at' => $faq->updated_at,
            ]);
        }

        echo "Migrated " . count($oldFaqs) . " help FAQs\n";

        // Migrate Legal Documents
        $oldLegalDocs = DB::connection('mysql')->select('
            SELECT id, title, slug, content, type, version, effective_date, published, created_at, updated_at
            FROM africoders_help.legal_documents
        ');

        foreach ($oldLegalDocs as $doc) {
            DB::table('help_legal_documents')->insert([
                'id' => $doc->id,
                'title' => $doc->title,
                'slug' => $doc->slug,
                'content' => $doc->content,
                'version' => $doc->version ?? '1.0',
                'effective_date' => $doc->effective_date,
                'published' => (bool) $doc->published,
                'created_at' => $doc->created_at,
                'updated_at' => $doc->updated_at,
            ]);
        }

        echo "Migrated " . count($oldLegalDocs) . " legal documents\n";

        // Migrate Contact Messages
        $oldMessages = DB::connection('mysql')->select('
            SELECT id, name, email, subject, message, type, status, ip_address, created_at, updated_at
            FROM africoders_help.contact_messages
        ');

        foreach ($oldMessages as $message) {
            DB::table('help_contact_messages')->insert([
                'id' => $message->id,
                'name' => $message->name,
                'email' => $message->email,
                'subject' => $message->subject,
                'message' => $message->message,
                'type' => $message->type ?? 'support',
                'status' => $message->status ?? 'open',
                'ip_address' => $message->ip_address,
                'created_at' => $message->created_at,
                'updated_at' => $message->updated_at,
            ]);
        }

        echo "Migrated " . count($oldMessages) . " contact messages\n";

        // Reset auto-increment IDs to continue from the highest migrated ID
        $maxArticleId = DB::table('help_articles')->max('id') ?: 0;
        $maxFaqId = DB::table('help_faqs')->max('id') ?: 0;
        $maxLegalId = DB::table('help_legal_documents')->max('id') ?: 0;
        $maxMessageId = DB::table('help_contact_messages')->max('id') ?: 0;

        DB::statement("ALTER TABLE help_articles AUTO_INCREMENT = " . ($maxArticleId + 1));
        DB::statement("ALTER TABLE help_faqs AUTO_INCREMENT = " . ($maxFaqId + 1));
        DB::statement("ALTER TABLE help_legal_documents AUTO_INCREMENT = " . ($maxLegalId + 1));
        DB::statement("ALTER TABLE help_contact_messages AUTO_INCREMENT = " . ($maxMessageId + 1));

        echo "Reset auto-increment IDs\n";
        echo "Data migration completed successfully!\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Truncate all help tables
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('help_articles')->truncate();
        DB::table('help_faqs')->truncate();
        DB::table('help_legal_documents')->truncate();
        DB::table('help_contact_messages')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        echo "Rolled back help data migration\n";
    }
};
