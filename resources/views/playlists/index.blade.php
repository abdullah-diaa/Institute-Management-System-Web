@extends('layouts.app')

@section('content')
<link href="{{ asset('css/playlists/index.css') }}" rel="stylesheet">
@if(auth()->check() && auth()->user()->role === 'admin' && auth()->user()->status == '1')

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
        @if(auth()->check() && auth()->user()->role === 'admin' &&  auth()->user()->status == '1')
        <div class="col">
            <a href="{{ route('playlists.create') }}" class="custom-file-button float-right mt-5">
                <i class="fas fa-plus-circle"></i> Create Playlist
            </a>
        </div>
        @endif
    </div>
    
    <h1 class="mb-4">Playlists</h1>
    
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('youtube_videos.index') }}">YouTube Videos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="#">Playlists</a> <!-- Highlighted -->
        </li>
    </ul>

    <div class="row">
        @if ($playlists->isEmpty())
            <p>No playlists found.</p>
        @else
            @foreach($playlists as $playlist)
            <div class="col-12 mb-4"> <!-- Changed from col-md-4 to col-12 -->
                <div class="card shadow-sm">
                    <img src="{{ asset('storage/' . $playlist->image) }}" alt="Playlist Image" class="card-img">
                    <div class="card-body">
                        <h5 class="card-title">{{ $playlist->name }}</h5>
                        <p class="card-text">{{ Str::limit($playlist->description, 200) }} <span><a href="{{ route('playlists.show', $playlist->id) }}">Learn more</a></span></p>

                        <p class="text-muted">Published By:&nbsp; 
                      @if ($playlist->createdBy->profile)
                      <a href="{{ route('profiles.show', $playlist->createdBy->profile->id) }}" class="username-decoration font-weight-bold">{{ $playlist->createdBy->name }}</a>
               
                      @else
                      {{ $playlist->createdBy->name }}
                  @endif
                  </p>
                  
                        <p class="text-muted">Number of Videos: {{ $playlist->videos->count() }}</p>
                        <a href="{{ route('playlists.show', $playlist->id) }}" class="custom-file-button">View Playlist</a>
                        @if(auth()->check() && auth()->user()->role === 'admin' &&  auth()->user()->status == '1')                        <div class="dropdown float-right">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $playlist->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-cog"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $playlist->id }}">
                                <a class="dropdown-item" href="{{ route('playlists.edit', $playlist->id) }}">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('playlists.destroy', $playlist->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this playlist?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
    
            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item {{ $playlists->previousPageUrl() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $playlists->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    @for ($i = 1; $i <= $playlists->lastPage(); $i++)
                        <li class="page-item {{ $playlists->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $playlists->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item {{ $playlists->nextPageUrl() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $playlists->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <p class="text-center">Showing {{ $playlists->firstItem() }} - {{ $playlists->lastItem() }} of {{ $playlists->total() }} playlists</p>
        @endif
    </div>
    
</div>
@endsection
