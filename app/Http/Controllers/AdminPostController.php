<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminPostController extends Controller
{
    public function index()
    {
        return view('admin.posts.index', [
            'posts' => Post::latest()->paginate(20)
        ]);
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store()
    {
        $attributes = $this->validatePost();

        $attributes = array_merge($attributes, [
            'user_id' => auth()->id(),
            'thumbnail' => request()->file('thumbnail')->store('thumbnails')
        ]);

        Post::create($attributes);

        return redirect("/posts/{$attributes['slug']}");
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', [
            'post' => $post
        ]);
    }

    public function update(Post $post)
    {
        $attributes = $this->validatePost($post);

        if ($attributes['thumbnail'] ?? false) {
            $attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');
        }

        $post->update($attributes);

        return redirect('/admin/posts')->with('success', 'Your Post Has Been Updated!');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect('/admin/posts')->with('success', 'Your Post Has Been Deleted!');
    }

    /**
     * @return array
     */
    protected function validatePost(?Post $post = null): array
    {
        $post ??= new Post(); // if null assign it to new Post();

        return request()->validate([
            'title' => 'required|string|min:7|max:255',
            'slug' => ['required', 'min:3', 'max:255', Rule::unique('posts', 'slug')->ignore($post)],
            'thumbnail' => $post->exists() ? 'image' : 'required|image',
            'excerpt' => 'required|string|min:21|max:255',
            'body' => 'required|min:21|string',
            'category_id' => 'required|exists:categories,id'
        ]);
    }
}
