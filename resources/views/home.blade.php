@extends('layouts.app')

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
                                <a href="{{ route('frontend.posts.show',$post->id) }}"><img class="card-img-top" src="{{ is_null($post->image) ? asset('storage/post/default.png') : asset('storage/post/'.$post->image) }}" alt="..." /></a>
                                <div class="card-body">
                                    <div class="small text-muted">{{ $post->created_at }}</div>
                                    <h2 class="card-title h4">{{ $post->title }}</h2>
                                    <p class="card-text">{{strip_tags($post->body)}}</p>
                                    <a class="btn btn-secondary" href="#!">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                                            <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                                        </svg>
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
    <!-- Footer-->
    @include('layouts.frontend.partials.footer')
@endsection
