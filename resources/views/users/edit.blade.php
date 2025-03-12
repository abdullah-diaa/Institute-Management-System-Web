@extends('layouts.app')

@section('content')
<link href="{{ asset('css/users/edit.css') }}" rel="stylesheet">

@if(auth()->check() && auth()->user()->role === 'admin')
    <!-- Logic to display the user edit form for admin -->

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
            <div class="card-header">{{ __('Edit User') }}</div>

            <div class="card-body">
                <form action="{{ route('users.update', $user->id) }}" method="post">
                    @csrf
                    @method('PUT')

                    <!-- User ID (hidden) -->
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    

                    <!-- Role -->
                    <div class="form-group">
                        <label class="form-label" for="role">{{ __('Email') }}&nbsp;<span style="color:red;" class="required-icon">*</span></label>
                        <input  name="email" value="{{ $user->email }}" class="form-control" readonly required>
                    </div>
                    <!-- Role -->
                    <div class="form-group">
                        <label class="form-label" for="role">{{ __('Role') }}&nbsp;<span style="color:red;" class="required-icon">*</span></label>
                        <select name="role" id="role" class="form-control" required>
                            <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>Student</option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <!-- Member Status -->
                    <div class="form-group">
                        <label class="form-label" for="member">{{ __('Member Status') }}&nbsp;<span style="color:red;" class="required-icon">*</span></label>
                        <select name="member" id="member" class="form-control" required>
                            <option value="0" {{ $user->member == 0 ? 'selected' : '' }}>Non-Member</option>
                            <option value="1" {{ $user->member == 1 ? 'selected' : '' }}>Member</option>
                        </select>
                    </div>

                    <!-- Account Status -->
                    <div class="form-group">
                        <label class="form-label" for="status">{{ __('Account Status') }}&nbsp;<span style="color:red;" class="required-icon">*</span></label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-submit">{{ __('Update User') }}</button>
                </form>
            </div>
        </div>
    </div>

@else
    <div class="container">
        <div class="card">
            <div class="card-header">{{ __('Page Not Found') }}</div>

            <div class="card-body">
                <div class="alert">
                    <b>{{ __('The page you are looking for does not exist.') }}</b>
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
