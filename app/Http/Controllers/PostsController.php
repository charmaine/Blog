<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

class PostsController extends Controller
{

    public function __construct()
    {
      $this->middleware('auth')->except(['index','show']);
    }
    public function index()
    {

      $posts = \App\Post::latest()->filter(request(['month','year']))->get();


      $archives = \App\Post::archives();


      return view('posts.index', compact('posts','archives'));
    }

    public function show(\App\Post $post)
    {
      return view('posts.show', compact('post'));
    }

    public function create()
    {
      return view('posts.create');
    }

    public function store()
    {

    $this->validate(request(), [
      'title' => 'required',
      'body' => 'required'
    ]);

    \App\Post::create([
      'title' => request('title'),
      'body' => request('body'),
      'user_id' => auth()->id()
    ]);

    session()->flash('message','Your post has now been published');


    return redirect ('/');
    }
}
