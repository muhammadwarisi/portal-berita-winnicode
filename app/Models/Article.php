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
        'slug',
        'content',
        'category_id',
        'featured_image',
        'user_id',
        'published_at',
    ];
    
    // Tambahkan metode ini untuk menghasilkan slug otomatis
    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = \Illuminate\Support\Str::slug($article->title);
                
                // Pastikan slug unik
                $count = static::whereRaw("slug RLIKE '^{$article->slug}(-[0-9]+)?$'")->count();
                
                if ($count > 0) {
                    $article->slug = "{$article->slug}-{$count}";
                }
            }
        });
        
        static::updating(function ($article) {
            if ($article->isDirty('title') && empty($article->slug)) {
                $article->slug = \Illuminate\Support\Str::slug($article->title);
                
                // Pastikan slug unik
                $count = static::whereRaw("slug RLIKE '^{$article->slug}(-[0-9]+)?$'")
                    ->where('id', '!=', $article->id)
                    ->count();
                
                if ($count > 0) {
                    $article->slug = "{$article->slug}-{$count}";
                }
            }
        });
    }

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
