<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Laravel\Scout\Searchable;

class Article extends Model
{
    use HasFactory,Searchable;

    protected $fillable = [
        'kb',
        'title',
        'slug',
        'author',
        'author_name',
        'sectionid',
        'tags',
        'attachments',
        'views',
        'attachCount',
        'scope',
        'images',
        'rating',
        'approved',
        'published',
        'notify_sent',
        'expires',
    ];

    protected $casts = [
        'tags' => 'array',
        'attachments' => 'array',
        'images' => 'array',
        'approved' => 'boolean',
        'published' => 'boolean',
        'notify_sent' => 'boolean',
        'expires' => 'date',
    ];

    public function body()
    {
        return $this->hasOne(ArticleBody::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'sectionid', 'id');
    }

    public function authorUser()
    {
        return $this->belongsTo(\App\Models\User::class, 'author');
    }

    /**
     * Scope for full-text search on articles and article_bodies.
     */


    public function scopeFullTextSearch(Builder $query, string $keyword): Builder
    {
        return $query
            ->join('article_bodies', 'article_bodies.article_id', '=', 'articles.id')
            ->where(function ($q) use ($keyword) {
                $q->whereRaw("MATCH(articles.title) AGAINST (? IN BOOLEAN MODE)", [$keyword .'*'])
                  ->orWhereRaw("MATCH(article_bodies.body) AGAINST (? IN BOOLEAN MODE)", [$keyword .'*'])
                  ->orWhere("articles.tags", 'like', '%' . $keyword .'%');
            })

            ->where(function ($q) {
                    $q->whereNull('expires')
                    ->orWhere('expires', '>', now());
                })
            ->where('articles.approved',1)
            ->where('articles.published',1)
            ->select('articles.*')
            ->with('body');
    }

    public function toSearchableArray()
    {
        if (!$this->relationLoaded('body')) {
        $this->load('body');}
        // Get and clean body content - STRIP HTML TAGS
        $bodyContent = '';


            // Remove HTML tags
            $bodyContent = strip_tags($this->body->body);

            // Decode HTML entities (&amp; &lt; &gt; etc.)
            $bodyContent = html_entity_decode($bodyContent, ENT_QUOTES, 'UTF-8');

            // Clean up extra whitespace
            $bodyContent = preg_replace('/\s+/', ' ', trim($bodyContent));
            // ...existing code...

        // Convert tags array to string for searching
        $tags = is_array($this->tags) ? implode(' ', $this->tags) : ($this->tags ?? '');

        return [
            'id' => $this->id,
            'title' => $this->title,
            'tags' => $this->tags,
            'kb' => $this->kb,
            'author_name' => $this->author_name,
            'body' => $bodyContent, // Include body content
            'approved' => (bool) $this->approved,
            'published' => (bool) $this->published,
            'sectionid' => $this->sectionid,
            'author' => $this->author,
            'scope' => $this->scope,
        ];
    }
}


