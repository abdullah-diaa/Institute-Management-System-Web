@extends('layouts.app')

@section('content')
<link href="{{ asset('css/users/index.css') }}" rel="stylesheet">
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
                    <h5 class="card-title mb-0">User Management</h5>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <form class="form-inline mr-3" method="GET" action="{{ route('users.index') }}">
                            <div class="input-group">
                                <input type="text" class="form-control search-input" name="search" placeholder="Search by name or email..." value="{{ request('search') }}">
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
                                    <th>Last_Name_Update</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Member</th>
                                    <th>Gender</th>
                                    <th>Enrolled Courses</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                 <td>{{ $user->last_name_update ? $user->last_name_update->format('Y-m-d_h:i A') : 'N/A' }}</td>

                                    <td>{{ $user->email }}</td>
                                    <td>{{ ucfirst($user->role) }}</td>
                                    <td>
                                        {{ $user->status ? 'Active' : 'Inactive' }}
                                    </td>
                                    <td>
                                        {{ $user->member ? 'Yes' : 'No' }}
                                    </td>
                                    <td>{{ ucfirst($user->gender ?? 'N/A') }}</td>

                                    <td>
                                        @if($user->courses->isEmpty())
                                            <span>No courses enrolled.</span>
                                        @else
                                            <ul>
                                                @foreach($user->courses as $course)
                                                 
                                                    <li> <b><a href="{{ route('courses.show', $course->id) }}" class="username-decoration font-weight-bold">{{ $course->title }}</a></b></li>

                                                @endforeach
                                            </ul>
                                        @endif
                                    </td>
                              
                                    <td>
                                        <div class="btn-group" role="group" aria-label="User Actions">
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-secondary btn-action mr-1">Edit</a>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-action" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                            </form>
                                            @if ($user->courses->isEmpty())
                                            <a href="{{ route('users.create-enroll', $user->id) }}"class="btn btn-primary btn-action">Create Enrollment</a>
                                        @else
                                            <a href="{{ route('users.edit-enroll', $user->id) }}" class="btn btn-warning btn-action">Edit Enrollment</a>
                                        @endif
                                        

                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8">No users found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center flex-wrap">
                            <li class="page-item {{ $users->previousPageUrl() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $users->previousPageUrl() }}" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            @for ($i = 1; $i <= $users->lastPage(); $i++)
                            <li class="page-item {{ $users->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
                            </li>
                            @endfor
                            <li class="page-item {{ $users->nextPageUrl() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $users->nextPageUrl() }}" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <p class="text-center">Showing {{ $users->firstItem() }} - {{ $users->lastItem() }} of {{ $users->total() }} users</p>
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
