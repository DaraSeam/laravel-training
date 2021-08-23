<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('posts.index')->with('posts', $posts);

        // or take how many you want by declare take()
        // $posts = Post::orderBy('title', 'asc')take(1)->get();

        // find all data from database
        // Post::all()

        // find data with title of post two only
        // $posts = Post::where('title', 'Post Two')->get();

        // or use DB: declare use DB at the top
        // $posts = DB::select('SELECT * FROM posts');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $this->validate($request, [
             'title' => 'required',
             'body' => 'required'
         ]);
         
        //  create post
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->save();

        // return created post to posts route with message success
        return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        // update post
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->save();

        // return created post to posts route with message success
        return redirect('/posts')->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        return redirect('/posts')->with('success', 'Post Removed');
    }
}
