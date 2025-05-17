<?php

namespace App\Models;

use App\Models\User;
use App\Models\ArticleReview;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
        'category_id',
        'featured_image',
        'user_id',
        'published_at',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewers()
    {
        return $this->belongsToMany(User::class, 'user_article_reviews')
            ->withPivot('is_assigned')
            ->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(ArticleReview::class);
    }
}
