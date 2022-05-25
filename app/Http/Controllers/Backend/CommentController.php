<?php

namespace App\Http\Controllers\Backend;

use App\Events\PostNotification;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CommentRequest;
use App\Mail\Comment;
use App\Services\CommentService;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{
    protected CommentService $commentService;
    protected PostService $postService;
    public function __construct(CommentService $commentService, PostService $postService) {
        $this->commentService = $commentService;
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request): JsonResponse
    {
        $post = $this->postService->findById($request->id);
        if(Gate::allows('favorite|comment-post', $post)) {
            $comment = $this->commentService->create($request, $post);
            Mail::to($post->user->email)->send(new Comment($comment));
            event(new PostNotification('New Comment In Your Post', $comment));
            return response()->json([
                'message' => 'Comment Success !!!',
                'comment' => $comment
            ]);
        } else {
            abort(403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): JsonResponse
    {
        $comment = $this->commentService->findById($id);
        if(Gate::allows('delete-comment', $comment)) {
            $this->commentService->delete($comment);
            return response()->json([
                'message' => 'Delete Comment Success !!!',
            ]);
        } else {
            abort(403);
        }
    }
}
