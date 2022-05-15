@extends('layouts.backend.template')

@section('content')
    <ul class="list-group mt-5">
        <li class="list-group-item">
            <strong>Index Post</strong>
        </li>
        <li class="list-group-item">
            <form action="{{ route('backend.posts.index') }}" method="get">
                <div class="input-group">
                    <input type="search" class="form-control form-control-lg" placeholder="Type your keywords here" name="title" value="{{ $request['title'] }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-lg btn-default">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (session('update'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    <strong>{{ session('update') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </li>
        <li class="list-group-item">
            <table class="table">
                <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Body</th>
                    <th>Status</th>
                    <th>Approved</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>{{ $post->title }}</td>
                        <td>
                            <img src="{{ is_null($post->image) ? asset('storage/post/default.png') : asset('storage/post/'.$post->image) }}" alt="">
                        </td>
                        <td>{{strip_tags($post->body)}}</td>
                        <td>
                            @if($post->status == true)
                                <span class="badge bg-success">Published</span>
                            @else
                                <span class="badge bg-danger">Pending</span>
                            @endif
                        </td>
                        <td>
                            @if($post->is_approved == true)
                                <span class="badge bg-success">Approved</span>
                            @else
                                <span class="badge bg-danger">Pending</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('backend.posts.edit', $post->id) }}" class="btn btn-warning">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                    <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                </svg>
                            </a>
                            <a class="btn btn-danger" onclick="deletePost({{ $post->id }})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-trash" viewBox="0 0 16 16">
                                    <path
                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                    <path fill-rule="evenodd"
                                          d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                </svg>
                            </a>
                            <form id="delete-{{ $post->id }}" action="{{ route('backend.posts.destroy',$post->id) }}"
                                  method="post" style="display: none">
                                @csrf
                                @method('delete')
                            </form>
                        </td>
                    </tr>
                @empty
                    <p>-- NOT FOUND DATA --</p>
                @endforelse
                </tbody>
            </table>
        </li>
        <li class="list-group-item">
            {{ $posts->links() }}
        </li>
    </ul>
@endsection

@push('scripts')
    <script>
        function deletePost(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.preventDefault();
                    document.getElementById('delete-' + id).submit();
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                }
            })
        }
    </script>
@endpush



