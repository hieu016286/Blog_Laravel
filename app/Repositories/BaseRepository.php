<?php

namespace App\Repositories;

abstract class BaseRepository
{
    protected $model;
    abstract public function model();

    public function __construct() {
        $this->model = app($this->model());
    }

    public function findById($id) {
        return $this->model->find($id);
    }

    public function create($dataCreate) {
        return $this->model->create($dataCreate);
    }
}
