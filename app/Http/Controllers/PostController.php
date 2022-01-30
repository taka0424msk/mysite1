<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{

    public function index()
    {
        // $posts = Post::all(); //全ての値を抽出
        // $posts = Post::orderBy('created_at', 'desc')->get();
        $posts = Post::latest()->get();//上と同じ内容


        return view('index')
            ->with(['posts' => $posts]);
    }
    // Implicit Binding
    public function show(Post $post)
    {
        return view('posts.show')
            ->with(['post' => $post]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(PostRequest $request)//Request型で受け取るとポストされた内容が全て変数に代入される。PostRequestにするとPostRequest.phpの内容を受け取ってくれる
    {

        $post = new Post();
        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();

        return redirect()
            ->route('posts.index');
    }

    public function edit(Post $post)
    {
        return view('posts.edit')
            ->with(['post' => $post]);
    }

    public function update(PostRequest $request, Post $post)
    {

        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();

        return redirect()
            ->route('posts.show',$post);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()
            ->route('posts.index');
    }
}
