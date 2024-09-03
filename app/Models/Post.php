<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'img_path',
        'approved',
        'category_id',
        'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->MorphMany(Comment::class, 'commentable')->whereNull('parent_id')->where('approved', 1);
    }

    public function scopeApproved($query)
    {
        return $query->whereApproved(1)->latest();
    }
}
