<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostRequest;
use Illuminate\Http\Request;
use App\Services\PostService;

class PostController extends Controller
{
    protected $postService;
    public function __construct(PostService $postService) {
        $this->postService = $postService;
    }

    public function create() {
        return view('backend.posts.create');
    }

    public function store(PostRequest $request) {
        $this->postService->create($request);
    }
}
