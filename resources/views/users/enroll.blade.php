@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Enroll {{ $user->name }} in Courses</h1>

    <form action="{{ route('users.enroll.store', $user->id) }}" method="POST">
        @csrf
        <label for="course_ids">Select Courses to Enroll:</label>
        <select name="course_ids[]" id="course_ids" class="form-control" multiple>
            @foreach($courses as $course)
                <option value="{{ $course->id }}">{{ $course->title }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary mt-2">Enroll</button>
    </form>
    
</div>
@endsection
