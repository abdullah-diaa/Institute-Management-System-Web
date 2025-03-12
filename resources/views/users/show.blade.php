@extends('layouts.app')

@section('content')
<link href="{{ asset('css/posts/index.css') }}" rel="stylesheet">

@if(auth()->check() && ( auth()->user()->role === 'admin' || (auth()->user()->role === 'student' && auth()->user()->member == '1')) && auth()->user()->status == '1')

<div class="container">
    <div class="card mb-4 post-card">
        <div class="card-header d-flex justify-content-between align-items-center bg-purple text-white">
            <div class="d-flex align-items-center">
                @if ($post->user->profile && $post->user->profile->profile_picture)
                    <img src="{{ asset('storage/' . $post->user->profile->profile_picture) }}" alt="{{ $post->user->name }}" class="profile-picture">
                @endif
                <a href="{{ route('profiles.show', $post->user->id) }}" class="username-decoration font-weight-bold">
                    {{ $post->user->name }}
                </a>
            </div>
            <div>
                <span class="time-span">{{ $post->created_at->diffForHumans() }}</span>
                @if(auth()->check() && auth()->user()->role === 'admin' && auth()->user()->id == $post->user_id)
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-cog"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{ route('posts.edit', $post->id) }}"><i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this post?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="card-body">
            <h3 class="mb-3">{{ $post->title }}</h3>
            <!-- Show full content here without limiting -->
            <p class="mb-3">{{ $post->content }}</p>
            @if ($post->image)
                <div class="text-center">
                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="img-fluid mb-3 post-image">
                </div>
            @endif
        </div>

        <div class="card-footer bg-purple">
            <p><i class="fas fa-eye"></i> Views: {{ $post->views_count }}</p>
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
        window.location.href = "{{ route('home') }}";
    }, 3000); // Redirect after 3 seconds
</script>
@endif

@endsection
