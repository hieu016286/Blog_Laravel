<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\PostService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    protected PostService $postService;
    protected UserService $userService;
    public function __construct(PostService $postService, UserService $userService) {
        $this->postService = $postService;
        $this->userService = $userService;
    }

    public function index(Request $request): View
    {
        $posts = $this->postService->index($request);
        $postCount = $this->postService->count();
        $userCount = $this->userService->count();
        return view('backend.dashboard', compact('postCount','userCount','posts','request'));
    }
}
