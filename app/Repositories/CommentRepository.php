<?php

namespace App\Repositories;
use App\Models\Comment;

class CommentRepository extends BaseRepository
{
    public function model(): string
    {
        return Comment::class;
    }
}
