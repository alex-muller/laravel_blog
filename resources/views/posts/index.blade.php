@extends('main')

@section('title', '| All Posts')

@section('content')

    <div class="row">
        <div class="col-sm-10">
            <h1>All Posts</h1>
        </div>
        <div class="col-sm-2">
            <a href="{{ route('posts.create') }}" class="btn btn-lg btn-block btn-primary btn-h1-spacing">Create Post</a>
        </div>
        <div class="col-md-12">
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <th>#</th>
                    <th>Title</th>
                    <th>Body</th>
                    <th>Created At</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <th>{{ $post->id }}</th>
                            <td>{{ $post->title }}</td>
                            <td>{{ str_limit(strip_tags($post->body), 20) }}</td>
                            <td>{{ $post->created_at }}</td>
                            <td>
                                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-success">view</a>
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-center">
                {!! $posts->links() !!}
            </div>
        </div>
    </div>

@endsection