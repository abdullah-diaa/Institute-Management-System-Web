<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Http\Requests\AnswerRequest;
use Carbon\Carbon;
use App\Models\Answer;
use Illuminate\Support\Facades\Storage;


class AnswerController extends Controller
{
  

    public function index($assignmentId)
    {
        // Retrieve the assignment using the assignment ID
        $assignment = Assignment::findOrFail($assignmentId);
        
        // Retrieve answers for the given assignment
        $answers = Answer::where('assignment_id', $assignment->id)->get();
        
        // Pass the assignment and answers to the view
        return view('answers.index', [
            'assignment' => $assignment,
            'answers' => $answers
        ]);
    }
    



       public function create($assignment)
{
  $existingAnswer = Answer::where('user_id', auth()->user()->id)->where('assignment_id', $assignment)->exists();

    // If an answer exists, redirect to the assignments index
    if ($existingAnswer) {
        return redirect()->route('assignments.index')->with('warning', 'You have already uploaded an answer for this assignment.');
    }else{
    return view('answers.create', ['assignment_id' => $assignment]);
}}









public function store(AnswerRequest $request)
{

$validatedData = $request->validated();

    // Create a new Answer model instance
    $answer = new Answer([
        'assignment_id' => $validatedData['assignment_id'],
        'user_id' => auth()->id(), // Assuming you have user authentication
        'uploaded_at' => now(),
    ]);

    // Check if a file is uploaded
    if ($request->hasFile('file_path')) {
        // Handle the file upload
        $file = $request->file('file_path');
        $fileName = time() . '_' . $file->getClientOriginalName(); // Create a unique file name
        $file->storeAs('public/answer_files', $fileName); // Store the file
        $answer->file_path = 'answer_files/' . $fileName; // Save the file path in the database
    }

    // Save the Answer model to the database
    $answer->save();

    // Redirect with a success message
    return redirect()->route('assignments.index')->with('success', 'Answer uploaded successfully');
}



    public function show($id)
    {
        $answer = Answer::findOrFail($id);
        return view('answers.show', ['answer' => $answer]);
    }

    public function update(AnswerRequest $request, $id)
    {
        $validatedData = $request->validated();

        $answer = Answer::findOrFail($id);
        $answer->update($validatedData);

        return redirect()->route('answers.index')->with('success', 'Answer updated successfully');
    }

    public function destroy($assignmentId, $answerId)
{
    // Find the answer by its ID and delete it
    $answer = Answer::where('id', $answerId)->where('assignment_id', $assignmentId)->first();

    if ($answer) {
        $answer->delete();

        return redirect()->route('answers.index', ['assignment' => $assignmentId])
                         ->with('success', 'Answer deleted successfully.');
    } else {
        return redirect()->route('answers.index', ['assignment' => $assignmentId])
                         ->with('error', 'Answer not found.');
    }
}

}
