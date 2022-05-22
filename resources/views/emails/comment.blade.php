@component('mail::message')
# Hello {{ $comment->post->user->name }}
<br>
New Comment In Your Post

@component('mail::button', ['url' => route('backend.posts.show', $comment->post->id)])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
