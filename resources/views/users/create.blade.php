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
            <div class="card-header">{{ __('Edit Enrollment') }}</div>

            <div class="card-body">
                <form action="{{ route('users.update-enroll', $user->id) }}" method="post">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="user_id" value="{{ $user->id }}" required>

                    <div class="form-group">
                        <label class="form-label" for="courses">{{ __('Courses') }}&nbsp;<span class="required-icon">*</span></label>
                        <select name="course_ids[]" id="courses" class="form-control" multiple required>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" 
                                        {{ in_array($course->id, $user->courses->pluck('id')->toArray()) ? 'selected' : '' }}>
                                    {{ $course->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="new_course">{{ __('Add New Course') }}</label>
                        <input type="text" name="new_course" id="new_course" class="form-control" placeholder="Enter new course title (optional)">
                    </div>

                    <button type="submit" class="btn-submit">{{ __('Update Enrollment') }}</button>
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
