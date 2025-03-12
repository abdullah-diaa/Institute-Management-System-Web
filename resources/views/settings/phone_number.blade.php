@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{asset('css/settings/phone_number.css')}}">
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-purple text-white text-center">
            <h2 class="mb-0">Change Your Name</h2>
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

            <form action="{{ route('settings.phone.number.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group mb-4">
                    <label for="phone_number" class="form-label">New Phone Number</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-purple text-white">
                                <i class="fas fa-user"></i>
                            </span>
                        </div>
                        <input 
                            type="text" 
                            name="phone_number" 
                            id="phone_number" 
                            value="{{ old('phone_number', $user->profile->phone_number) }}" 
                            class="form-control" 
                            required 
                            {{ $canEditPhoneNumber ? '' : 'readonly' }}>
                    </div>
                </div>

                @if ($canEditPhoneNumber)
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-purple btn-lg">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            @else
                @if ($user->Profile->last_phone_update)
                    <p class="text-danger mt-2">You can only change your phone number once every month. Last change was on {{ $user->Profile->last_phone_update->format('F j, Y') }}.</p>
                @else
                    <p class="text-danger mt-2">You can only change your phone number once every month. No previous changes recorded.</p>
                @endif
            @endif
            
            </form>
        </div>
    </div>
</div>
@endsection
