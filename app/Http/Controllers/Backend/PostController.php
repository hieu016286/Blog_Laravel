<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostRequest;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PostController extends Controller
{
    protected PostService $postService;
    public function __construct(PostService $postService) {
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $posts = $this->postService->index($request);
        return view('backend.posts.index', compact('posts','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('backend.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request): RedirectResponse
    {
        $this->postService->create($request);
        return redirect()->route('backend.posts.index')->with('success', 'Create Post Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        $post = $this->postService->findById($id);
        if(Gate::allows('show-post', $post)) {
            return view('backend.posts.show',compact('post'));
        } else {
            abort(403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $post = $this->postService->findById($id);
        if(Gate::allows('update-post', $post)) {
            return view('backend.posts.edit', compact('post'));
        } else {
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse|JsonResponse
    {
        $post = $this->postService->findById($id);
        if(Gate::allows('update-post', $post)) {
            $this->postService->update($request, $post);
            if(!count($request->all())) {
                return response()->json([
                    'message' => 'Update Post Success !!!',
                ]);

            }
            return redirect()->route('backend.posts.index')->with('update', 'Update Post Success');
        } else {
            abort(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        $post = $this->postService->findById($id);
        if(Gate::allows('delete-post', $post)) {
            $this->postService->delete($post);
            return redirect()->back();
        } else {
            abort(403);
        }
    }

    public function favorite($id) {
        $post = $this->postService->findById($id);
        if(Gate::allows('favorite|comment-post', $post)) {
            $this->postService->favorite($post);
            return response()->json([
                'message' => 'Favorite Success !!!',
            ]);
        } else {
            abort(403);
        }
    }
}
