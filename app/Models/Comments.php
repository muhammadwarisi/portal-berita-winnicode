<?php

namespace App\Models;

use App\Models\User;
use App\Models\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comments extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $fillable = ['id', 'comment_article', 'user_id', 'article_id'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function post()
    {
        return $this->belongsTo(Article::class);
    }
}
