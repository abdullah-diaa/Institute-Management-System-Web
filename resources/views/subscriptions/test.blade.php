@extends('layouts.app')

@section('content')
<div class="container">
  

    @if(auth()->user()->role === 'admin')
    <h1>Subscriptions</h1>


        
        <ul class="nav nav-tabs" id="subscriptionTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pending-tab" data-toggle="tab" href="#pending" role="tab" aria-controls="pending" aria-selected="true">Pending</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="successful-tab" data-toggle="tab" href="#successful" role="tab" aria-controls="successful" aria-selected="false">Successful</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="failed-tab" data-toggle="tab" href="#failed" role="tab" aria-controls="failed" aria-selected="false">Failed</a>
            </li>
        </ul>

        <div class="tab-content" id="subscriptionTabsContent">
            <!-- Pending Subscriptions Tab -->
            <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                @if($pendingSubscriptions->isEmpty())
                <p>No pending subscriptions.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User ID</th>
                            <th>Course</th> <!-- Changed Course ID to Course -->
                            <th>Phone Number</th>
                            <th>Payment Method</th>
                            <th>Location</th>
                            <th>Created At</th>
                            <th>Actions</th> <!-- Actions Column -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingSubscriptions as $subscription)
                            <tr>
                                <td>{{ $subscription->id }}</td>
                                <td>{{ $subscription->user_id }}</td>
                                <td><a href="{{ route('courses.show', $subscription->course->id) }}">{{ $subscription->course->title }}</a></td>
                                <td>{{ $subscription->phone }}</td>
                                <td>{{ $subscription->payment_method }}</td>
                                <td>{{ $subscription->location }}</td>
                                <td>{{ $subscription->created_at }}</td>
                                <td>
                                    <a href="{{ route('subscriptions.show', $subscription->id) }}" class="btn btn-info btn-sm">Show</a>
                                    <a href="{{ route('subscriptions.edit', $subscription->id) }}" class="btn btn-warning btn-sm">Manage</a>
                                    <form action="{{ route('subscriptions.destroy', $subscription->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this subscription?');">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            
            </div>

            <!-- Successful Subscriptions Tab -->
            <div class="tab-pane fade" id="successful" role="tabpanel" aria-labelledby="successful-tab">
                @if($successfulSubscriptions->isEmpty())
                    <p>No successful subscriptions.</p>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User ID</th>
                                <th>Course</th>
                                <th>Phone Number</th>
                                <th>Payment Method</th>
                                <th>Location</th>
                                <th>Created At</th>
                                <th>Actions</th> <!-- Actions Column -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($successfulSubscriptions as $subscription)
                                <tr>
                                    <td>{{ $subscription->id }}</td>
                                    <td>{{ $subscription->user_id }}</td>
                                    <td><a href="{{ route('courses.show', $subscription->course->id) }}">{{ $subscription->course->title }}</a></td>
                                    <td>{{ $subscription->phone }}</td>
                                    <td>{{ $subscription->payment_method }}</td>
                                    <td>{{ $subscription->location }}</td>
                                    <td>{{ $subscription->created_at }}</td>
                                    <td>
                                        <a href="{{ route('subscriptions.show', $subscription->id) }}" class="btn btn-info btn-sm">Show</a>
                                        <a href="{{ route('subscriptions.edit', $subscription->id) }}" class="btn btn-warning btn-sm">Manage</a>
                                        <form action="{{ route('subscriptions.destroy', $subscription->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this subscription?');">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <!-- Failed Subscriptions Tab -->
            <div class="tab-pane fade" id="failed" role="tabpanel" aria-labelledby="failed-tab">
                @if($failedSubscriptions->isEmpty())
                    <p>No failed subscriptions.</p>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User ID</th>
                                <th>Course</th>
                                <th>Phone Number</th>
                                <th>Payment Method</th>
                                <th>Location</th>
                                <th>Note</th> <!-- Note column -->
                                <th>Created At</th>
                                <th>Actions</th> <!-- Actions Column -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($failedSubscriptions as $subscription)
                                <tr>
                                    <td>{{ $subscription->id }}</td>
                                    <td>{{ $subscription->user_id }}</td>
                                    <td><a href="{{ route('courses.show', $subscription->course->id) }}">{{ $subscription->course->title }}</a></td>
                                    <td>{{ $subscription->phone }}</td>
                                    <td>{{ $subscription->payment_method }}</td>
                                    <td>{{ $subscription->location }}</td>
                                    <td>{{ $subscription->note ?? 'N/A' }}</td> <!-- Display Note or N/A if null -->
                                    <td>{{ $subscription->created_at }}</td>
                                    <td>
                                        <a href="{{ route('subscriptions.show', $subscription->id) }}" class="btn btn-info btn-sm">Show</a>
                                        <a href="{{ route('subscriptions.edit', $subscription->id) }}" class="btn btn-warning btn-sm">Manage</a>
                                        <form action="{{ route('subscriptions.destroy', $subscription->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this subscription?');">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        @elseif(auth()->user()->role === 'student')
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
    
    
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@endsection
