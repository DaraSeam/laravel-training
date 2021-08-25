<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

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
             'body' => 'required',
             'cover_image' => 'image|nullable|max:1999',
         ]);
         
        // Handle File upload
        if($request->hasFile('cover_image')){
            // get file name with the extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();

            // get just file name
            $filename = pathinfo($fileNameWithExt,PATHINFO_FILENAME);

            // get just extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            
            // file name to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;

            // upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
            
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        //  create post
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
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

        // check for correct user
        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }

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

        //  Check for correct user
        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }

        return redirect('/posts')->with('success', 'Post Removed');
    }
}
