@extends('layouts.backend.template')

@section('content')
    <form action="{{ route('backend.posts.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <ul class="list-group mt-5">
            <li class="list-group-item">
                <strong>Create Post</strong>
            </li>
            <li class="list-group-item">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control" placeholder="title ..." name="title">
                    @if($errors->has('title'))
                        <p class="text-danger">{{$errors->first('title')}}</p>
                    @endif
                </div>
                <div class="mb-3">
                    <label class="form-label">Image</label>
                    <input class="form-control" type="file" id="image" name="image">
                </div>
                <div class="mb-3">
                    <img id="showImage" src="{{ asset('storage/post/default.png') }}" alt="" style="width: 259px; height: 194px; border: 1px solid #000;">
                </div>
                <div class="mb-3">
                    <label class="form-label">Body</label>
                    <textarea class="form-control" id="summernote" name="body"></textarea>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="publish" name="status">
                    <label class="form-check-label" for="flexCheckDefault">
                        <strong>Publish</strong>
                    </label>
                </div>
            </li>
            <li class="list-group-item">
                <button type="submit" class="btn btn-success">Create</button>
            </li>
        </ul>
    </form>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            let defaultImg = "{{ asset('storage/post/default.png') }}";
            $('#image').change(function(e){
                if(e.target.files['0']) {
                    let reader = new FileReader();
                    reader.onload = function(e){
                        $('#showImage').attr('src',e.target.result);
                    }
                    reader.readAsDataURL(e.target.files['0']);
                } else {
                    $('#showImage').attr('src', defaultImg);
                }
            })
            $('#summernote').summernote({
                height: 300
            });
        })
    </script>
@endpush
