<?php

namespace App\Services;
use App\Repositories\PostRepository;
use App\Traits\HandleImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostService
{
    use HandleImage;
    protected PostRepository $postRepository;
    public function __construct(PostRepository $postRepository) {
        $this->postRepository = $postRepository;
    }

    public function count() {
        return $this->postRepository->count(Auth::id());
    }

    public function index($request) {
        $dataSearch = $request->all();
        $dataSearch['user_id'] = Auth::id();
        $dataSearch['from'] = $request->path();
        return $this->postRepository->index($dataSearch)->appends($request->all());
    }

    public function findById($id) {
        return $this->postRepository->findById($id);
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

    public function update($request, $post) {
        $dataUpdate = $request->all();
        isset($dataUpdate['title']) ? $dataUpdate['slug'] = Str::slug($dataUpdate['title'],'-') : null;
        if(!isset($dataUpdate['status']) && count($dataUpdate) > 0) {
            $post->update([
                'status' => 0
            ]);
        }
        if(isset($dataUpdate['image'])) {
            $imageName = $this->updateImage($request, $post->image);
            $post->update([
                'image' => $imageName
            ]);
            unset($dataUpdate['image']);
        }
        $post->update($dataUpdate);
        Auth::user()->roles->contains('name','admin') ? $post->update(['is_approved' => 1]) : null;
        return $post;
    }

    public function delete($post) {
        $post->delete();
        $this->deleteImage($post->image);
        return $post;
    }

    public function favorite($post) {
        $isFavorite = Auth::user()->favorite_posts()->where('post_id',$post->id)->count();
        if($isFavorite === 0) {
            Auth::user()->favorite_posts()->attach($post->id);
        } else {
            Auth::user()->favorite_posts()->detach($post->id);
        }
        return $isFavorite;
    }
}
