<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function welcome()
    {
        return view('welcome', [
            'posts' => Post::latest()->paginate(9)
        ]);
    }

    public function index()
    {
        return view('posts.index', [
            'posts' => Post::filter(request(['search', 'category', 'author']))->get(),
            'categories' => \Stephenjude\FilamentBlog\Models\Category::all()
        ]);
    }

    public function show(Post $post)
    {
        return view('posts.show', [
            'post' => $post,
        ]);
    }
}
