<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'image',
        'body',
        'status',
        'is_approved'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function favorite_to_users(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'user_post')->withTimestamps();
    }

    public function scopeWithTitle($query, $title) {
        return $title ? $query->where('title', 'LIKE', "%{$title}%") : null;
    }

    public function scopeApproved($query){
        return $query->where('is_approved',1);
    }

    public function scopePublished($query){
        return $query->where('status',1);
    }
}
