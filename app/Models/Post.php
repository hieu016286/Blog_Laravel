<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

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

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeWithTitle($query, $title) {
        return $title ? $query->where('title', 'LIKE', "%{$title}%") : null;
    }

    public function scopeWithApproved($query, $isApproved, $from){
        if($isApproved === '' && $from !== 'home') {
            return null;
        } else {
            if($from === 'home') {
                return $query->where('is_approved', 1);
            } else {
                return $query->where('is_approved', $isApproved);
            }
        }
    }

    public function scopeWithPublished($query, $from){
        return $from === 'home' ?  $query->where('status', 1) : null;
    }

    public function scopeWithAuthor($query, $id, $from){
        if(!Auth::user()->hasPermission() && $from !== 'home') {
            return $query->where('user_id', $id);
        } elseif (Auth::user()->hasPermission() && $from === 'posts') {
            return $query->where('user_id', $id);
        } else {
            return null;
        }
    }

}
