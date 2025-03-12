@extends('layouts.app')

@section('content')

<link href="{{ asset('css/youtube_videos/create.css') }}" rel="stylesheet">
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
    <div class="card">
        <div class="card-header">{{ __('Create YouTube Video') }}</div>

        <div class="card-body">
            <form action="{{ route('youtube_videos.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}" required>

                <div class="form-group">
                    <label class="form-label" for="title">{{ __('Title') }}&nbsp;<span style="color:red;" class="required-icon">*</span></label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="youtube_url" class="form-label">{{ __('YouTube URL') }}&nbsp;<span style="color:red;" class="required-icon">*</span></label>
                    <input type="text" name="youtube_url" id="youtube_url" class="form-control" required>
                </div>
                

                <div class="form-group">
                    <label class="form-label" for="description">{{ __('Description') }}&nbsp;</label>
                    <textarea name="description" id="description" class="form-control" rows="6" ></textarea>
                </div>

               

                <button type="submit" class="btn-submit">{{ __('Create YouTube Video') }}</button>
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
