@extends('layouts.app')

@section('content')
<link href="{{ asset('css/courses/index.css') }}" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<div class="container">
    <div class="row justify-content-center">
        <div class="row mb-3">
            @if(auth()->check() && auth()->user()->role === 'admin')
                <div class="col">
                    <a href="{{ route('courses.create') }}" class="custom-file-button   float-right mt-5"> <i class="fas fa-plus-circle"></i>  Create Course</a>
                </div>
                <div id="notification-container">
                    @if ($errors->any())
                        <div class="notification error">
                            <i class="fas fa-exclamation-circle"></i>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="notification success">
                            <i class="fas fa-check-circle"></i>
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            @endif
        </div>

        @if ($courses->isEmpty())
            <p>No courses found.</p>
        @else
            @foreach($courses as $course)
                <div class="col-md-4 mb-4"> <!-- Adjusted to create multiple columns -->
                    <div class="card shadow-lg rounded">
                        <div class="card-img-wrapper"> 
                            
                            @if($course->image)
                                <img src="{{ asset('storage/' . $course->image) }}" class="card-img-top" alt="{{ $course->title }}">
                            @endif 
                            @if(auth()->check() && ( auth()->user()->role === 'admin' ))
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-cog"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{ route('courses.edit', $course->id) }}"><i class="fas fa-edit"></i> Edit</a>
                                    <form action="{{ route('courses.destroy', $course->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this course?')"><i class="fas fa-trash"></i> Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endif
                        </div>
                        
                        <div class="card-body"> 
                            
                            <h5 class="card-title">{{ $course->title }}</h5>
                            <p class="card-text">
                                @php
                                    $truncatedContent = Str::limit($course->content, 100, '...'); // Adjust the limit as needed
                                @endphp
                                {{ $truncatedContent }}

                                @if (strlen($course->content) > 100) <!-- Only show "Read More" if the content is longer -->
                                    <a href="{{ route('courses.show', $course->id) }}" class="read-more-link">Read More</a>
                                @endif
                            </p>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>Price:</strong>
                                    <span>
                                        @if(isset($course->previous_price) && isset($course->price) && $course->previous_price > $course->price)
                                            <del class="text-muted">IQ {{ rtrim(rtrim(number_format($course->previous_price, 10, '.', ''), '0'), '.') }}</del> 
                                            &nbsp; 
                                            <strong class="text-danger">IQ {{ rtrim(rtrim(number_format($course->price, 10, '.', ''), '0'), '.') }}</strong>
                                        @else
                                            <strong>IQ {{ isset($course->previous_price) ? rtrim(rtrim(number_format($course->previous_price, 10, '.', ''), '0'), '.') : 'N/A' }}</strong>
                                        @endif
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>Status:</strong>
                                    <span>{{ isset($course->status) ? ($course->status ? 'Active' : 'Inactive') : 'N/A' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>Course Format:</strong>
                                    <span>{{ $course->delivery_mode ? ucfirst($course->delivery_mode) : 'N/A' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>Start Date:</strong>
                                    <span>{{ $course->start_date ? $course->start_date->format('Y-m-d') : 'N/A' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>End Date:</strong>
                                    <span>{{ $course->end_date ? $course->end_date->format('Y-m-d') : 'N/A' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>Author:</strong>
                                    <span>@if ($course->author->profile)
                                        <b><a href="{{ route('profiles.show',$course->author->profile->id) }}" class="username-decoration font-weight-bold">{{ $course->author->name ?? 'Unknown'}}</a>
                                        </b>
                                        @else
                                        {{ $course->author->name }}
                                    @endif </span>
                                </li>
                            </ul>
                        </div>



                        <div class="card-footer d-flex justify-content-between bg-purple">

                            @if(auth()->check() && auth()->user()->role === 'admin')



                            <a href="{{ route('courses.show', $course->id) }}" class="btn btn-primary">Details</a>
                            @php
                            // Check the subscription status for the current course
                            $subscription = $subscriptions->get($course->id);
                        @endphp

                       @else
                            <a href="{{ route('courses.show', $course->id) }}" class="btn btn-primary">Details</a>
                            @php
                            // Check the subscription status for the current course
                            $subscription = $subscriptions->get($course->id);
                        @endphp

     
                                    @if ($subscription)
                        @if ($subscription->request_status === 'pending')
                            <span class="badge badge-warning">
                                <i class="fas fa-hourglass-half" style="color: #fff;"></i> Pending Request
                            </span>
                        @elseif ($subscription->request_status === 'successful')
                            <span class="badge badge-success">
                                <i class="fas fa-check-circle" style="color: rgb(41, 206, 41);"></i> Successfully Subscribed
                            </span>
                        @elseif ($subscription->request_status === 'failed')
                   <span class="badge badge-danger">
                            <i class="fas fa-times-circle" style="color: rgb(226, 35, 35);"></i> Subscription Failed
                        </span>
                        @endif
                    @else
                        <a href="{{ route('subscriptions.create', $course->id) }}" class="btn btn-success">
                            <i class="fas fa-paper-plane"></i> Subscribe
                        </a>
                    @endif
       
                @endif
                        </div>
                    </div>
                </div>
               
            @endforeach
        @endif
    </div>
</div>

@endsection
