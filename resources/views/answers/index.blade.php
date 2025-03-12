@extends('layouts.app')

@section('content')
<link href="{{ asset('css/answers/index.css') }}" rel="stylesheet">
@if(auth()->check() && auth()->user()->role === 'admin' && auth()->user()->status === 1)
<div class="container">
    <h1 class="mb-4">Answers</h1>
    <div class="row">
        @if($answers->isEmpty())
        <p>There is no answer yet</p>
        @else
        @foreach($answers as $answer)
        <div class="col-md-4 mb-4">
            <div class="card position-relative">
                @if( auth()->user()->id === $answer->assignment->user_id)
                <!-- "X" button for deletion -->
                <form action="{{ route('answers.destroy', ['assignment' => $assignment->id, 'answer' => $answer->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this answer?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-btn">&times;</button>
                </form>
            
                @endif
                <div class="card-body">
                    <div class="user-profile">
                        @if ($answer->user->profile)
                        <img src="{{ asset('storage/' . $answer->user->profile->profile_picture) }}" alt="Profile Picture" class="profile-picture img-fluid rounded-circle">
                        @else
                        <img src="{{ asset('path_to_placeholder_image.jpg') }}" alt="Placeholder" class="profile-picture img-fluid rounded-circle">
                        @endif
                    </div>
                    <h5 class="card-title">Uploaded by: 
                        
                        @if ($answer->user->profile)
                        <a href="{{ route('profiles.show', $answer->user->profile->id) }}" class="username-decoration font-weight-bold">{{ $answer->user->name }}</a>
                 
                        @else
                        {{ $answer->user->name }}
                    @endif
                   </h5>
                    <p class="card-text">Uploaded at: {{ \Carbon\Carbon::parse($answer->uploaded_at)->format('M d, Y h:i A') }}</p>
                    <div class="file-preview">
                       
                        @if($answer->file_path)
                        <a href="{{ asset('storage/' . $answer->file_path) }}" target="_blank" class="file-btn">
                            <i class="fas fa-file-alt"></i> View/Download File
                        </a>
                    @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif
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
