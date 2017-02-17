@extends('main')

@section('title', '| Blog')

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Blog</h1>
        </div>
    </div>

    @foreach($posts as $post)
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h2>{{ $post->title }}</h2>
            <h5>Published: {{ $post->created_at }}</h5>
            <p>{{ str_limit(strip_tags($post->body), 200) }}</p>
            <a href="{{ route('blog.single', $post->slug) }}">Read More</a>
        </div>
    </div>
    @endforeach

    <div class="row">
        <div class="col-md-12 text-center">
            {{ $posts->links() }}
        </div>
    </div>


@endsection