@extends('layouts.app')

@section('content')
<link href="{{ asset('css/playlists/create.css') }}" rel="stylesheet">


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

    <div class="container">
        <div class="card">
            <div class="card-header">{{ __('Create Playlist') }}</div>

            <div class="card-body">
                <form action="{{ route('playlists.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="created_by" value="{{ auth()->id() }}">

                    <div class="form-group">
                        <label class="form-label" for="name">{{ __('Playlist Name') }}&nbsp;<span style="color:red;" class="required-icon">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="description">{{ __('Description') }}&nbsp;</label>
                        <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="video_search">{{ __('Search Videos (by title or URL)') }}</label>
                        <input type="text" id="video_search" class="form-control" placeholder="Enter video title or URL" oninput="searchVideos()">
                        <div id="video_results" class="mt-2"></div> <!-- Container to display search results -->
                    </div>

                    <div class="form-group">
                        <label class="form-label">{{ __('Selected Videos') }}</label>
                        <ul id="selected_videos" class="list-group mb-3"></ul> <!-- List of selected videos -->
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-md-right form-label" for="image">{{ __('Image:') }}&nbsp;<span style="color:red;" class="required-icon">*</span></label>
                        <div class="col-md-9">
                            <div class="input-file-wrapper">
                                <input type="file" name="image" id="image" class="form-control" accept="image/*" style="display: none;" onchange="showFileName()" required>
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

                    <!-- Hidden input to store selected video IDs -->
                    <input type="hidden" name="video_ids" id="video_ids">

                    <button type="submit" class="btn-submit">{{ __('Create Playlist') }}</button>
                </form>
            </div>
        </div>
    </div>


    <script>
        function searchVideos() {
            const query = document.getElementById('video_search').value;
            const playlistId = "{{ $playlist->id ?? null }}"; // Pass the playlist ID if it exists
        
            if (query.length > 0) {
                fetch(`/videos/search?query=${query}&playlist_id=${playlistId}`)
                    .then(response => response.json())
                    .then(data => {
                        const resultsContainer = document.getElementById('video_results');
                        resultsContainer.innerHTML = '';
                        data.forEach(video => {
                            const existingVideoIds = Array.from(document.querySelectorAll('#selected_videos li')).map(li => li.dataset.videoId);
                            
                            // Check if the video is already selected
                            if (!existingVideoIds.includes(video.id.toString())) {
                                const listItem = document.createElement('div');
                                listItem.classList.add('list-group-item');
                                listItem.innerHTML = `
                                    ${video.title} 
                                    <button class="btn btn-sm btn-success" data-video-id="${video.id}" onclick="addVideo(event)">Add</button>
                                `;
                                resultsContainer.appendChild(listItem);
                            }
                        });
                    });
            }
        }
        
        function addVideo(event) {
            event.preventDefault(); // Prevent form submission

            const button = event.target;
            const videoId = button.getAttribute('data-video-id');
            const title = button.previousSibling.textContent.trim();

            const selectedVideos = document.getElementById('selected_videos');
            const listItem = document.createElement('li');
            listItem.classList.add('list-group-item');
            listItem.textContent = title;

            // Add a remove button
            listItem.innerHTML = `${title} 
                <button class="btn btn-sm btn-danger float-right" onclick="removeVideo(${videoId}, this)">Remove</button>`;

            // Store the video ID in a data attribute
            listItem.dataset.videoId = videoId;
            
            selectedVideos.appendChild(listItem);
            
            // Update the hidden input with the selected video IDs
            const videoIdsInput = document.getElementById('video_ids');
            let currentVideoIds = videoIdsInput.value ? JSON.parse(videoIdsInput.value) : [];
            currentVideoIds.push(videoId);
            videoIdsInput.value = JSON.stringify(currentVideoIds);
            
            document.getElementById('video_results').innerHTML = '';
        }
        
        function removeVideo(id, button) {
            const videoItem = button.parentElement; // Get the parent li element
            const selectedVideos = document.getElementById('selected_videos');
            
            // Remove the selected video from the DOM
            selectedVideos.removeChild(videoItem);
        
            // Update the hidden input by removing the video ID
            const videoIdsInput = document.getElementById('video_ids');
            let currentVideoIds = JSON.parse(videoIdsInput.value);
            currentVideoIds = currentVideoIds.filter(videoId => videoId !== id);
            videoIdsInput.value = JSON.stringify(currentVideoIds);
        }
    </script>

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
            window.location.href = "{{ route('login') }}";
        }, 3000); // Redirect after 3 seconds
    </script>
@endif


@endsection
