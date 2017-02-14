@extends('main')

@section('title', "| $post->title" )

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>{{ $post->title }}</h1>
            <p>{{ $post->body }}</p>
            <hr>
            <P>Posted In: {{ $post->category->name }}</P>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h3>Comments</h3>
            @foreach($post->comments as $comment)
                <div class="comment">
                    <p><strong>Name:</strong> {{ $comment->name }}</p>
                    <p><strong>Comment:</strong> <br> {{ $comment->comment }}</p>
                </div>
                <hr>

            @endforeach
        </div>
    </div>

    <div class="row">
        <div id="comment-form" class="col-md-8 col-md-offset-2">
        {{ Form::open(['route' => ['comments.store', $post->id], 'method' => 'POST']) }}
            <div class="row">
                <div class="col-sm-6">
                    {{ Form::label('name', 'Name:') }}
                    {{ Form::text('name', null, ['class' => 'form-control']) }}

                </div>
                <div class="col-sm-6">
                    {{ Form::label('email', 'Email:') }}
                    {{ Form::email('email', null, ['class' => 'form-control']) }}

                </div>

                <div class="col-sm-12">
                    {{ Form::label('comment', 'Comment:') }}
                    {{ Form::textarea('comment', null, ['class' => 'form-control', 'rows' => '5']) }}

                    <br>

                    {{ Form::submit('Add Comment', ['class' => 'btn btn-success']) }}
                </div>

            </div>

        {{ Form::close() }}
        </div>
    </div>

@endsection