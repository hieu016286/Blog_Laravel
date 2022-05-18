<?php

namespace App\Services;

use App\Repositories\CommentRepository;
use App\Repositories\PostRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    protected CommentRepository $commentRepository;
    protected PostRepository $postRepository;
    public function __construct(CommentRepository $commentRepository, PostRepository $postRepository) {
        $this->commentRepository = $commentRepository;
        $this->postRepository = $postRepository;
    }

    public function create($request, $id): RedirectResponse
    {
        $dataCreate = $request->all();
        $dataCreate['post_id'] = $id;
        $dataCreate['user_id'] = Auth::id();
        $post = $this->postRepository->findById($id);
        if($post->status === 1 && $post->is_approved === 1) {
            return $this->commentRepository->create($dataCreate);
        } else {
            return redirect()->back();
        }
    }

    public function delete($id): RedirectResponse
    {
        $comment = $this->commentRepository->findById($id);
        if($comment->post->user_id === Auth::id() || $comment->user_id === Auth::id()) {
            $comment->delete();
            return $comment;
        }
        else {
            return redirect()->back();
        }
    }
}
