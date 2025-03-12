@extends('layouts.app')

@section('content')
<link href="{{ asset('css/assignments/create.css') }}" rel="stylesheet">
@if(auth()->check() && auth()->user()->role === 'admin')
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
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Create New Assignment</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('assignments.store') }}" enctype="multipart/form-data">
                            @csrf

                            <!-- Course ID -->
                            <div class="form-group">
                                <label for="course_id">Course:</label>
                                <select id="course_id" name="course_id" class="form-control">
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Title -->
                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" id="title" name="title" class="form-control" required>
                            </div>

                            <!-- Description -->
                            <div class="form-group">
                                <label for="description">Description:</label>
                                <textarea id="description" name="description" class="form-control"></textarea>
                            </div>

                                
               
            
                            <!-- Due Date -->
                            <div class="form-group">
                                <label for="due_date">Due Date:</label>
                                <input type="datetime-local" id="due_date" name="due_date" class="form-control" required>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-right" for="file">{{ __('file:') }}</label>
                                <div class="col-md-9">
                                    <div class="input-file-wrapper">
                                        <input type="file" name="file" id="file" class="form-control" accept="image/*,.pdf,.doc,.docx" style="display: none;" onchange="showFileName()">
            
                                        <button type="button" class="custom-file-button" onclick="document.getElementById('file').click();">
                                            <i class="fas fa-upload"></i> {{ __('Choose File') }}
                                        </button>
                                        <span id="file-name" class="file-name-text">No file chosen</span> <!-- Display file name -->
                                    </div>
                                </div>
                            </div>
                            
                            <script>
                                function showFileName() {
                                    var input = document.getElementById('file');
                                    var fileName = input.files[0] ? input.files[0].name : 'No file chosen'; // Show the file name or a default message
                                    document.getElementById('file-name').textContent = fileName; // Update the file name display
                                }
                            </script>

                            
                            <!-- User ID (Hidden) -->
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                            <button type="submit" class="btn bg-purple btn-primary">Create Assignment</button>
                        </form>
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

