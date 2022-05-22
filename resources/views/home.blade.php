@extends('layouts.app')

@push('css')
    <style>
        .favorite_posts {
            color: greenyellow;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <!-- Blog entries-->
            <div class="col-lg-8">
                <!-- Nested row for non-featured blog posts-->
                <div class="row">
                    <div class="col-lg-6">
                        @forelse($posts as $post)
                            <!-- Blog post-->
                            <div class="card mb-4">
                                <a href="{{ route('backend.posts.show',$post->id) }}"><img class="card-img-top" src="{{ is_null($post->image) ? asset('storage/post/default.png') : asset('storage/post/'.$post->image) }}" alt="..." /></a>
                                <div class="card-body">
                                    <div class="small text-muted">{{ $post->created_at }}</div>
                                    <h2 class="card-title h4">{{ $post->title }}</h2>
                                    <p class="card-text">{{strip_tags($post->body)}}</p>
                                    <a class="btn btn-primary"
                                       onclick="favoritePost({{ $post->id }})">
                                        <i class="fa-solid fa-heart {{ !Auth::user()->favorite_posts->where('pivot.post_id',$post->id)->count() == 0 ? 'favorite_posts' : '' }}" id="favorite-{{$post->id}}"></i>
                                        <span id="count-{{$post->id}}" >
                                            {{ $post->favorite_to_users->count() }}
                                        </span>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <strong>No Post</strong>
                        @endforelse
                    </div>
                </div>
                <!-- Pagination-->
                <nav aria-label="Pagination">
                    {{ $posts->links() }}
                </nav>
            </div>
            <!-- Side widgets-->
            <div class="col-lg-4">
                <!-- Search widget-->
                <form action="{{ route('home') }}" method="get">
                    <div class="card mb-4">
                        <div class="card-header">Search</div>
                        <div class="card-body">
                            <div class="input-group">
                                <input class="form-control" type="search" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search" name="title" value="{{ $request['title'] }}"/>
                                <button class="btn btn-primary" type="submit">Go!</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function favoritePost(id) {
            $.ajax({
                type: 'POST',
                url: `posts/${id}/favorite`,
                data: {},
            }).then(function (res) {
                if(res.message === 'Favorite Success !!!') {
                    let count = parseInt($('#count-' + id).text());
                    if($('#favorite-' + id).hasClass('favorite_posts')) {
                        $('#favorite-' + id).removeClass('favorite_posts');
                        $('#count-' + id).text(count - 1);
                    } else {
                        $('#favorite-' + id).addClass('favorite_posts');
                        $('#count-' + id).text(count + 1);
                    }
                }
            })
        }
    </script>
@endpush
