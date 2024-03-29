<?php

namespace App\Services;

use App\Models\Comment;
use App\Traits\AuthUser;

class CommentService
{
    use AuthUser;

    public function storeComment($data, $forum)
    {
        $user = $this->getAuthUser();

        $user->forumComments()->create([
            'body' => $data['body'],
            'forum_id' => $forum->id
        ]);
    }

    public function updatedComment($data, $forum, $comment)
    {
        $forumComment = Comment::find($comment->id);
        $this->checkOwnership($forumComment->user_id);

        $comment->update(['body' => $data['body']]);
    }

    public function deleteComment($forum, $comments)
    {
        $comment = Comment::findOrFail($comments->id);
        $this->checkOwnership($comment->user_id);
        $comment->delete();
    }
}
