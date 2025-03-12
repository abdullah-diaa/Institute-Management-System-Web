@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{asset('css/settings/index.css')}}">
<div class="container settings-container">
    <div class="settings-header">
        <h1 class="settings-title"><i class="fas fa-cogs"></i> Account Settings</h1>
        <p class="settings-description">Manage your personal information, account security, and more.</p>
    </div>

    <!-- Profile Section -->
    <div class="settings-card">
        <div class="settings-card-header">
            <h2 class="settings-section-title"><i class="fas fa-user-circle"></i> Profile Settings</h2>
            <p class="settings-section-description">Keep your profile information up-to-date.</p>
        </div>
        <div class="settings-card-body">
            <ul class="settings-list">
                <li>
                    <a href="{{ route('settings.name.edit') }}" class="settings-link">
                        <i class="fas fa-user-edit"></i> Change Name
                    </a>
                </li>
                <li>
                    <a href="{{ route('settings.profile.info.edit') }}" class="settings-link">
                        <i class="fas fa-id-card"></i> Update Profile Info (Gender, Date of Birth, Location)
                    </a>
                </li>
                <li>
                    <a href="{{ route('settings.phone.number.edit') }}" class="settings-link">
                        <i class="fas fa-phone-alt"></i> Update Phone Number
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Security Section -->
    <div class="settings-card">
        <div class="settings-card-header">
            <h2 class="settings-section-title"><i class="fas fa-lock"></i> Security Settings</h2>
            <p class="settings-section-description">Change your password for better security.</p>
        </div>
        <div class="settings-card-body">
            <ul class="settings-list">
                <li>
                    <a href="{{ route('settings.password.reset') }}" class="settings-link">
                        <i class="fas fa-key"></i> Reset Password
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
