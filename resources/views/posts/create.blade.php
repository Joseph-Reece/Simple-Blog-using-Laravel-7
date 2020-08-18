@extends('layouts.blog')

@section('content')
<h1>Create Posts</h1>

    {{form::open(['action'=>'postsController@store', 'method'=>'POST', 'enctype'=> 'multipart/form-data'])}}

    <div class="form-group">
        {{ Form::label('title', 'Title')}}
        {{ Form::text('title', '', ['class'=>'form-control', 'placeholder'=> 'Title'])}}
    </div>

    <div class="form-group">
        {{ Form::label('body', 'Body')}}
        {{ Form::textarea('body', '', ['id' =>'Bodyeditor' , 'class'=>'form-control', 'placeholder'=> 'Body Text'])}}
    </div>

    <div class="form-group">
        {{ Form::file('cover_image') }}
    </div>

    {{  Form::submit('Submit', ['class' =>'btn btn-outline-primary']) }}

    {{ Form::close()}}
@endsection
