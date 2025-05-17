<?php

namespace App\Models;

use App\Models\User;
use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleReview extends Model
{
    use HasFactory;
    protected $fillable = [
        'article_id',
        'reviewer_id',
        'status',
        'comments',
        'reviewed_at'
    ];
    protected $casts = [
        'reviewed_at' => 'datetime',
    ];
    protected $table = 'article_review'; // Nama tabel di database

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
