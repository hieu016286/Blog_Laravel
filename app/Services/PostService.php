<?php

namespace App\Services;
use App\Repositories\PostRepository;
use App\Traits\HandleImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostService
{
    use HandleImage;
    protected $postRepository;
    public function __construct(PostRepository $postRepository) {
        $this->postRepository = $postRepository;
    }

    public function search($request) {
        $dataSearch = $request->all();
        $dataSearch['title'] = $request->title ?? '';
        return $this->postRepository->search($dataSearch, Auth::id())->appends($request->all());
    }

    public function create($request) {
        $dataCreate = $request->all();
        $dataCreate['user_id'] = Auth::id();
        $dataCreate['slug'] = Str::slug($dataCreate['title'],'-');
        $post = $this->postRepository->create($dataCreate);
        if(isset($dataCreate['image'])) {
            $imageName = $this->saveImage($request);
            $post->update([
                'image' => $imageName
            ]);
        }
        Auth::user()->roles->contains('name','admin') ? $post->update(['is_approved' => 1]) : null;
        return $post;
    }

    public function delete($id) {
        $post = $this->postRepository->findById($id);
        $post->delete();
        $this->deleteImage($post->image);
        return $post;
    }
}
