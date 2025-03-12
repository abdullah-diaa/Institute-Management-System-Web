@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/settings/password_reset.css') }}">


@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header" style="background-color: #6a0dad; color: white;">
            <h2 class="mb-0 text-center">Change Your Password</h2>
        </div>
        <div class="card-body p-5">
            @if (session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('settings.password.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group mb-4">
                    <label for="old_password" class="form-label">Old Password</label>
                    <input 
                        type="password" 
                        name="old_password" 
                        id="old_password" 
                        class="form-control" 
                        required 
                        placeholder="Enter your old password">
                </div>

                <div class="form-group mb-4">
                    <label for="new_password" class="form-label">New Password</label>
                    <input 
                        type="password" 
                        name="new_password" 
                        id="new_password" 
                        class="form-control" 
                        required 
                        placeholder="Enter your new password">
                </div>

                <div class="form-group mb-4">
                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                  <input type="password" name="new_password_confirmation" id="confirm_password" 
                  class="form-control" 
                  required 
                  placeholder="Confirm your new password">

                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary" style="background-color: #6a0dad;">
                        <i class="fas fa-save"></i> Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
