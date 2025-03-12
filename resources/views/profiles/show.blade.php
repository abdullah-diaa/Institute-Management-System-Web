@extends('layouts.app')

@section('content')
<link href="{{ asset('css/profiles/show.css') }}" rel="stylesheet">

<div class="profile-container">
    <div class="profile-header">
        <div class="profile-image-wrapper">
            @if ($profile->user_id === auth()->id())
            <a href="{{ route('settings.profile.picture') }}">
                <img src="{{ $profile->profile_picture ? asset('storage/' . $profile->profile_picture) : asset('images/default-profile-picture.jpg') }}" alt="Profile Picture">
               
                <div class="overlay">
                    <span class="overlay-text">Change Profile Picture</span>
                </div>
               
            </a>

            @else

            <img src="{{ $profile->profile_picture ? asset('storage/' . $profile->profile_picture) : asset('images/default-profile-picture.jpg') }}" alt="Profile Picture">


            @endif
        </div>
        <div class="profile-info">
            <h1 class="profile-name">{{ isset($profile->user) ? $profile->user->name : 'Unknown User' }}</h1>
            <p class="profile-role">{{ isset($profile->user) ? ucfirst($profile->user->role) : 'N/A' }}</p>
        </div>
    </div>

    <div class="profile-body">
        <div class="profile-section">
            <h3 class="section-title">Personal Information</h3>
            <div class="info-cards">
                <div class="info-card">
                    <h4>Gender</h4>
                    <p>{{ isset($profile->user) && isset($profile->user->gender) ? ucfirst($profile->user->gender) : 'N/A' }}</p>
                </div>
                <div class="info-card">
                    <h4>Location</h4>
                    <p>{{ $profile->location ?? 'N/A' }}</p>
                </div>
                <div class="info-card">
                    <h4>Date of Birth</h4>
                    <p>{{ $profile->date_of_birth ?? 'N/A' }}</p>
                </div>
                <div class="info-card">
                    <h4>Email</h4>
                    <p>{{ isset($profile->user) ? $profile->user->email : 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
