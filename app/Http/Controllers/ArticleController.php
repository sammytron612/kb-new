<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Services\ArticleService;
use App\Models\Section;
use Illuminate\Support\Facades\Gate;

class ArticleController extends Controller
{
    public function __construct(private ArticleService $articleService)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Section::all();

        return view('articles.create', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'tags' => 'nullable|string',
            'sectionId' => 'required|integer|exists:sections,id',
            'attachments.*' => 'nullable|file|max:10240',
            'attachments' => 'nullable|array|max:3',
            'scope' => 'required|integer|in:1,2',
            'published' => 'required|integer|in:0,1',
            'article_body' => 'required|string',
            'expires' => 'nullable|date',
        ]);

        $files = $request->hasFile('attachments') ? $request->file('attachments') : null;

        $article = $this->articleService->createArticle($validated, $files);

        return redirect()->back()->with('success', 'Article created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $article = Article::with('body')->findOrFail($id);
        $article->increment('views');

        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $article = Article::findOrFail($id);
        if (! Gate::allows('canEdit', $article)) {
            abort(403);
        }

        $sections = Section::all();
        return view('articles.edit', compact('article', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {

        $article = Article::findOrFail($id);

        // Check attachment count limit
        $existingAttachments = $article->attachments ?? [];
        $newAttachmentCount = $request->hasFile('attachments') ? count($request->file('attachments')) : 0;
        $totalAttachments = count($existingAttachments) + $newAttachmentCount;

        if ($totalAttachments > 3) {
            return redirect()->back()->withErrors(['attachments' => 'You can only have up to 3 attachments.']);
        }


        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'tags' => 'nullable|string',
            'sectionId' => 'required|integer|exists:sections,id',
            'scope' => 'required|integer|in:1,2',
            'attachments.*' => 'nullable|file|max:10240',
            'published' => 'required|integer|in:0,1',
            'expires' => 'nullable|date',
            'article_body' => 'required|string',
        ]);





        $files = $request->hasFile('attachments') ? $request->file('attachments') : null;

        $article = $this->articleService->updateArticle($article, $validated, $files);

        return redirect()->route('article.edit', $article->id)->with('success', 'Article updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
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



    public function shared(Article $article)
    {
        $article->increment('views');

        // Generate signed URLs for attachments
        $signedAttachmentUrls = [];
        if (!empty($article->attachments)) {
            foreach ($article->attachments as $attachment) {
                $signedAttachmentUrls[] = [
                    'filename' => basename($attachment),
                    'original_path' => $attachment,
                    'signed_url' => \URL::temporarySignedRoute(
                        'attachment.download',
                        now()->addHours(24), // URL expires in 24 hours
                        [
                            'article' => $article->id,
                            'attachment' => basename($attachment)
                        ]
                    )
                ];
            }
        }

        return view('articles.signed-show', compact('article', 'signedAttachmentUrls'));
    }
}
