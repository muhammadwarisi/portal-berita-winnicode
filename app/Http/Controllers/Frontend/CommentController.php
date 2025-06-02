<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Services\Comment\CommentService;
use RealRashid\SweetAlert\Facades\Alert;

class CommentController extends Controller
{
    protected $comment;
    public function __construct(CommentService $comment)
    {
        $this->comment = $comment;
    }

    public function getComment($idArticle)
    {
        $comments = $this->comment->getCommentById($idArticle);
        return view('home.article_detail', compact('comments'));
    }

    public function storeComment(CommentRequest $request)
    {
        $data = $request->validated();
        // dd($data);
        $this->comment->createComment($data);
        Alert::success('Success', 'Berhasil Membuat Komentar');
        return redirect()->back();
    }

    public function updateComment($id, CommentRequest $request)
    {
        $data = $request->validated();
        $this->comment->updateComment($id, $data);
        Alert::success('Success', 'Berhasil Mengubah Komentar');
        return redirect()->back();
    }
    public function deleteComment($id)
    {
        $this->comment->deleteComment($id);
        Alert::success('Success', 'Berhasil Menghapus Komentar');
        return redirect()->back();
    }
}
