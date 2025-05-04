<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserArticleViews extends Model
{
    protected $table = "user_article_views";
    protected $primaryKey = "id";
    public $timestamps = true;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id', 'id');
    }
}
