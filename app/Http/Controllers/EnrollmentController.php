<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\User;
use App\Models\Course;
use App\Http\Requests\EnrollmentRequest;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the enrollments.
     *
     * @return \Illuminate\Http\Response
     */
    

public function index(Request $request)
{
    if (auth()->check() && auth()->user()->role === 'admin') {
        $search = $request->input('search');
        $perPage = $search ? 100000 : 10;

        $enrollments = Enrollment::when($search, function ($query) use ($search) {
            $query->whereHas('user', function ($subQuery) use ($search) {
                $subQuery->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })
            ->orWhereHas('course', function ($subQuery) use ($search) {
                $subQuery->where('title', 'like', '%' . $search . '%');
            });
        })->with(['user:id,name,email', 'course:id,title'])->paginate($perPage);

        // If no search query, show all enrollments paginated by default (10 per page)
        if ($search == 'all' || !$search) {
            $enrollments = Enrollment::with(['user:id,name,email', 'course:id,title'])->paginate($perPage);
        }

        return view('enrollments.index', compact('enrollments', 'search'));
    } else {
        return redirect()->route('login');
    }
}


    /**
     * Show the form for creating a new enrollment.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
{
    // Retrieve users who are not already enrolled in any course
    $users = User::whereDoesntHave('enrollments')->where('role', 'student')->get();
    $courses = Course::all();
    return view('enrollments.create', compact('users', 'courses'));
}

    /**
     * Store a newly created enrollment in storage.
     *
     * @param  \App\Http\Requests\EnrollmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EnrollmentRequest $request)
    {
        Enrollment::create($request->validated());
        return redirect()->route('enrollments.index')->with('success', 'Enrollment created successfully');
    }

    /**
     * Display the specified enrollment.
     *
     * @param  \App\Models\Enrollment  $enrollment
     * @return \Illuminate\Http\Response
     */
    public function show(Enrollment $enrollment)
    {
        return view('enrollments.show', compact('enrollment'));
    }

    /**
     * Show the form for editing the specified enrollment.
     *
     * @param  \App\Models\Enrollment  $enrollment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
{
    // Find the enrollment by its ID
    $enrollment = Enrollment::findOrFail($id);
    
    // Retrieve all users and courses
    $users = User::where('role', 'student')->get();
    $courses = Course::all();
    
    // Pass the enrollment, users, and courses to the view
    return view('enrollments.edit', compact('enrollment', 'users', 'courses'));
}

    /**
     * Update the specified enrollment in storage.
     *
     * @param  \App\Http\Requests\EnrollmentRequest  $request
     * @param  \App\Models\Enrollment  $enrollment
     * @return \Illuminate\Http\Response
     */
    public function update(EnrollmentRequest $request, Enrollment $enrollment)
    {
        $enrollment->update($request->validated());
        return redirect()->route('enrollments.index')->with('success', 'Enrollment updated successfully');
    }

    /**
     * Remove the specified enrollment from storage.
     *
     * @param  \App\Models\Enrollment  $enrollment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();
        return redirect()->route('enrollments.index')->with('success', 'Enrollment deleted successfully');
    }
}
