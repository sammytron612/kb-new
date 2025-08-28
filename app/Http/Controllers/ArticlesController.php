<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Services\ArticleService;
use Illuminate\Support\Facades\Gate;

class ArticlesController extends Controller
{
    public function __construct(private ArticleService $articleService)
    {

    }

    public function show($id)
    {
        $article = Article::with('body')->findOrFail($id);
        $article->increment('views');

        return view('articles.show', compact('article'));
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        // Debug logging
        \Log::info('Delete attempt', [
            'user_id' => auth()->id(),
            'user_role' => auth()->user()->role,
            'article_id' => $article->id,
            'article_author' => $article->author,
            'gate_allows' => Gate::allows('canDelete', $article)
        ]);

        if (! Gate::allows('canDelete', $article)) {
            abort(403, 'You are not authorized to delete this article.');
        }

        $this->articleService->deleteArticle($article);

        return redirect()->route('dashboard')->with('success', 'Article deleted successfully.');
    }
/*
    public function downloadAttachments(Article $article)
    {
        if (empty($article->attachments) || count($article->attachments) === 0) {
            abort(404, 'No attachments found');
        }

        $zip = new \ZipArchive();
        $zipFileName = 'article-' . $article->id . '-attachments.zip';
        $zipPath = storage_path('app/temp/' . $zipFileName);

        // Create temp directory if it doesn't exist
        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        if ($zip->open($zipPath, \ZipArchive::CREATE) === TRUE) {
            foreach ($article->attachments as $attachment) {
                $filePath = storage_path('app/public/' . $attachment);
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, basename($attachment));
                }
            }
            $zip->close();

            return response()->download($zipPath)->deleteFileAfterSend();
        }

    abort(500, 'Could not create zip file');
}
*/
    public function shared(Article $article)
    {
        // Increment view count
        $article->increment('views');

        return view('articles.signed-show', compact('article'));
    }
}
