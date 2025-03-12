@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/settings/profile_info.css') }}">

<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-purple text-white text-center">
            <h2 class="mb-0">Edit Profile Information</h2>
        </div>

        <div class="card-body p-5">
            <!-- Nav Tabs -->
            <ul class="nav nav-tabs mb-4" id="profileTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="location-tab" data-toggle="tab" href="#location" role="tab" aria-controls="location" aria-selected="true">
                        Location & Date of Birth
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="gender-tab" data-toggle="tab" href="#gender" role="tab" aria-controls="gender" aria-selected="false">
                        Gender
                    </a>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="profileTabsContent">
                <!-- Location & Date of Birth Tab -->
                <div class="tab-pane fade show active" id="location" role="tabpanel" aria-labelledby="location-tab">
                    <form action="{{ route('settings.profile_info.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-4">
                            <label for="location" class="form-label">Location</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-purple text-white">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </span>
                                </div>
                                <input type="text" name="location" id="location" value="{{ old('location', $location) }}" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-purple text-white">
                                        <i class="fas fa-calendar"></i>
                                    </span>
                                </div>
                                <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $dateOfBirth) }}" class="form-control" required>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-purple btn-lg">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Gender Tab -->
                <div class="tab-pane fade" id="gender" role="tabpanel" aria-labelledby="gender-tab">
                    <form action="{{ route('settings.profile_info.update_gender') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-4">
                            <label for="gender" class="form-label">Gender</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-purple text-white">
                                        <i class="fas fa-venus-mars"></i>
                                    </span>
                                </div>
                                <select name="gender" id="gender" class="form-control" required>
                                    <option value="male" {{ $gender == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ $gender == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-purple btn-lg">
                                <i class="fas fa-save"></i> Save Gender
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
