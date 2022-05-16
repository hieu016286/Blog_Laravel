<?php

namespace App\Traits;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait HandleImage
{
    public function verifyImage($request) {
        return $request->hasFile('image');
    }

    public function saveImage($request) {
        if($this->verifyImage($request)) {
            $destination = $request->file('image');
            $filename = time() . '.' . $destination->getClientOriginalExtension();
            if(!Storage::disk('public')->exists('post')) {
                Storage::disk('public')->makeDirectory('post');
            }
            $postImage = Image::make($destination)->resize(259,194)->save();
            Storage::disk('public')->put('post/'.$filename, $postImage);
            return $filename;
        }
    }

    public function updateImage($request, $currentImage) {
        if($this->verifyImage($request)) {
            $this->deleteImage($currentImage);
        }
        return $this->saveImage($request);
    }

    public function deleteImage($imageName) {
        if(Storage::disk('public')->exists('post/'.$imageName)) {
            return Storage::disk('public')->delete('post/'.$imageName);
        }
    }
}
