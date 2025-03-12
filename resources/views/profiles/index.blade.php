@extends('layouts.app')

@section('content')
<link href="{{ asset('css/profiles/index.css') }}" rel="stylesheet">
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
                    <h5 class="card-title mb-0">Profiles Management</h5>
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
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Location</th>
                                    <th>Phone Number</th>
                                    <th>Last Phone Update</th>
                                    <th>Date of Birth</th>
                                    <th>Profile Picture</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($profiles as $profile)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $profile->user->name }}</td>
                                    <td>{{ $profile->user->email }}</td>
                                    <td>{{ $profile->location}}</td>

                                    <td>{{ $profile->phone_number }}</td>
                                    <td>{{ $profile->last_phone_update ? $profile->last_phone_update->format('Y-m-d / h:i A') : 'N/A' }}</td>
                                    <td>{{ $profile->date_of_birth ?: 'N/A' }}</td>
                                    <td>
                                        @if ($profile->profile_picture)
                                            <img src="{{ asset('storage/' . $profile->profile_picture) }}" alt="Profile Picture" style="max-width: 100px;">
                                   @else
                                            No Picture Available
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Profile Actions">
                                            <a href="{{ route('profiles.show', $profile->id) }}" class="btn btn-info btn-action mr-1">Show </a>
                                            <form action="{{ route('profiles.destroy', $profile->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-action" onclick="return confirm('Are you sure you want to delete this profile?')">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8">No profiles found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center flex-wrap">
        <li class="page-item {{ $profiles->previousPageUrl() ? '' : 'disabled' }}">
            <a class="page-link" href="{{ $profiles->previousPageUrl() }}" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        @for ($i = 1; $i <= $profiles->lastPage(); $i++)
        <li class="page-item {{ $profiles->currentPage() == $i ? 'active' : '' }}">
            <a class="page-link" href="{{ $profiles->url($i) }}">{{ $i }}</a>
        </li>
        @endfor
        <li class="page-item {{ $profiles->nextPageUrl() ? '' : 'disabled' }}">
            <a class="page-link" href="{{ $profiles->nextPageUrl() }}" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>
<p class="text-center">Showing {{ $profiles->firstItem() }} - {{ $profiles->lastItem() }} of {{ $profiles->total() }} profiles</p>

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



