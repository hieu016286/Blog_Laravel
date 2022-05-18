<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    protected PostService $postService;
    public function __construct(PostService $postService) {
        $this->postService = $postService;
    }

    public function create($id): JsonResponse|RedirectResponse
    {
        $user = Auth::user();
        $isFavorite = $user->favorite_posts()->where('post_id',$id)->count();

        $post = $this->postService->findById($id);
        if($post->status === 1 && $post->is_approved === 1) {
            if($isFavorite == 0){
                $user->favorite_posts()->attach($id);
            } else {
                $user->favorite_posts()->detach($id);
            }
            return response()->json([
                'message' => 'Favorite Success !!!',
            ]);
        } else {
            return redirect()->back();
        }
    }
}
