@extends('layouts.app')

@section('content')
<link href="{{ asset('css/profiles/create.css') }}" rel="stylesheet">
@if(auth()->check())
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
        <div class="card-header">{{ __('Create Profile') }}</div>

        <div class="card-body">
            <form action="{{ route('profiles.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                 <input type="hidden" name="user_id" value="{{ auth()->user()->id }}" required>


                <div class="form-group">
                    <label class="form-label" for="location">{{ __('Location') }}&nbsp;<span style="color:red;" class="required-icon">*</span></label>
                    <input type="text" name="location" id="location" class="form-control" maxlength="30" required title="Location must be a maximum of 30 characters">
                </div>

                <div class="form-group">
                    <label class="form-label" for="phone_number">{{ __('Phone Number') }}&nbsp;<span style="color:red;" class="required-icon">*</span></label>
                    <input type="tel" name="phone_number" id="phone_number" class="form-control" minlength="11" maxlength="11" pattern="\d{11}" required title="Phone number must be exactly 11 digits">
                </div>

                <div class="form-group">
                    <label class="form-label" for="date_of_birth">{{ __('Date of Birth') }}</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" class="form-control">
                </div>


                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right form-label" for="profile_picture">{{ __('Profile Picture') }}</label>
                    <div class="col-md-9">
                        <div class="input-file-wrapper">
                            <input type="file" name="profile_picture" id="profile_picture" class="form-control" accept="image/*" style="display: none;" onchange="showFileName()">
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
                


                <button type="submit" class="btn-submit">{{ __('Create Profile') }}</button>
            </form>
        </div>
    </div>
</div>
@else
<div class="container">
    <div class="card">
        <div class="card-header">{{ __('Page Not Found') }}</div>

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
