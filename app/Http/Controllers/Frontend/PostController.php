<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    protected PostService $postService;
    public function __construct(PostService $postService) {
        $this->postService = $postService;
    }

    public function show($id): View {
        $post = $this->postService->findById($id);
        return view('frontend.posts.show',compact('post'));
    }
}
