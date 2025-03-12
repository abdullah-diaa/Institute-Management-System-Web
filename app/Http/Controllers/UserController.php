<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    // Display a list of users for the admin to manage
    public function index(Request $request)
    {
        if(auth()->check() && auth()->user()->role === 'admin'){
        $search = $request->input('search');
        $perPage = $search ? 100000 : 10; // Pagination size depends on search
    
        $users = User::when($search, function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
        })
        ->orderBy('created_at', 'desc') // Always order by created_at descending
        ->paginate($perPage);
    
        return view('users.index', compact('users', 'search'));
    }else{
      
        return redirect()->route('login');
      }
    }
    



    // public function index(Request $request)
    // {
    //     $search = $request->input('search');
    //     $perPage = $search ? 100000 : 10; // Pagination size depends on search
    
    //     $users = User::when($search, function ($query) use ($search) {
    //         $query->where('name', 'like', '%' . $search . '%')
    //               ->orWhere('email', 'like', '%' . $search . '%');
    //     })
    //     ->orderBy('created_at', 'desc')
    //     ->paginate($perPage);
    
    //     // If no search query, paginate with default value
    //     if (!$search) {
    //         $users = User::paginate($perPage);
    //     }
    
    //     return view('users.index', compact('users', 'search'));
    // }
    
    // Show the form for creating a new user
    public function create()
    {
        $courses = Course::all(); // Fetch all courses for enrollment
        return view('users.create', compact('courses'));
    }

    // Store a newly created user in the database
    public function store(StoreUserRequest $request)
    {
      
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'status' => $request->status,
        ]);

        // Attach selected courses to the user
        if ($request->has('courses')) {
            $user->courses()->sync($request->courses);
        }

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }
      


    // public function enroll(User $user)
    // {
    //     $courses = Course::all(); // Get all available courses
    //     return view('users.enroll', compact('user', 'courses'));
    // }
    


    // public function enrollStore(Request $request, User $user)
    // {
    //     // Validate the incoming request
    //     $request->validate([
    //         'course_ids' => 'required|array',
    //         'course_ids.*' => 'exists:courses,id', // Ensure each selected course exists
    //     ]);
    
    //     // Use attach() to add new courses without removing existing ones
    //     $user->courses()->attach($request->course_ids);
    
    //     return redirect()->route('users.index')->with('success', 'User enrolled in courses successfully.');
    // }
    



    // Show the form for editing a user
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $courses = Course::all(); // Get all courses for enrollment
        return view('users.edit', compact('user', 'courses'));
    }

    // Update user details and enroll them in courses
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        // Update the basic user details
        $user->update($request->only([ 'role', 'status', 'member']));

        // Sync the selected courses for the user (many-to-many relationship)
        if ($request->has('courses')) {
            $user->courses()->sync($request->courses);
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    // Delete a user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->courses()->detach(); // Remove associated courses
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }



        public function createEnrollment(User $user)
        {
            // Get all available courses
            $courses = Course::all();
            return view('users.create-enroll', compact('user', 'courses'));
        }
    


    public function storeEnrollment(Request $request, User $user)
    {
        $request->validate([
            'course_ids' => 'required|array',
            'course_ids.*' => 'exists:courses,id',
        ]);
    
        // Enroll the user in the selected courses
        $user->courses()->attach($request->course_ids);
    
        return redirect()->route('users.index')->with('success', 'Enrollment created successfully!');
    }
    

    public function editEnroll($userId)
    {
        $user = User::findOrFail($userId);
        $courses = Course::all();
        $userCourses = $user->courses->pluck('id')->toArray(); // Get the courses the user is enrolled in
    
        return view('users.edit-enroll', compact('user', 'courses', 'userCourses'));
    }
    



public function updateEnrollment(Request $request, User $user)
{
    $request->validate([
        'course_ids' => 'nullable|array',
        'course_ids.*' => 'exists:courses,id',
    ]);

    // Update the enrollment (replace old enrollments)
    $user->courses()->sync($request->course_ids);

    return redirect()->route('users.index')->with('success', 'Enrollment updated successfully!');
}



}
