@extends('layouts.app')

@section('content')
<link href="{{ asset('css/profiles/edit.css') }}" rel="stylesheet">

@if(auth()->check() && (auth()->user()->role === 'admin' || (auth()->user()->role === 'student' && auth()->user()->id === $profile->user_id)))
    <!-- Logic to display the profile -->


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
        <div class="card-header">{{ __('Edit Profile') }}</div>

        <div class="card-body">
            <form action="{{ route('profiles.update', $profile->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')



                    <input type="text" name="user_id" id="user_id" class="form-control" value="{{ $profile->user_id }}" required hidden>
              

                <div class="form-group">
                    <label class="form-label" for="location">{{ __('Location') }}&nbsp;<span style="color:red;" class="required-icon">*</span></label>
                    <input type="text" name="location" id="location" class="form-control" value="{{ $profile->location }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="phone_number">{{ __('Phone Number') }}&nbsp;<span style="color:red;" class="required-icon">*</span></label>
                    <input type="tel" name="phone_number" id="phone_number" class="form-control" value="{{ $profile->phone_number }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="date_of_birth">{{ __('Date of Birth') }}</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="{{ $profile->date_of_birth }}">
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right form-label" for="profile_picture">{{ __('Profile Picture') }}</label>
                    <div class="col-md-9">
                        <div class="input-file-wrapper">
                            <input type="file" name="profile_picture" id="profile_picture" class="form-control">
                            <button type="button" class="form-control custom-file-button">
                                <i class="fas fa-upload"></i> {{ __('Choose File') }}
                            </button>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-submit">{{ __('Update Profile') }}</button>
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
        window.location.href = "{{ route('home') }}";
    }, 3000); // Redirect after 3 seconds
</script>
@endif

@endsection
