@extends('layouts.app')

@section('content')
    <div class="container mt-3">
        <h1>Create Post</h1>
        {{-- [PagesController::class, 'services'] --}}
        {!! Form::open(['action' => 'App\Http\Controllers\PostsController@store', 'method' => 'POST']) !!}
            <div class="form-group">
                {{Form::label('title', 'Title:')}}
                {{Form::text('title', '', ['class'=>'form-control', 'placeholder' => 'Title'])}}
            </div>

            <div class="form-group">
                {{Form::label('body', 'Body:')}}
                {{Form::textarea('body', '', ['id'=> 'editor', 'class'=> 'form-control','class'=> 'ck-editor', 'placeholder' => 'Body Text'])}}
            </div>
                {{Form::submit('Submit', ['class' => 'btn btn-dark'])}}
        {!! Form::close() !!}   
    </div>
@endsection

{{-- ckeditor script --}}
@section('ck-editor')
    <script src="https://cdn.ckeditor.com/ckeditor5/29.1.0/classic/ckeditor.js"></script>
    
    <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>
@endsection 