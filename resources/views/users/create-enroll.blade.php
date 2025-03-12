@extends('layouts.app')

@section('content')

<link href="{{ asset('css/users/create-enroll.css') }}" rel="stylesheet">

@if(auth()->check() && auth()->user()->role === 'admin' && auth()->user()->status == '1')
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container">
        <div class="card">
            <div class="card-header">{{ __('Create Enrollment') }}</div>

            <div class="card-body">
                <form action="{{ route('users.store-enroll', $user->id) }}" method="post">
                    @csrf

                    <input type="hidden" name="user_id" value="{{ $user->id }}" required>

                    <div class="form-group">
                        <label class="form-label" for="courses">{{ __('Courses') }}&nbsp;<span class="required-icon">*</span></label>
                        <div id="courses" class="form-check">
                            @foreach($courses as $course)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="course_ids[]" value="{{ $course->id }}" id="course{{ $course->id }}">
                                    <label class="form-check-label" for="course{{ $course->id }}">
                                        {{ $course->title }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <small class="form-text text-muted">{{ __('Select multiple courses by checking the boxes.') }}</small>
                    </div>

                    <button type="submit" class="btn-submit">{{ __('Enroll User') }}</button>
                </form>
            </div>
        </div>
    </div>

@else
    <div class="container">
        <div class="card">
            <div class="card-header bg-purple">{{ __('Page Not Found') }}</div>

            <div class="card-body">
                <div class="alert"><b>{{ __('The page you are looking for does not exist.') }}</b></div>
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
