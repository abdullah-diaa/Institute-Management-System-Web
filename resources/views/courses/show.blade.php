@extends('layouts.app')

@section('content')
<link href="{{ asset('css/courses/show.css') }}" rel="stylesheet">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-purple text-white text-center">
                    <h2>{{ $course->title }}</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            @if($course->image)
                                <img src="{{ asset('storage/' . $course->image) }}" class="img-fluid rounded" alt="{{ $course->title }}">
                            @endif
                        </div>
                        <div class="col-md-8">
                            <p class="lead">{{ $course->content ? $course->content : 'No content available' }}</p>
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
                                    <strong>Maximum Students:</strong>
                                    <span>{{ $course->max_students ?? 'Unlimited' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>Author:</strong>
                                    <span>
                                        @if ($course->author && $course->author->profile)
                                            <b>
                                                <a href="{{ route('profiles.show', $course->author->profile->id) }}" class="username-decoration font-weight-bold">
                                                    {{ $course->author->name ?? 'Unknown' }}
                                                </a>
                                            </b>
                                        @else
                                            {{ $course->author->name ?? 'Unknown' }}
                                        @endif
                                    </span>
                                </li>
                                


                           

                                
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-purple text-center">
                    @if(!auth()->check() || auth()->user()->role === 'student')
                       
                    
                    
                    
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
    </div>
</div>

@endsection
