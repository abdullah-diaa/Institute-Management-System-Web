@extends('layouts.app')

@section('content')

<link href="{{ asset('css/answers/create.css') }}" rel="stylesheet">
@if(auth()->check() && auth()->user()->role === 'student' && auth()->user()->status === 1)
<div class="container">
  
    <div class="card">
        <div class="card-header">{{ __('Upload Answer') }}</div>

        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('answers.store', ['assignment' => $assignment_id]) }}" enctype="multipart/form-data">
                @csrf

                <!-- Hidden field for assignment ID -->
                <input type="hidden" name="assignment_id" value="{{ $assignment_id }}">



                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right" for="file_path">{{ __('file:') }}</label>
                    <div class="col-md-9">
                        <div class="input-file-wrapper">
                            <input type="file" name="file_path" id="file_path" class="form-control" accept="image/*,.pdf,.doc,.docx" style="display: none;" onchange="showFileName()">

                            <button type="button" class="custom-file-button" onclick="document.getElementById('file_path').click();">
                                <i class="fas fa-upload"></i> {{ __('Choose File') }}
                            </button>
                            <span id="file-name" class="file-name-text">No file chosen</span> <!-- Display file name -->
                        </div>
                    </div>
                </div>
                
                <script>
                    function showFileName() {
                        var input = document.getElementById('file_path');
                        var fileName = input.files[0] ? input.files[0].name : 'No file chosen'; // Show the file name or a default message
                        document.getElementById('file-name').textContent = fileName; // Update the file name display
                    }
                </script>




                <div class="form-group row mb-0">
                    <div class="col-md-9 offset-md-3">
                        <button type="submit" class="btn btn-primary bg-purple form-control">
                            {{ __('Upload Answer') }}
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
        <div class="card-header bg-purple">{{ __('Access Denied') }}</div>

        <div class="card-body">
           <div class="alert"><b>
                {{ __('You do not have permission to access this page.') }}</b>
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
