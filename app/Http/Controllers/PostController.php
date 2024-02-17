<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Video;

use Illuminate\Support\Facades\Storage;
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
        $heroes = Hero::all();

        return view('welcome', [
            'posts' => $posts,
            'videos' => $videos,
            'heroes' => $heroes,
        ]);
    }

    public function index()
    {
        return view('posts.index', [
            'posts' => Post::filter(request(['search', 'category', 'author']))->get(),
            'categories' => \Stephenjude\FilamentBlog\Models\Category::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'hero_pdf' => 'required|mimes:pdf|max:2048', // Misalnya, batasi file hanya menerima PDF maksimal 2MB
        ]);

        $file = $request->file('hero_pdf');

        // Simpan file di dalam penyimpanan yang diinginkan, misalnya di dalam direktori 'public/uploads'
        $path = $file->store('uploads', 'public');

        // Sekarang Anda bisa menyimpan $path ke dalam database atau melakukan apa pun yang diperlukan dengan informasi file tersebut

        return back()->with('success', 'File has been uploaded successfully.');


        $request->validate([
            'banner_hero' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi file gambar
        ]);

        $file = $request->file('banner_hero');

        // Simpan file di dalam penyimpanan default Filament
        $path = Storage::putFile('public', $file);

        return back()->with('success', 'File has been uploaded successfully.');
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
                ->get(),
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
