<?php

namespace App\Mail;

use App\Models\Api\Comment;
use App\Models\Api\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $post;
    public $comment;

    public function __construct(Post $post, Comment $comment)
    {
        $this->post = $post;
        $this->comment = $comment;
    }

    public function build()
    {
        return $this->view('emails.comment_notification')
            ->with([
                'postTitle' => $this->post->title,
                'commentContent' => $this->comment->content,
                'commentAuthor' => $this->comment->user->name,
            ]);
    }
}
