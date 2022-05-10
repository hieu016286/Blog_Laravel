<?php
namespace App\Repositories;
abstract class BaseRepository
{
    protected $model;
    abstract public function model();

    public function __construct() {
        $this->model = app($this->model());
    }
}
