<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('update-post', function (User $user, Post $post){
            return $user->id === $post->user_id;
        });

        Gate::define('delete-post', function (User $user, Post $post){
            return $user->id === $post->user_id;
        });

        Gate::define('show-post', function (User $user, Post $post) {
            if($user->id === $post->id) {
                return true;
            } else if ($post->status === 1 && $post->is_approved === 1) {
                return true;
            }
        });

        Gate::define('favorite|comment-post', function (User $user, Post $post){
            return $post->status === 1 && $post->is_approved === 1;
        });

        Gate::define('delete-comment', function (User $user, Comment $comment){
            if($comment->post->status === 1 && $comment->post->is_approved === 1) {
                if($comment->user_id === $user->id) {
                    return true;
                } elseif ($comment->post->user_id === $user->id) {
                    return true;
                }
            }
        });

        Gate::before(function ($user) {
            if ($user->hasPermission()) {
                return true;
            }
        });
    }
}
