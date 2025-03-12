@extends('layouts.app')

@section('content')

    <h1 class="mb-4">Subscriptions</h1>

@if(auth()->user()->role === 'student')
<h1>My Subscription Requests</h1>

@if($subscriptions->isEmpty())
<p>No subscription requests found.</p>
@else
@foreach($subscriptions as $subscription)
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Subscription Request Case Number: {{ $subscription->id + 2323 }}</h5>  
            
            @if($subscription->request_status === 'pending')
                <p><strong>User Name:</strong> {{ $subscription->user->name }}</p> <!-- Display User Name -->
                <p><strong>Course Name:</strong> {{ $subscription->course->title }}</p> <!-- Display Course Name -->
                <p><strong>Phone:</strong> {{ $subscription->phone }}</p>
                <p><strong>Location:</strong> {{ $subscription->location }}</p>
                <p><strong>Payment Method:</strong> {{ $subscription->payment_method }}</p>
                <p><strong>Details:</strong> {{ $subscription->details }}</p>
                <p><strong>Status:</strong> {{ $subscription->request_status }}</p>

                <a href="{{ route('subscriptions.edit', $subscription->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('subscriptions.destroy', $subscription->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this subscription?');">Delete</button>
                </form>

                @elseif($subscription->request_status === 'successful')
                <p><strong>Status:</strong> {{ $subscription->request_status }}</p>
                <p>Your request for <a href="{{ route('courses.show', $subscription->course->id) }}">{{ $subscription->course->title }}</a> was successful!</p>
                <p>You are now a member of this course. Enjoy your learning journey!</p>

                @elseif($subscription->request_status === 'failed')
                <p><strong>Status:</strong> {{ $subscription->request_status }}</p>
                <p>Your request for <a href="{{ route('courses.show', $subscription->course->id) }}">{{ $subscription->course->title }}</a> has been rejected!</p>
                <p><strong>Reason for Rejection:</strong> {{ $subscription->note ?? 'No reason provided.' }}</p>
            
                
            @endif
        </div>
    </div>
@endforeach
@endif

@endif

@endsection
