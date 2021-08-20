@extends('layouts.app')
@section('content')
<div class="container mt-3">
    <a href="/posts" class="btn btn-default btn-dark">Go Back</a>
    <h1 class="mt-3"> {{$post->title}} </h1>
    <div>
        {!!$post->body!!}
    </div>
    <hr>
    <small>Written on {{$post->created_at}}</small>
</div>
@endsection