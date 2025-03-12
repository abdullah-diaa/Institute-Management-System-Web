@extends('layouts.app')

@section('content')
<link href="{{ asset('css/youtube_videos/index.css') }}" rel="stylesheet">
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
            <a href="{{ route('youtube_videos.create') }}" class="custom-file-button float-right mt-5">
                <i class="fas fa-plus-circle"></i> Create Video
            </a>
        </div>
        @endif
    </div>
    
    <h1 class="mb-4">YouTube Videos</h1>
    
    <!-- Tabs for switching between YouTube videos and playlists -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link active" href="#">YouTube Videos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="{{ route('playlists.index') }}">Playlists</a> <!-- Highlighted -->
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="youtube-videos">
            @if ($videos->isEmpty())
                <p>No videos found.</p>
            @else
                @foreach($videos as $video)
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center bg-purple text-white">
                            <h5>{{ $video->title }}</h5>
                            <div class="dropdown">
                                @if(auth()->check() && auth()->user()->role === 'admin' &&  auth()->user()->status == '1')      
                                                          <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-cog"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{ route('youtube_videos.edit', $video->id) }}"><i class="fas fa-edit"></i> Edit</a>
                                    <form action="{{ route('youtube_videos.destroy', $video->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this video?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Embed video here -->
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
                <p class="text-center">Showing {{ $videos->firstItem() }} - {{ $videos->lastItem() }} of {{ $videos->total() }} videos</p>
            @endif
        </div>
    </div>
</div>
@endsection
