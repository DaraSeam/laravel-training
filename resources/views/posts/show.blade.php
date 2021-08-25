@extends('layouts.app')
@section('content')
<div class="container mt-3">
    <a href="/posts" class="btn btn-default btn-dark">Go Back</a>
    <br>
    <h1 class="mt-3"> {{$post->title}} </h1>
    {{-- images --}}
    <img style="width: 100%" src="/storage/cover_images/{{$post->cover_image}}">
    <div>
        {!!$post->body!!}
    </div>
    <hr>
    <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
    <hr>

    {{-- if user is not a guest they can see these codes below --}}
    @if(!Auth::guest())

        @if(Auth::user()->id == $post->user_id)
            {{-- edit btn --}}
            <a href="/posts/{{$post->id}}/edit" class="btn btn-secondary">Edit</a>

            {{-- delete btn --}}
            {!!Form::open(['action' => ['App\Http\Controllers\PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'float-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
        @endif
    @endif
</div>
@endsection