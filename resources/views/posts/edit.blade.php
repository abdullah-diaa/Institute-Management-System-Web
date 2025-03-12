@extends('layouts.app')
@section('content')
<link href="{{ asset('css/posts/create.css') }}" rel="stylesheet">
                        @if(auth()->check() && auth()->user()->role === 'admin' && auth()->user()->id == $post->user_id)
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
        <div class="card-header">{{ __('Edit Post') }}</div>

        <div class="card-body">
            <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label" for="title">{{ __('Title') }}&nbsp;<span style="color:red;" class="required-icon">*</span></label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ $post->title }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="content">{{ __('Content') }}&nbsp;<span style="color:red;" class="required-icon">*</span></label>
                    <textarea name="content" id="content" class="form-control" rows="6" required>{{ $post->content }}</textarea>
                </div>

                
    
                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right form-label" for="image">{{ __('Image') }}</label>
                    <div class="col-md-9">
                        <div class="input-file-wrapper">
                            <input type="file" name="image" id="image" class="form-control" accept="image/*" style="display: none;" onchange="showFileName()">
                            <button type="button" class="custom-file-button" onclick="document.getElementById('image').click();">
                                <i class="fas fa-upload"></i> {{ __('Choose File') }}
                            </button>
                            <span id="file-name" class="file-name-text">{{ $post->image ? $post->image : 'No file chosen' }}</span> <!-- Display file name -->
                        </div>
                        @if($post->image)
                        <img src="{{ asset('storage/'.$post->image) }}" alt="Current post Image" class="img-thumbnail mt-2" style="max-width: 150px;">
                    @endif
                    </div>
                </div>
                
                <script>
                    function showFileName() {
                        var input = document.getElementById('image');
                        var fileName = input.files[0] ? input.files[0].name : 'No file chosen'; // Show the file name or a default message
                        document.getElementById('file-name').textContent = fileName; // Update the file name display
                    }
                </script>

                <button type="submit" class="btn-submit">{{ __('Update Post') }}</button>
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
