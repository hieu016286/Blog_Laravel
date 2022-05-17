<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function create($id): JsonResponse
    {
        $user = Auth::user();
        $isFavorite = $user->favorite_posts()->where('post_id',$id)->count();

        if($isFavorite == 0){
            $user->favorite_posts()->attach($id);
        } else {
            $user->favorite_posts()->detach($id);
        }
        return response()->json([
            'message' => 'Favorite Success !!!',
        ]);
    }
}
