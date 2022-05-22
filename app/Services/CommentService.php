<?php

namespace App\Services;

use App\Repositories\CommentRepository;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    protected CommentRepository $commentRepository;
    public function __construct(CommentRepository $commentRepository) {
        $this->commentRepository = $commentRepository;
    }

    public function findById($id) {
        return $this->commentRepository->findById($id);
    }

    public function create($request, $post)
    {
        $dataCreate = $request->all();
        $dataCreate['post_id'] = $post->id;
        $dataCreate['user_id'] = Auth::id();
        return $this->commentRepository->create($dataCreate);
    }

    public function delete($comment)
    {
        $comment->delete();
        return $comment;
    }
}
