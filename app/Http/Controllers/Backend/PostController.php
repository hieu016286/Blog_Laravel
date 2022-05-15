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

    public function index(Request $request) {
        $posts = $this->postService->searchAllPost($request);
        return view('backend.posts.index', compact('posts','request'));
    }

    public function create() {
        return view('backend.posts.create');
    }

    public function store(PostRequest $request) {
        $this->postService->create($request);
        return redirect()->route('backend.posts.index')->with('success', 'Create Post Success');
    }

    public function edit($id) {
        $post = $this->postService->findById($id);
        return view('backend.posts.edit', compact('post'));
    }

    public function update(PostRequest $request, $id) {
        $this->postService->update($request, $id);
        return redirect()->route('backend.posts.index')->with('update', 'Update Post Success');
    }

    public function destroy($id) {
        $this->postService->delete($id);
        return redirect()->route('backend.posts.index');
    }
}
