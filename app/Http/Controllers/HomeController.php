<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Post;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
    public function index()
{
    $courses = Course::latest()->take(3)->get(); // Fetch the latest 3 courses
     $posts = Post::latest()->take(3)->get();
    return view('home', compact('courses', 'posts'));
}

}
