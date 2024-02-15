<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Video;
// use App\Models\Author;

class PostController extends Controller
{
    
    public function welcome()
    {
        // return view('welcome', [
        //     'posts' => Post::latest()->paginate(9)
        // ]);

        $posts = Post::latest()->paginate(9);
        $videos = Video::all();
        
        return view('welcome', [
            'posts' => $posts,
            'videos' => $videos
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
        $sameAuthorPosts = collect();
        $count = 4;

        $sameAuthorPosts = $sameAuthorPosts->concat(
            $post
                ->where('blog_author_id', $post->author->id)
                ->whereNot('id', $post->id)
                ->latest()
                ->limit($count)
                ->get()
        );

        // Assuming you have an Author instance or ID
        // $author = Post::find($post); // Replace $authorId with the actual author ID

        // // Get the post count
        // $postCount = $author->posts()->count();

        // $author = Post::find($post);

        // if (!$author) {
        //     abort(404); // or handle the case where the author is not found
        // }

        //  $postCount = $author->posts()->count();

        return view('posts.show', [
            'post' => $post,
            'sameAuthorPosts' => $sameAuthorPosts,
            'related_posts' => Post::getRelatedPosts($post, shuffle: true),
            
        ]);
    }

    

    
}
