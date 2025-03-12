@extends('layouts.app')

@section('content')
<link href="{{ asset('css/playlists/create.css') }}" rel="stylesheet">

<div class="container">
    <div class="card">
        <div class="card-header bg-purple text-white">
            <h3>Change Profile Picture</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('settings.profile.picture.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right form-label" for="image">{{ __('Image:') }}&nbsp;<span style="color:red;" class="required-icon">*</span></label>
                    <div class="col-md-9">
                        <div class="input-file-wrapper">
                            <input type="file" name="profile_picture" id="profile_picture" class="form-control" accept="image/*" style="display: none;" onchange="showFileName()" required>
                            <button type="button" class="custom-file-button" onclick="document.getElementById('profile_picture').click();">
                                <i class="fas fa-upload"></i> {{ __('Choose File') }}
                            </button>
                            <span id="file-name" class="file-name-text">No file chosen</span> <!-- Display file name -->
                        </div>
                    </div>
                </div>

                <script>
                    function showFileName() {
                        var input = document.getElementById('profile_picture');
                        var fileName = input.files[0] ? input.files[0].name : 'No file chosen'; // Show the file name or a default message
                        document.getElementById('file-name').textContent = fileName; // Update the file name display
                    }
                </script>

                <div class="form-group">
                    <button type="submit" class="custom-file-button">Update Picture</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
