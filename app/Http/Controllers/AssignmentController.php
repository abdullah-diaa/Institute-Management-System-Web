<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Course;
use App\Http\Requests\AssignmentRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class AssignmentController extends Controller
{
    


     public function index(Request $request)
     {
         $user = auth()->user();
         
         // Start the assignments query
         $assignmentsQuery = Assignment::query();
         
         // Get the selected course id
         $courseId = $request->input('course_id');
     
         // Fetch only the courses the student is enrolled in
         if ($user->role !== 'admin') {
             // For students, fetch only their enrolled courses
             $courses = Course::whereHas('students', function ($query) use ($user) {
                 $query->where('user_id', $user->id);
             })->get();
             
             // Filter assignments based on course selection if course_id is provided
             if ($courseId) {
                 $assignmentsQuery->where('course_id', $courseId);
             }
     
             // Only show assignments for the courses the student is enrolled in
             $assignments = $assignmentsQuery->whereHas('course.students', function ($query) use ($user) {
                 $query->where('user_id', $user->id);
             })->orderBy('created_at', 'desc')->get();
         } else {
             // For admins, fetch all courses and assignments
             $courses = Course::all();
     
             if ($courseId) {
                 $assignmentsQuery->where('course_id', $courseId);
             }
     
             $assignments = $assignmentsQuery->orderBy('created_at', 'desc')->get();
         }
     
         return view('assignments.index', compact('assignments', 'courses'));
     }
     


public function create()
    {
        $courses = Course::all();
        return view('assignments.create', compact('courses'));
    }



    public function store(AssignmentRequest $request)
    {
        // Create a new assignment with the user ID automatically filled
        $assignment = new Assignment($request->validated());
        $assignment->user_id = Auth::id();
        
        // Check if a file is uploaded
        if ($request->hasFile('file')) {
            // Handle the file upload
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/assignments_files', $fileName); // Store new file in storage
            $assignment->file = 'assignments_files/' . $fileName; // Save file path to the database
        }
    
        $assignment->save();
    
        return redirect()->route('assignments.index')->with('success', 'Assignment created successfully.');
    }
    

    public function show(Assignment $assignment)
    {
        // Check if the assignment belongs to the authenticated user
        if ($assignment->user_id != Auth::id()) {
            return redirect()->route('assignments.index')->with('error', 'Unauthorized access.');
        }

        return view('assignments.show', compact('assignment'));
    }

  
    public function edit($id)
{
    $assignment = Assignment::findOrFail($id);
    $courses = Course::all(); // Fetch the list of courses

    return view('assignments.edit', compact('assignment', 'courses'));
}

    public function update(AssignmentRequest $request, Assignment $assignment)
    {
        // Update the assignment with validated data
        $assignment->fill($request->validated());
        
        // Check if a new file is uploaded
        if ($request->hasFile('file')) {
            // Delete the old file if it exists
            if ($assignment->file) {
                Storage::delete('public/' . $assignment->file); // Ensure correct deletion from storage
            }
    
            // Handle the new file upload
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/assignments_files', $fileName); // Store new file in storage
            $assignment->file = 'assignments_files/' . $fileName; // Save new file path to the database
        }
        
        // Save the updated assignment
        $assignment->save();
    
        return redirect()->route('assignments.index')->with('success', 'Assignment updated successfully.');
    }
    
    public function destroy(Assignment $assignment)
    {
        // Check if the assignment belongs to the authenticated user
        if ($assignment->user_id != Auth::id()) {
            return redirect()->route('assignments.index')->with('error', 'Unauthorized access.');
        }

        $assignment->delete();

        return redirect()->route('assignments.index')->with('success', 'Assignment deleted successfully.');
    }
}
