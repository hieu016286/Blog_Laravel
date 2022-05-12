<?php

namespace App\Repositories;
use App\Models\Post;

class PostRepository extends BaseRepository
{
    public function model()
    {
        return Post::class;
    }

    public function search($dataSearch, $id) {
        $title = $dataSearch['title'];
        return $this->model->where('user_id', $id)->withTitle($title)->latest('id')->paginate(1);
    }
}
