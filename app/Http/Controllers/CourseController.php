<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use App\Models\Subscription;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use Illuminate\Http\Request;

class CourseController extends Controller
{
   
    
   public function index()
{
    $courses = Course::all(); // Fetch all courses
    $userId = auth()->id(); // Get the authenticated user ID

    // Fetch subscriptions for the user
    $subscriptions = Subscription::where('user_id', $userId)
        ->get()
        ->keyBy('course_id'); // Use course_id as the key for easy lookup

    return view('courses.index', compact('courses', 'subscriptions')); // Pass both courses and subscriptions to the view
}



    public function create()
    {
      $admins = User::where('role', 'admin')->get();
    
        return view('courses.create', compact('admins'));

    }

  
    
    public function store(StoreCourseRequest $request)
    {
        $data = $request->validated();
        
        // Add the authenticated user's ID to the data

    
        // Handle image upload like in the Playlist store method
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // Get the original extension
            $image->storeAs('public/course_images', $imageName); // Store image in storage
            $data['image'] = 'course_images/' . $imageName; // Save image path to database
        }
    
        Course::create($data);
    
        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }
    



  

    public function show(Course $course)
    {
        $userId = auth()->id(); // Get the authenticated user ID
    
        // Fetch the subscription for the specific course and user
        $subscription = Subscription::where('course_id', $course->id)
                                    ->where('user_id', $userId)
                                    ->first(); // Get the first matching record or null if none exists
    
        return view('courses.show', compact('course', 'subscription')); // Pass both course and subscription to the view
    }
    

   
    
public function edit(Course $course)
{
    $admins = User::where('role', 'admin')->get();
    return view('courses.edit', compact('course', 'admins'));
}




public function update(UpdateCourseRequest $request, Course $course)
{
    $data = $request->validated();

    // Upload course image if a new image is provided
    if ($request->hasFile('image')) {
        // Delete the old image if it exists
      
        // Handle the new image upload
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension(); // Get the original extension
        $image->storeAs('public/course_images', $imageName); // Store image in storage
        $data['image'] = 'course_images/' . $imageName; // Save image path to database
    }

    $course->update($data);

    return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
}



    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }
}
