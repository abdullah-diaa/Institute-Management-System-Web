<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment; // Assuming you have an Assignment model
use App\Models\Post; // Assuming you have an Assignment model
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;
use Illuminate\Support\Str;

class PostController extends Controller
{
    


    public function index()
    {
        // Fetch all posts, ordered by 'created_at' in descending order (newest first)
        $posts = Post::orderBy('created_at', 'desc')->get();
    
        // Return the view 'posts.index', passing the posts data to the view
        return view('posts.index', compact('posts'));
    }
    

  
// In PostController.php

public function incrementView($id)
{
    $post = Post::findOrFail($id);
    $post->incrementViews();

    return response()->json(['success' => true]);
}








    public function create()
    {
      
        return view('posts.create');
    }

    // Store a newly created post in the database
    public function store(PostRequest $request)
{
    $post = new Post();
    $post->title = $request->input('title');
    $post->content = $request->input('content');
  $post->user_id = auth()->user()->id;

    // Handle image upload
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/posts_images', $imageName); // Store image in storage
        $post->image = 'posts_images/' . $imageName; // Save image path to database
    }

    $post->save();

    return redirect()->route('posts.index')->with('success', 'Post created successfully.');
}



  public function show($id)
    {

        $post = Post::with('user')->findOrFail($id);
        $post->incrementViews();
        return view('posts.show', compact('post'));
    }
    // Show the form for editing the specified post
    public function edit($id)
    { 

        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }
    // Update the specified post in the database
    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        
        // Check if a new image is uploaded
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($post->image) {
                Storage::delete('public/' . $post->image); // Ensure correct deletion from storage
            }
    
            // Handle the new image upload
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/posts_images', $imageName); // Store new image in storage
            $post->image = 'posts_images/' . $imageName; // Save new image path to database
        }
    
        $post->save();
    
        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }
    

    // Remove the specified post from the database
    public function destroy($id)
    {
      if(auth()->check() && auth()->user()->role === 'admin'){
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }}
}
