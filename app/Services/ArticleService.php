<?php

namespace App\Services;

use App\Models\Article;
use App\Models\ArticleBody;
use App\Models\User;
use App\Traits\SendsEmailNotifications;
use App\Traits\EmailsEnabled;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleService
{
    use SendsEmailNotifications, EmailsEnabled;

    public function __construct(private AttachmentsService $attachmentsService)
    {
    }
    /**
     * Create a new article with all related data
     */
    public function createArticle(array $validated, array $files = null): Article
    {
        DB::beginTransaction();

        try {
            // Handle file attachments first
            $attachmentPaths = [];
            if ($files) {
                $attachmentPaths = $this->attachmentsService->handleAttachments($files);
            }

            // Create article without syncing to search
            $article = Article::withoutSyncingToSearch(function () use ($validated, $attachmentPaths) {
                return Article::create([
                    'title' => $validated['title'],
                    'author' => Auth::id(),
                    'author_name' => Auth::user()->name ?? '',
                    'sectionId' => $validated['sectionId'],
                    'tags' => isset($validated['tags']) ? explode(',', $validated['tags']) : [],
                    'attachments' => $attachmentPaths,
                    'views' => 0,
                    'attachCount' => count($attachmentPaths),
                    'scope' => $validated['scope'],
                    'images' => [],
                    'rating' => 0,
                    'approved' => Auth::user()->role === 1 ? true : false,
                    'published' => $validated['published'],
                    'notify_sent' => false,
                    'expires' => $validated['expires'] ?? null,
                ]);
            });

            // Update with generated kb and slug without syncing to search
            Article::withoutSyncingToSearch(function () use ($article, $validated) {
                $article->update([
                    'kb' => "kb" . rand(100, 999) . $article->id,
                    'slug' => Str::of($validated['title'])->slug('-') . "-" . $article->id
                ]);
            });

            // Create the article body
            $this->createArticleBody($article, $validated['article_body']);

            // Manually sync to search index if enabled
            $this->syncToSearchIndex($article);

            // Send email notifications if applicable
            $this->handleEmailNotifications($article, $validated);

            DB::commit();
            return $article;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Create article body
     */
    private function createArticleBody(Article $article, string $body): void
    {
        ArticleBody::create([
            'article_id' => $article->id,
            'body' => $body,
        ]);
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
     * Handle email notifications
     */
    private function handleEmailNotifications(Article $article, array $validated): void
    {
        if ($this->isEmailEnabled()) {
            // Only send emails if article is published and approved
            if ($validated['published'] == 1 && $article->approved == 1) {
                $this->emailUsers($article);
            }
        }
    }

    /**
     * Update an existing article
     */
    public function updateArticle(Article $article, array $validated, array $files = null): Article
    {
        DB::beginTransaction();

        try {
            // Handle new attachments
            $newAttachmentPaths = [];

            if ($files) {
                // Process new files
                $newAttachmentPaths = $this->attachmentsService->handleAttachments($files);
            }

            // Merge with existing attachments
            $existingAttachments = $article->attachments ?? [];
            $allAttachments = array_merge($existingAttachments, $newAttachmentPaths);

            // Update article without syncing to search
            Article::withoutSyncingToSearch(function () use ($article, $validated, $allAttachments) {
                $article->update([
                    'title' => $validated['title'],
                    'sectionid' => $validated['sectionid'],
                    'tags' => isset($validated['tags']) ? explode(',', $validated['tags']) : [],
                    'attachments' => $allAttachments,
                    'attachCount' => count($allAttachments),
                    'scope' => $validated['scope'],
                    'published' => $validated['published'],
                    'expires' => $validated['expires'] ?? null,
                    'slug' => Str::of($validated['title'])->slug('-') . "-" . $article->id
                ]);
            });

            // Update article body
            if (isset($validated['article_body'])) {
                $article->body()->updateOrCreate(
                    ['article_id' => $article->id],
                    ['body' => $validated['article_body']]
                );
            }

            // Sync to search index
            $this->syncToSearchIndex($article);

            DB::commit();
            return $article->fresh();

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete an article and its related data
     */
    public function deleteArticle(Article $article): bool
    {
        DB::beginTransaction();

        try {
            // Remove from search index
            $article->unsearchable();

            // Delete physical attachment files
            $this->attachmentsService->deleteAttachments($article->attachments ?? []);

            // Delete article body
            $article->body()->delete();

            // Delete comments
            $article->comments()->delete();

            // Delete the article
            $deleted = $article->delete();

            DB::commit();
            return $deleted;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
