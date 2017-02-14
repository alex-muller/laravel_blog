@extends('main')

@section('stylesheets')
    <link rel="stylesheet" href="style.css">
@endsection

@section('title', '| Homepage')

@section('content')
<div class="jumbotron">
    <h1>Welcome to My Blog!</h1>
    <p><span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium autem dolor doloribus exercitationem
            facilis, optio quidem ut. Corporis debitis doloribus magni minima mollitia, nam provident quaerat rem similique.
            Itaque, obcaecati.</span>
    <p><a class="btn btn-primary btn-lg" href="#" role="button">Popular Post</a></p>
</div>

<div class="row">
    <div class="col-md-8">
        @foreach($posts as $post)
            <div class="post">
                <h3>{{ $post->title }}</h3>
                <p>{{ str_limit($post->body, 200) }}</p>
                <a href="{{ route('blog.single', $post->slug) }}" class="btn btn-primary">Read More</a>
            </div>
            <hr>
        @endforeach
    </div>
    <div class="col-md-3 col-md-offset-1">
        <h2>Sidebar</h2>
    </div>
</div>
@endsection

@section('scripts')

@endsection