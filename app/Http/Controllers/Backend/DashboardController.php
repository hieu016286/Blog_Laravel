<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\PostService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $postService;
    public function __construct(PostService $postService) {
        $this->postService = $postService;
    }

    public function index(Request $request) {
        $posts = $this->postService->search($request);
        return view('backend.dashboard', compact('posts'));
    }
}
