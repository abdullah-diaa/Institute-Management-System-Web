@extends('layouts.app')

@section('content')

<link href="{{ asset('css/enrollments/create.css') }}" rel="stylesheet">
@if(auth()->check() && auth()->user()->role === 'admin' && auth()->user()->status === 1)
<div class="container">
  
    <div class="card">
        <div class="card-header">{{ __('Enroll Student') }}</div>

        <div class="card-body">
            <form method="POST" action="{{ route('enrollments.store') }}">
                @csrf

                <div class="form-group row">
                    <label for="user_id" class="col-md-3 col-form-label text-md-right">{{ __('Student') }}</label>

                    <div class="col-md-9">
                        <select id="user_id" class="form-control @error('user_id') is-invalid @enderror" name="user_id" required>
                            <option value="" selected>Select student</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>

                        @error('user_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="course_id" class="col-md-3 col-form-label text-md-right">{{ __('Course') }}</label>

                    <div class="col-md-9">
                        <select id="course_id" class="form-control @error('course_id') is-invalid @enderror" name="course_id" required>
                            <option value="" selected>Select course</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->title }}</option>
                            @endforeach
                        </select>

                        @error('course_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-9 offset-md-3">
                        <button type="submit" class="btn btn-primary bg-purple">
                            {{ __('Enroll') }}
                        </button>
                    </div>
                </div>
            </form>
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
