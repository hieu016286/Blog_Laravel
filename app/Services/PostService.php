<?php
namespace App\Services;
use App\Repositories\PostRepository;

class PostService
{
    protected $postRepository;
    public function __construct(PostRepository $postRepository) {
        $this->postRepository = $postRepository;
    }

    public function create($request) {
        $dataCreate = $request->all();
        dd($dataCreate);
    }
}
