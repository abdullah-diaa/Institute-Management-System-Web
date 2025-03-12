@extends('layouts.app')

@section('content')

<link href="{{ asset('css/posts/create.css') }}" rel="stylesheet">
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
        <div class="card-header">{{ __('Create Post') }}</div>

        <div class="card-body">
            <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                 <input type="hidden" name="user_id" value="{{ auth()->user()->id }}" required>

                <div class="form-group">
                    <label class="form-label" for="title">{{ __('Title') }}&nbsp;<span style="color:red;" class="required-icon">*</span></label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="content">{{ __('Content') }}&nbsp;<span style="color:red;" class="required-icon">*</span></label>
                    <textarea name="content" id="content" class="form-control" rows="6" required></textarea>
                </div>
                
               
                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right form-label" for="image">{{ __('Image') }}</label>
                    <div class="col-md-9">
                        <div class="input-file-wrapper">
                            <input type="file" name="image" id="image" class="form-control" accept="image/*" style="display: none;" onchange="showFileName()">
                            <button type="button" class="custom-file-button" onclick="document.getElementById('image').click();">
                                <i class="fas fa-upload"></i> {{ __('Choose File') }}
                            </button>
                            <span id="file-name" class="file-name-text">No file chosen</span> <!-- Display file name -->
                        </div>
                    </div>
                </div>
                
                <script>
                    function showFileName() {
                        var input = document.getElementById('image');
                        var fileName = input.files[0] ? input.files[0].name : 'No file chosen'; // Show the file name or a default message
                        document.getElementById('file-name').textContent = fileName; // Update the file name display
                    }
                </script>

                <button type="submit" class="btn-submit">{{ __('Create Post') }}</button>
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
