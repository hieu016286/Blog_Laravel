<?php

namespace App\Repositories;
use App\Models\Post;

class PostRepository extends BaseRepository
{
    public function model(): string
    {
        return Post::class;
    }

    public function search($dataSearch, $id) {
        $title = $dataSearch['title'];
        return $this->model->where('user_id', $id)->withTitle($title)->latest('id')->paginate(5);
    }

    public function searchAllPost($dataSearch) {
        $title = $dataSearch['title'];
        return $this->model->withTitle($title)->latest('id')->paginate(5);
    }

    public function pending($dataSearch) {
        $title = $dataSearch['title'];
        return $this->model->where('is_approved', 0)->withTitle($title)->latest('id')->paginate(5);
    }
}
