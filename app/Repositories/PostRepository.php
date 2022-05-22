<?php

namespace App\Repositories;
use App\Models\Post;

class PostRepository extends BaseRepository
{
    public function model(): string
    {
        return Post::class;
    }

    public function index($dataSearch) {
        return $this->model->withAuthor($dataSearch['user_id'], $dataSearch['from'])
                           ->withApproved($dataSearch['approved'] ?? '', $dataSearch['from'])
                           ->withPublished($dataSearch['from'])
                           ->withTitle($dataSearch['title'] ?? '')
                           ->latest('id')->paginate(5);
    }

    public function count($id)
    {
        return $this->model->withAuthor($id,'')->get()->count();
    }
}
