<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\PostService;
use App\Services\UserService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected PostService $postService;
    protected UserService $userService;
    public function __construct(PostService $postService, UserService $userService) {
        $this->postService = $postService;
        $this->userService = $userService;
    }

    public function index() {
        $posts = $this->postService->count();
        $users = $this->userService->count();
        return view('backend.dashboard', compact('posts','users'));
    }
}
