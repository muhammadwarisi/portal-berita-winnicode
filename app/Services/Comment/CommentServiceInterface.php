<?php

namespace App\Services\Comment;

interface CommentServiceInterface
{
    public function getAllComment();
    public function getCommentById($id);
    public function createComment($data);
    public function updateComment($id, $data);
    public function deleteComment($id);
}
