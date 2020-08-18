@extends('layouts.blog')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="/posts/create" class="btn btn-success">Create a Post</a>
                    <br>
                    <br>

                    <h4>Your Blog Posts</h4>
                    @if (count($posts) >0)
                     <div class="table-responsive">
                        <table class="table table-borderless table-striped">
                        <tr>
                            <th colspan="4">Title</th>
                        </tr>
                        @foreach ($posts as $post)
                            <tr>
                            <td>{{ $post->title }}</td>
                            <td><a href="/posts/{{ $post->id }}/edit" class="btn btn-sm btn-outline-primary"><i class="fa fa-edit"></i> Edit</a></td>
                            <td>
                                {{-- Delete form --}}

                                {{ Form::open(['action'=>['postsController@destroy' , $post->id], 'method'=>'POST', ])}}

                                {!! Form::hidden('_method', 'DELETE' )!!}

                                {!! Form::submit('Delete', ['class'=>'btn btn-sm btn-outline-danger']) !!}

                                {!! Form::close() !!}
                            </td>
                            </tr>
                            @endforeach
                    </table>
                    </div>

                    @else
                    <p>you have no Posts</p>

                    @endif



                </div>
            </div>
        </div>
    </div>
</div>
@endsection
