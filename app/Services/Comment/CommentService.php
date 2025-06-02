<?php

namespace App\Services\Comment;

use App\Models\Comments;
use Illuminate\Support\Facades\Auth;

class CommentService implements CommentServiceInterface
{
    public function getAllComment()
    {
        return Comments::all();
    }

    public function getCommentById($id)
    {
        return Comments::find($id);
    }

    public function createComment($data)
    {
        $data['user_id'] = Auth::id();
        return Comments::create($data);
    }

    public function updateComment($id, $data)
    {
        $comment = Comments::find($id);
        if ($comment) {
            $comment->update($data);
            return $comment;
        }
        return null;
    }
    public function deleteComment($id)
    {
        $comment = Comments::find($id);
        if ($comment) {
            $comment->delete();
            return true;
        }
        return false;
    }
}
