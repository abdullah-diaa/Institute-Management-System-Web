@extends('layouts.app')

@section('content')
<link href="{{ asset('css/subscriptions/index.css') }}" rel="stylesheet">
@if(auth()->check() && auth()->user()->role === 'admin' && auth()->user()->status == '1')
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

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-lg">
                <div class="card-header text-white py-3">
                    <h5 class="card-title mb-0">Subscriptions</h5>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <form class="form-inline mr-3">
                            <div class="input-group">
                                <input type="text" class="form-control search-iput" name="search" placeholder="Search...">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary search-button">
                                        <i class="fa fa-search search-icon"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
   
   

    <ul class="nav nav-tabs mb-4" id="subscriptionTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link" id="pending-tab" href="{{ route('subscriptions.index') }}" role="tab" aria-controls="pending" aria-selected="false">Pending</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="successful-tab" href="{{ route('subscriptions.successful') }}" role="tab" aria-controls="successful" aria-selected="false">Successful</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" id="failed-tab" href="{{ route('subscriptions.failed') }}" role="tab" aria-controls="failed" aria-selected="true">Failed</a>
        </li>
    </ul>



    <!-- Content for Successful Subscriptions -->
    @if($failedSubscriptions->isEmpty())
        <div class="alert alert-info">No failed subscriptions.</div>
    @else




    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Phone Number</th>
                        <th>Payment Method</th>
                        <th>Location</th>
                        <th>Created At</th>
                        <th>Rejected By</th>
                        <th> Note</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($failedSubscriptions as $subscription)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $subscription->id }}</td>
                       
                        <td> <b>
                            @if ($subscription->user->profile)
                                <a href="{{ route('profiles.show', $subscription->user->profile->id) }}" class="username-decoration font-weight-bold">{{ $subscription->user->name }}</a>
                         
                                @else
                                {{ $subscription->user->name }}
                            @endif
                        </b>
                        </td>
                        


                        <td><b><a href="{{ route('courses.show', $subscription->course->id) }}" class="username-decoration font-weight-bold">{{ $subscription->course->title }}</a></b></td>
                        <td>{{ $subscription->phone }}</td>
                        <td>{{ $subscription->payment_method }}</td>
                        <td>{{ $subscription->location }}</td>
                        <td>{{ $subscription->created_at  ? $subscription->created_at->format('Y-m-d / h:i A') : 'N/A'}}</td>
                        <td>
                            @if ($subscription->approvedByUser)
                              <b>
                                <a href="{{ route('profiles.show', $subscription->approvedByUser->profile->id) }}" class="username-decoration font-weight-bold">  {{ $subscription->approvedByUser->name }}</a>
                            </b>
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $subscription->note ?? 'N/A' }}</td> <!-- Display Note or N/A if null -->
                        <td>
                            <div class="btn-group" role="group" aria-label="Profile Actions">
                                <a href="{{ route('subscriptions.edit', $subscription->id) }}" class="btn btn-secondary btn-action mr-1">manage</a>
                                <a href="{{ route('subscriptions.show', $subscription->id) }}" class="btn btn-info btn-action mr-1">Details</a>
                                <form action="{{ route('subscriptions.destroy', $subscription->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-action" onclick="return confirm('Are you sure you want to delete this request?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">No failed request found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <nav aria-label="Page navigation">
<ul class="pagination justify-content-center flex-wrap">
<li class="page-item {{ $failedSubscriptions->previousPageUrl() ? '' : 'disabled' }}">
<a class="page-link" href="{{ $failedSubscriptions->previousPageUrl() }}" aria-label="Previous">
    <span aria-hidden="true">&laquo;</span>
</a>
</li>
@for ($i = 1; $i <= $failedSubscriptions->lastPage(); $i++)
<li class="page-item {{ $failedSubscriptions->currentPage() == $i ? 'active' : '' }}">
<a class="page-link" href="{{ $failedSubscriptions->url($i) }}">{{ $i }}</a>
</li>
@endfor
<li class="page-item {{ $failedSubscriptions->nextPageUrl() ? '' : 'disabled' }}">
<a class="page-link" href="{{ $failedSubscriptions->nextPageUrl() }}" aria-label="Next">
    <span aria-hidden="true">&raquo;</span>
</a>
</li>
</ul>
</nav>
<p class="text-center">Showing {{ $failedSubscriptions->firstItem() }} - {{ $failedSubscriptions->lastItem() }} of {{ $failedSubscriptions->total() }} Failed Subscriptions</p>

    </div>
@endif
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
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
