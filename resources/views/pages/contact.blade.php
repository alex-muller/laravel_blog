@extends('main')

@section('title', '| Contact')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1>Contact Me</h1>
        <hr>
        <form action="{{ url('contact') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" class="form-control">
            </div>
            <div class="form-group">
                <label for="subject">Subject:</label>
                <input type="text" id="subject" name="subject" class="form-control">
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea name="message" id="message" class="form-control" placeholder="Type your message here..."></textarea>
            </div>
            <input type="submit" value="Send Message" class="btn btn-success">
        </form>
    </div>
</div>
@endsection
