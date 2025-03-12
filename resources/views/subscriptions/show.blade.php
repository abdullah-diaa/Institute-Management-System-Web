@extends('layouts.app')
<link href="{{ asset('css/subscriptions/show.css') }}" rel="stylesheet">

@section('content')
@if(auth()->check() && auth()->user()->role === 'admin' && auth()->user()->status == '1')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-gradient-primary text-white text-center rounded-top">
                    <h2 class="mb-0">Subscription Details</h2>
                </div>
                <div class="card-body">
                    <div class="subscription-info p-4">
                        <!-- Subscription ID -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p class="data-label"><strong>Subscription Case Number:</strong></p>
                            </div>
                            <div class="col-md-6">
                                <p>{{ $subscription->id }}</p>
                            </div>
                        </div>

                        <!-- User ID -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p class="data-label"><strong>User Name:</strong></p>
                            </div>
                            <div class="col-md-6">
                                <p><b>
                                    @if ($subscription->user->profile)
                                        <a href="{{ route('profiles.show', $subscription->user->profile->id) }}" class="username-decoration font-weight-bold">{{ $subscription->user->name }}</a>
                                 
                                        @else
                                        {{ $subscription->user->name }}
                                    @endif
                                </b></p>
                            </div>
                        </div>

                        <!-- Course ID -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p class="data-label"><strong>Course Name:</strong></p>
                            </div>
                            <div class="col-md-6">
                                <p><b><a href="{{ route('courses.show', $subscription->course->id) }}" class="username-decoration font-weight-bold">{{ $subscription->course->title }}</a></b>
                                </p>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p class="data-label"><strong>Phone_Number:</strong></p>
                            </div>
                            <div class="col-md-6">
                                <p>{{ $subscription->phone }}</p>
                            </div>
                        </div>



                         <!-- Phone -->
                         <div class="row mb-4">
                            <div class="col-md-6">
                                <p class="data-label"><strong>Location:</strong></p>
                            </div>
                            <div class="col-md-6">
                                <p>{{ $subscription->location }}</p>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p class="data-label"><strong>Payment Method:</strong></p>
                            </div>
                            <div class="col-md-6">
                                <p>{{ ucfirst($subscription->payment_method) }}</p>
                            </div>
                        </div>

                        <!-- Details -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p class="data-label"><strong>Details:</strong></p>
                            </div>
                            <div class="col-md-6">
                                <p>{{ $subscription->details ?? 'No details available' }}</p>
                            </div>
                        </div>





  <!-- Approved By -->
  @if ($subscription->request_status == 'successful')
  <div class="row mb-4">
    <div class="col-md-6">
        <p class="data-label">
        <strong>Approved By:</strong>

        </p>
    </div>
    <div class="col-md-6">
        @if ($subscription->approvedByUser)
        <b>
          <a href="{{ route('profiles.show', $subscription->approvedByUser->profile->id) }}" class="username-decoration font-weight-bold">  {{ $subscription->approvedByUser->name }}</a>
      </b>
      @else
          N/A
      @endif
    </div>
</div>

@elseif ($subscription->request_status === 'failed')
<div class="row mb-4">
    <div class="col-md-6">
        <p class="data-label">
        <strong>Rejected By:</strong>

        </p>
    </div>
    <div class="col-md-6">
        @if ($subscription->approvedByUser)
        <b>
          <a href="{{ route('profiles.show', $subscription->approvedByUser->profile->id) }}" class="username-decoration font-weight-bold">  {{ $subscription->approvedByUser->name }}</a>
      </b>
      @else
          N/A
      @endif
    </div>
</div>
@endif


                        <!-- For Failed Subscriptions: Display Note -->
                        @if($subscription->request_status == 'failed')
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p class="data-label"><strong>Reason Of Rejection   :</strong></p>
                            </div>
                            <div class="col-md-6">
                                <p>{{ $subscription->note ?? 'No additional notes' }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Created At -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p class="data-label"><strong>Created At:</strong></p>
                            </div>
                            <div class="col-md-6">
                                <p>{{ $subscription->created_at->format('d M Y, h:i A') }}</p>
                            </div>
                        </div>

                        <!-- Updated At -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p class="data-label"><strong>Last Updated At:</strong></p>
                            </div>
                            <div class="col-md-6">
                                <p>{{ $subscription->updated_at->format('d M Y, h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- Back Button -->
                    <div class="text-center mt-4">
                        <a href="{{ route('subscriptions.index') }}" class="btn-custom px-5 py-2">
                            Back to Subscriptions
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="container">
    <div class="card">
        <div class="card-header">{{ __('Page Not Found') }}</div>

        <div class="card-body">
           <div class="alert"><b>
                {{ __('The page you are looking for does not exist.') }}</b>
            </div>
        </div>
    </div>
</div>

<script>
    setTimeout(function() {
        window.location.href = "{{ route('home') }}";
    }, 3000); // Redirect after 3 seconds
</script>

@endif
@endsection
