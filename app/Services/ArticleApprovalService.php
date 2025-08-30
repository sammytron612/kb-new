<?php

namespace App\Services;

use App\Models\Article;
use App\Models\User;
use App\Mail\ArticleApprovedNotification;
use App\Mail\ArticleRejectedNotification;
use App\Traits\SendsEmailNotifications;
use App\Traits\EmailsEnabled;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ArticleApprovalService
{
    use SendsEmailNotifications, EmailsEnabled;

    /**
     * Approve an article
     */
    public function approveArticle(Article $article): void
    {
        try {
            $article->update(['approved' => true]);

            // Sync to search index since approval status changed
            $this->syncToSearchIndex($article);

            if ($this->isEmailEnabled()) {
                // Send approval email to author
                $this->sendApprovalEmail($article);

                // Send new article email to users if published
                if ($article->published) {
                    $this->emailUsers($article);
                }
            }

            Log::info('Article approved successfully', [
                'article_id' => $article->id,
                'article_title' => $article->title
            ]);


        } catch (\Exception $e) {
            Log::error('Error approving article: ' . $e->getMessage(), [
                'article_id' => $article->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Reject an article
     */
    public function rejectArticle(Article $article, string $reason = null): void
    {
        try {
            $article->update(['approved' => false]);

            // Remove from search index
            $article->unsearchable();

            if ($this->isEmailEnabled()) {
                // Send rejection email to author
                $this->sendRejectionEmail($article, $reason);
            }

            Log::info('Article rejected successfully', [
                'article_id' => $article->id,
                'article_title' => $article->title
            ]);


        } catch (\Exception $e) {
            Log::error('Error rejecting article: ' . $e->getMessage(), [
                'article_id' => $article->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Bulk approve multiple articles
     */
    public function bulkApprove(array $articleIds): array
    {
        $results = [];

        foreach ($articleIds as $articleId) {
            try {
                $article = Article::findOrFail($articleId);
                $results[$articleId] = $this->approveArticle($article);
            } catch (\Exception $e) {
                Log::error('Failed to approve article in bulk operation', [
                    'article_id' => $articleId,
                    'error' => $e->getMessage()
                ]);
                $results[$articleId] = false;
            }
        }

        return $results;
    }

    /**
     * Bulk reject multiple articles
     */
    public function bulkReject(array $articleIds, string $reason = null): array
    {
        $results = [];

        foreach ($articleIds as $articleId) {
            try {
                $article = Article::findOrFail($articleId);
                $results[$articleId] = $this->rejectArticle($article, $reason);
            } catch (\Exception $e) {
                Log::error('Failed to reject article in bulk operation', [
                    'article_id' => $articleId,
                    'error' => $e->getMessage()
                ]);
                $results[$articleId] = false;
            }
        }

        return $results;
    }

    /**
     * Get pending approval statistics
     */
    public function getPendingApprovalStats(): array
    {
        return [
            'total_pending' => Article::where('approved', false)->where('published', true)->count(),
            'pending_by_section' => Article::where('approved', false)
                ->where('published', true)
                ->with('section')
                ->get()
                ->groupBy('section.name')
                ->map(fn($articles) => $articles->count())
                ->toArray(),
            'oldest_pending' => Article::where('approved', false)
                ->where('published', true)
                ->orderBy('created_at', 'asc')
                ->first(),
        ];
    }

    /**
     * Sync article to search index
     */
    private function syncToSearchIndex(Article $article): void
    {
        if (config('scout.enabled') && $article->shouldBeSearchable()) {
            $article->searchable();
        }
    }

    /**
     * Send approval email to article author
     */
    private function sendApprovalEmail(Article $article): void
    {
        try {
            $author = User::find($article->author);

            if (!$author || !$author->email) {
                Log::warning('Cannot send approval email - author not found or no email', [
                    'article_id' => $article->id,
                    'author_id' => $article->author
                ]);
                return;
            }

            Mail::to($author->email)->send(new ArticleApprovedNotification($article, $author));

            Log::info('Approval email sent successfully', [
                'article_id' => $article->id,
                'article_title' => $article->title,
                'author_email' => $author->email
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send approval email', [
                'article_id' => $article->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Send rejection email to article author
     */
    private function sendRejectionEmail(Article $article, string $reason = null): void
    {
        try {
            $author = User::find($article->author);

            if (!$author || !$author->email) {
                Log::warning('Cannot send rejection email - author not found or no email', [
                    'article_id' => $article->id,
                    'author_id' => $article->author
                ]);
                return;
            }

            Mail::to($author->email)->send(new ArticleRejectedNotification($article, $author, $reason));

            Log::info('Rejection email sent successfully', [
                'article_id' => $article->id,
                'article_title' => $article->title,
                'author_email' => $author->email
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send rejection email', [
                'article_id' => $article->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
