<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Article;
use App\Models\User;

class ArticleApprovedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $article;
    public $author;

    /**
     * Create a new message instance.
     */
    public function __construct(Article $article, User $author)
    {
        $this->article = $article;
        $this->author = $author;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your article has been approved: ' . $this->article->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.article-approved',
            with: [
                'article' => $this->article,
                'author' => $this->author,
                'articleUrl' => route('article.show', $this->article->id),
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
