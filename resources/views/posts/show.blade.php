@extends('layouts.blog')


@section('content')
<a href="/posts" class="btn btn-outline-primary">Go Back</a>
<hr>
    <h1>{{ $posts->title }}</h1>

    <img src="/storage/cover_images/{{ $posts->cover_image}}" alt="No image to show"idth="50%">
    <br>
    {{-- <hr> --}}
    <br>
    <div class="container">
        {!! $posts->body !!}
    </div>
<br>
    <hr>
<br>

<small class="text-muted">Written on {{ $posts->created_at }} by {{ $posts->user->name }}</small>
<br>
<hr>
<br>

@if (!Auth::guest())

    @if (Auth::user()->id == $posts->user_id)
        <a href="/posts/{{ $posts->id }}/edit" class="btn btn-outline-success">Edit</a>

        {{-- Delete form --}}

        {{ Form::open(['action'=>['postsController@destroy' , $posts->id], 'method'=>'POST', 'class'=>'float-right'])}}

        {!! Form::hidden('_method', 'DELETE' )!!}

        {!! Form::submit('Delete', ['class'=>'btn btn-sm btn-outline-danger']) !!}

        {!! Form::close() !!}

    @endif

@endif


@endsection
