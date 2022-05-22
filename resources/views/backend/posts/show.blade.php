@extends('layouts.app')

@push('css')
    <style>
        .comment{
            border: 1px solid rgba(16, 46, 46, 1);
            background-color: wheat;
            border-radius: 5px;
            padding-left: 40px;
            padding-right: 30px;
            padding-top: 10px;

        }
        .comment h4,.comment span,.darker h4,.darker span{
            display: inline;
        }

        .comment p,.comment span,.darker p,.darker span{
            color: rgb(184, 183, 183);
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="card" style="width: 100%;">
                <img src="{{ is_null($post->image) ? asset('storage/post/default.png') : asset('storage/post/'.$post->image) }}" class="card-img-top" alt="..." style="width: 400px">
                <div class="card-body">
                    <h5 class="card-title">{{ $post->title }}</h5>
                    <p class="card-text">{{ strip_tags($post->body) }}</p>
                    <span class="badge bg-warning">By {{ $post->user->name }} at {{ $post->created_at->diffForHumans() }}</span>
                    <span class="badge bg-primary">{{ $post->favorite_to_users->count() }} Likes</span>
                    <a style="float: right" class="btn btn-primary" href="{{ route('home') }}">Back To Home</a>
                </div>
                <div class="card-footer">
                    <h4>POST COMMENT :</h4>
                    <div class="col-lg-8 col-md-12">
                        <div class="comment-form">
                            <div class="row">
                                <div class="col-sm-12">
                                    <textarea name="comment" rows="2" class="text-area-message form-control"
                                    placeholder="Enter your comment ..." aria-required="true" aria-invalid="false"></textarea >
                                </div>
                                <div class="col-sm-12 mt-3">
                                    <button class="btn btn-success" disabled data-post-id="{{ $post->id }}">Submit</button>
                                </div>
                            </div>
                        </div>
                        <br>
                        <h4>COMMENTS (<span class="countComment">{{ $post->comments->count() }}</span>)</h4>
                        <div id="field-comment">
                            @foreach ($post->comments->sortByDesc('created_at') as $c )
                                <div id="comment-{{$c->id}}" class="comment mt-4 text-justify">
                                    <img src="{{ asset('storage/user/default.jpg') }}" alt="" class="rounded-circle" width="40" height="40" style="margin-right: 20px">
                                    <h4>{{ $c->user->name }}</h4>
                                    <span>- {{ $c->created_at->diffForHumans() }}</span>
                                    <br><br>
                                    <p>{{ $c->comment }}</p>
                                    @if($post->user_id === Auth::id() || $c->user_id === Auth::id() || Auth::user()->hasPermission())
                                        <a class="btn btn-danger" onclick="deleteComment({{ $c->id }})">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.text-area-message').keyup(function() {
                if($(this).val() !== '') {
                    $('.btn-success').prop('disabled', false);
                } else {
                    $('.btn-success').prop('disabled', true);
                }
            });
            $('.btn-success').click(function (){
                let id = $(this).attr('data-post-id');
                let data = $('.text-area-message').val();
                $.ajax({
                    type: 'POST',
                    url: `/comments`,
                    data: {
                        comment: data,
                        id: id
                    }
                }).then(function (res) {
                    if(res.message === 'Comment Success !!!') {
                        let comment = res.comment;
                        $('#field-comment').prepend(`
                            <div id="comment-${comment.id}" class="comment mt-4 text-justify">
                                <img src="{{ asset('storage/user/default.jpg') }}" alt="" class="rounded-circle" width="40" height="40" style="margin-right: 20px">
                                <h4>{{ Auth::user()->name }}</h4>
                                <span>- ${comment.created_at}</span>
                                <br><br>
                                <p>${comment.comment}</p>
                                <a class="btn btn-danger" onclick="deleteComment(${comment.id})">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        `);
                        let count = parseInt($('.countComment').text());
                        $('.countComment').text(count + 1);
                    }
                })
            });
        });
        function deleteComment(id) {
            $.ajax({
                type: 'DELETE',
                url: `/comments/${id}`,
                data: {},
            }).then(function (res) {
                if(res.message === 'Delete Comment Success !!!') {
                    $('#comment-' + id).hide('slow');
                    let count = parseInt($('.countComment').text());
                    $('.countComment').text(count - 1);
                }
            })
        }
    </script>
@endpush
