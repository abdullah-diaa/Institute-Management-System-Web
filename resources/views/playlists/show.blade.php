@extends('layouts.app')

@section('content')
<link href="{{ asset('css/playlists/show.css') }}" rel="stylesheet">

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

<div class="container">
    <!-- Playlist Info -->
    <div class="playlist-info mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="playlist-title">{{ $playlist->name }}</h1>
                <p class="playlist-description">{{ $playlist->description }}</p>
            </div>

           
        </div> 
        
    </div>

    <!-- Videos -->
    <h3 class="mb-4">Videos in this Playlist</h3>
     <!-- Admin Edit Button -->
     @if(auth()->check() && auth()->user()->role === 'admin' && auth()->user()->status == '1')
     <a href="{{ route('playlists.edit', $playlist->id) }}" class="custom-file-button">
             <i class="fas fa-cog"></i> Edit This Playlist
         </a>
         <br><br>
     @endif
    @if ($videos->isEmpty())
        <p>No videos found in this playlist.</p> 
    @else
        @foreach($videos as $video)
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center bg-purple text-white">
                    <h5>{{ $video->title }}</h5>
                </div>
                <div class="card-body">
                    <!-- Embed video -->
                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/{{ $video->youtube_url }}" frameborder="0" allowfullscreen></iframe>
                    <p class="mt-3">{{ $video->description }}</p>
                </div>
            </div>
        @endforeach

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item {{ $videos->previousPageUrl() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $videos->previousPageUrl() }}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                @for ($i = 1; $i <= $videos->lastPage(); $i++)
                    <li class="page-item {{ $videos->currentPage() == $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ $videos->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
                <li class="page-item {{ $videos->nextPageUrl() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $videos->nextPageUrl() }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    @endif
</div>

@endsection
