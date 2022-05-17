<?php

namespace App\Repositories;

abstract class BaseRepository
{
    protected mixed $model;
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

    public function count() {
        return $this->model->all()->count();
    }
}
