@extends('layouts.app')

@section('content')
<link href="{{ asset('css/posts/index.css') }}" rel="stylesheet">

@if(auth()->check() && auth()->user()->role === 'admin'  && auth()->user()->status == '1')
<div id="notification-container">
    @if ($errors->any())
        <div class="notification error">
            <i class="fas fa-exclamation-circle"></i>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="notification success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif
</div>
@endif
<div class="container">
    <div class="row mb-3">
        @if(auth()->check() && auth()->user()->role === 'admin' && auth()->user()->status == '1') 
        <div class="col">
            <a href="{{ route('posts.create') }}" class="custom-file-button float-right mt-5">
                <i class="fas fa-plus-circle"></i> Create Post
            </a>
        </div>
        @endif
    </div>
    
    <h1 class="mb-4">All Posts</h1>
    
    @if ($posts->isEmpty())
        <p>No posts found.</p>
    @else
        @foreach($posts as $post)
            <div class="card mb-4 post-card" data-id="{{ $post->id }}">
                <div class="card-header d-flex justify-content-between align-items-center bg-purple text-white">
                    <div class="d-flex align-items-center">
                        @if ($post->user->profile && $post->user->profile->profile_picture)
                            <img src="{{ asset('storage/' . $post->user->profile->profile_picture) }}" alt="{{ $post->user->name }}" class="profile-picture">
                        @endif
                        <a href="{{ route('profiles.show', $post->user->profile->id) }}" class="username-decoration font-weight-bold">
                            {{ $post->user->name }}
                        </a>
                    </div>
                    
                    <div>
                        <span class="time-span">{{ $post->created_at->diffForHumans() }}</span>
                        @if(auth()->check() && auth()->user()->role === 'admin' && auth()->user()->status == '1' && auth()->user()->id == $post->user_id)
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
                    <div class="d-inline-block">
                        @php
                            $contentLimit = 300; // Adjust this limit as needed
                            $contentDisplay = \Illuminate\Support\Str::limit($post->content, $contentLimit);
                        @endphp
                        <p class="mb-3">
                            {{ $contentDisplay }}
                            @if (strlen($post->content) > $contentLimit)
                                <a href="{{ route('posts.show', $post->id) }}">...read more</a>
                            @endif
                        </p>
                    </div>

                    @if ($post->image)
                        <!-- Image moved under the content -->
                        <div class="text-center">
                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="img-fluid mb-3 post-image">
                        </div>
                    @endif
                </div>

                <div class="card-footer bg-purple">
                    <p><i class="fas fa-eye"></i> Views: {{ $post->views_count }}</p>
                </div>
            </div>
        @endforeach
    @endif
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        let viewedPosts = new Set();

        $(window).on('scroll', function() {
            $('.post-card').each(function() {
                if ($(this).offset().top < $(window).scrollTop() + $(window).height() && !viewedPosts.has($(this).data('id'))) {
                    viewedPosts.add($(this).data('id'));
                    $.post('/posts/' + $(this).data('id') + '/increment-view', {
                        _token: '{{ csrf_token() }}'
                    });
                }
            });
        });
    });
</script>
@endsection
