@extends('layouts.blog')

@section('content')
<h1>Edit Posts</h1>

    {{form::open(['action'=> ['postsController@update', $post->id], 'method'=>'POST' , 'enctype'=> 'multipart/form-data'])}}

    <div class="form-group">
        {{ Form::label('title', 'Title')}}
        {{ Form::text('title', $post->title, ['class'=>'form-control', 'placeholder'=> 'Title'])}}
    </div>

    <div class="form-group">
        {{ Form::label('body', 'Body')}}
        {{ Form::textarea('body', $post->body, ['id' =>'Bodyeditor' , 'class'=>'form-control', 'placeholder'=> 'Body Text'])}}
    </div>

     <div class="form-group">
        {{ Form::file('cover_image') }}
    </div>

    {{ Form::hidden('_method', 'PUT')}}
    {{ Form::submit('Submit', ['class' =>'btn btn-outline-primary']) }}

    {{ Form::close()}}
@endsection
