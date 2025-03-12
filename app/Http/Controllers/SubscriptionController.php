<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Http\Requests\UpdateSubscriptionRequest;

class SubscriptionController extends Controller
{
    // Display a listing of all subscriptions
    public function index(Request $request)
    {
        if (auth()->check() && auth()->user()->role === 'admin') {
            $search = $request->input('search');
            $perPage = 10; // Adjust pagination as needed
    
            // Pending Subscriptions
            $pendingSubscriptions = Subscription::where('request_status', 'pending') // Always filter pending subscriptions
            ->when($search, function ($query) use ($search) {
                $query->where(function($query) use ($search) {
                    // Search by user name instead of user ID
                    $query->whereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    })
                    // Search by course title instead of course ID
                    ->orWhereHas('course', function ($q) use ($search) {
                        $q->where('title', 'like', '%' . $search . '%');
                    })
                    // Other search conditions
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('payment_method', 'like', '%' . $search . '%')
                    ->orWhere('location', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('created_at', 'desc') // Order by created_at descending
            ->paginate($perPage);
    
            return view('subscriptions.index', compact('pendingSubscriptions', 'search'));
        }
    
    
    
     elseif (auth()->check() && auth()->user()->role === 'student') {
            // Student sees only their subscriptions
            $subscriptions = Subscription::with(['user', 'course']) // Eager load user and course
                ->where('user_id', auth()->id())
                ->get();
    
            return view('subscriptions.index', compact('subscriptions'));
        }
        return redirect()->route('login');

          }
    



          public function successfulSubscriptions(Request $request)
{
    if (auth()->check() && auth()->user()->role === 'admin') {
        $search = $request->input('search');
        $perPage = 10; // Adjust pagination as needed

        // Successful Subscriptions
        $successfulSubscriptions = Subscription::where('request_status', 'successful') // Always filter successful subscriptions
            ->when($search, function ($query) use ($search) {
                $query->where(function($query) use ($search) {
                    // Search by user name instead of user ID
                    $query->whereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    })
                    // Search by course title instead of course ID
                    ->orWhereHas('course', function ($q) use ($search) {
                        $q->where('title', 'like', '%' . $search . '%');
                    })
                    // Other search conditions
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('payment_method', 'like', '%' . $search . '%')
                    ->orWhere('location', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('created_at', 'desc') // Order by created_at descending
            ->paginate($perPage);

        return view('subscriptions.successful', compact('successfulSubscriptions', 'search'));
    }

    return redirect()->route('login');
}



          public function failedSubscriptions(Request $request)
          {
              if (auth()->check() && auth()->user()->role === 'admin') {
                  $search = $request->input('search');
                  $perPage = 10; // Adjust pagination as needed
          
                  // Failed Subscriptions
                  $failedSubscriptions = Subscription::where('request_status', 'failed') // Always filter failed subscriptions
                  ->when($search, function ($query) use ($search) {
                    $query->where(function($query) use ($search) {
                        // Search by user name instead of user ID
                        $query->whereHas('user', function ($q) use ($search) {
                            $q->where('name', 'like', '%' . $search . '%');
                        })
                        // Search by course title instead of course ID
                        ->orWhereHas('course', function ($q) use ($search) {
                            $q->where('title', 'like', '%' . $search . '%');
                        })
                        // Other search conditions
                        ->orWhere('phone', 'like', '%' . $search . '%')
                        ->orWhere('payment_method', 'like', '%' . $search . '%')
                        ->orWhere('location', 'like', '%' . $search . '%');
                    });
                })
                  ->orderBy('created_at', 'desc') // Order by created_at descending
                  ->paginate($perPage);
          
                  return view('subscriptions.failed', compact('failedSubscriptions', 'search'));
              }
          
              return redirect()->route('login');
          }
          

        





    // Display the subscription creation form for a specific course
    public function create(Course $course)
    {
        return view('subscriptions.create', compact('course'));
    }

    // Store the subscription request in the database
    public function store(StoreSubscriptionRequest $request, Course $course)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
              'details' => 'nullable|string|max:500', // Phone is required
            'payment_method' => 'required|in:office,representative,zain_cash,master_card',
            'location' => 'required|string|max:255', // Add this line
        ]);

        $validated['course_id'] = $course->id;
        $validated['user_id'] = auth()->id();
        $validated['request_status'] = 'pending'; // Default status is pending

        Subscription::create($validated);

        return redirect()->route('courses.index')->with('success', 'Subscription submitted successfully!');
    }

    // Display the specified subscription
    public function show($id)
    {
        // Retrieve the subscription by ID
        $subscription = Subscription::findOrFail($id);
    
        // Pass the subscription data to the view
        return view('subscriptions.show', compact('subscription'));
    }
    
    // Display the edit form for the subscription
    public function edit(Subscription $subscription)
    {
        session(['previous_url' => url()->previous()]);
        return view('subscriptions.edit', compact('subscription'));
    }

    // Update the specified subscription in the database
 // Update the specified subscription in the database
 public function update(UpdateSubscriptionRequest $request, Subscription $subscription)
{
    // Validate the incoming request
    $validated = $request->validated();

    // If the status is 'successful', fill the approved_by field and enroll the user
    if ($validated['request_status'] === 'successful') {
        $validated['approved_by'] = auth()->user()->id; // Get the admin's ID
        // Automatically enroll the user in the course, prevent duplicate enrollments
        $user = $subscription->user; // Get the user who subscribed
        $course = $subscription->course; // Get the course they subscribed to
        
        // Use sync() to ensure that the user is only enrolled once in the course
        $user->courses()->syncWithoutDetaching([$course->id]); // Prevent duplicates
    } else {
        // If the subscription is not 'successful', clear approved_by and unenroll the user
        unset($validated['approved_by']);
        
        // If the subscription status is 'pending' or 'failed', remove the user from the course
        if (in_array($validated['request_status'], ['pending', 'failed'])) {
            $user = $subscription->user; // Get the user who subscribed
            $course = $subscription->course; // Get the course they subscribed to
            $user->courses()->detach($course); // Unenroll the user from the course
        }
    }

    // Update the subscription with the new status
    $subscription->update($validated);

    // Redirect back to the last visited route stored in session
    $previousUrl = session('previous_url', route('subscriptions.index'));
    session()->forget('previous_url'); // Clear the session variable
    return redirect()->to($previousUrl)->with('success', 'Subscription updated successfully!');
}

 

    // Remove the specified subscription from the database
    public function destroy(Subscription $subscription)
    {
        $subscription->delete();

        return redirect()->back()->with('success', 'Subscription deleted successfully!');
    }
}
