@extends('layouts.app')

@section('content')

<link href="{{ asset('css/enrollments/index.css') }}" rel="stylesheet">
@if(auth()->check() && auth()->user()->role === 'admin' && auth()->user()->status === 1)
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
  <div class="row mb-3">

    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-lg">
                <div class="card-header text-white py-3">
                    <h5 class="card-title mb-0">Vox</h5>
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
                        <a href="{{ route('enrollments.create') }}" class="btn btn-primary">Create Enrollment</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Course</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($enrollments as $enrollment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $enrollment->user->name }}</td>
                                    <td>{{ $enrollment->user->email }}</td>
                                    <td>{{ $enrollment->course->title }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Enrollment Actions">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('enrollments.edit', $enrollment->id) }}" class="btn btn-secondary btn-action">Edit</a>
                                            </div>
                                            <div class="btn-group" role="group">
                                                <form action="{{ route('enrollments.destroy', $enrollment->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-action" onclick="return confirm('Are you sure you want to delete this enrollment?')">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5">No enrollments found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center flex-wrap">
                            <li class="page-item {{ $enrollments->previousPageUrl() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $enrollments->previousPageUrl() }}" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            @for ($i = 1; $i <= $enrollments->lastPage(); $i++)
                            <li class="page-item {{ $enrollments->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ $enrollments->url($i) }}">{{ $i }}</a>
                            </li>
                            @endfor
                            <li class="page-item {{ $enrollments->nextPageUrl() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $enrollments->nextPageUrl() }}" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <p class="text-center">Showing {{ $enrollments->firstItem() }} - {{ $enrollments->lastItem() }} of {{ $enrollments->total() }} enrollments</p>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="container">
    <div class="card">
        <div class="card-header bg-purple">{{ __('Page Not Found') }}</div>

        <div class="card-body">
           <div class="alert"><b>
                {{ __('The page you are looking for does not exist.') }}</b>
            </div>
        </div>
    </div>
</div>

<script>
    setTimeout(function() {
        window.location.href = "{{ route('login') }}";
    }, 3000); // Redirect after 3 seconds
</script>
@endif
@endsection
