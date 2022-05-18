<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CommentRequest;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected CommentService $commentService;
    public function __construct(CommentService $commentService) {
        $this->commentService = $commentService;
    }

    public function create(CommentRequest $request, $id): RedirectResponse
    {
        $this->commentService->create($request, $id);
        return redirect()->back();
    }

    public function destroy($id): JsonResponse
    {
        $this->commentService->delete($id);
        return response()->json([
            'message' => 'Delete Comment Success !!!',
        ]);
    }
}
