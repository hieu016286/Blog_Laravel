<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Services\PostService;
use Illuminate\View\View;

class PostController extends Controller
{
    protected PostService $postService;
    public function __construct(PostService $postService) {
        $this->postService = $postService;
    }

    public function indexAllPosts(Request $request): View
    {
        $posts = $this->postService->searchAllPost($request);
        return view('backend.posts.all', compact('posts','request'));
    }

    public function index(Request $request): View {
        $posts = $this->postService->search($request);
        return view('backend.posts.index', compact('posts','request'));
    }

    public function create(): View {
        return view('backend.posts.create');
    }

    public function store(PostRequest $request): RedirectResponse {
        $this->postService->create($request);
        return redirect()->route('backend.posts.index')->with('success', 'Create Post Success');
    }

    public function edit($id) {
        $post = $this->postService->findById($id);
        return view('backend.posts.edit', compact('post'));
    }

    public function update(PostRequest $request, $id): RedirectResponse {
        $this->postService->update($request, $id);
        return redirect()->route('backend.posts.index')->with('update', 'Update Post Success');
    }

    public function destroy($id): RedirectResponse {
        $this->postService->delete($id);
        return redirect()->route('backend.posts.index');
    }

    public function pending(Request $request): View {
        $posts = $this->postService->pending($request);
        return view('backend.posts.pending', compact('posts','request'));
    }

    public function approved($id): JsonResponse {
        $this->postService->approved($id);
        return response()->json([
            'message' => 'Approved Success !!!',
        ]);
    }
}
