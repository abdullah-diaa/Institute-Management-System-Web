@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{asset('css/settings/name.css')}}">
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

            <form action="{{ route('settings.name.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group mb-4">
                    <label for="name" class="form-label">New Name</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-purple text-white">
                                <i class="fas fa-user"></i>
                            </span>
                        </div>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            value="{{ old('name', $user->name) }}" 
                            class="form-control" 
                            required 
                            {{ $canEditName ? '' : 'readonly' }}>
                    </div>
                </div>

                @if ($canEditName)
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-purple btn-lg">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                    </div>
                @else
                    <p class="text-danger mt-2">You can only change your name once every month. Last change was on {{ $user->last_name_update->format('F j, Y') }}.</p>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection
