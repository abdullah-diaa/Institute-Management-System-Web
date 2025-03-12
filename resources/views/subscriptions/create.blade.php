@extends('layouts.app')

@section('content')
<link href="{{ asset('css/subscriptions/create.css') }}" rel="stylesheet">
@if(auth()->check() && auth()->user()->role === 'student' && auth()->user()->status == '1')
<div id="notification-container">

@if ($errors->any())
    <div class="notification error">
        <i class="fas fa-exclamation-circle"></i>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div class="notification success">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
@endif
</div>
<div class="container">
    <div class="card">
        <div class="card-header bg-purple">{{ __('Subscribe to') }} {{ $course->name }}</div>

        <div class="card-body">
            <form action="{{ route('subscriptions.store', $course->id) }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="name" class="form-label">{{ __('Your Name') }}&nbsp;<span style="color:red;" class="required-icon">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ auth()->user()->name }}" readonly required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                
                <div class="form-group">
                    <label for="email" class="form-label">{{ __('Your Email') }}&nbsp;<span style="color:red;" class="required-icon">*</span></label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ auth()->user()->email }}" readonly required>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
               
                
                <!-- Phone -->
                <div class="form-group">
                    <label for="phone" class="form-label">{{ __('Phone Number') }}&nbsp;<span style="color:red;" class="required-icon">*</span></label>
                    @if(auth()->user()->profile->phone_number)
                    <input type="tel" name="phone" id="phone" class="form-control" value="{{auth()->user()->profile->phone_number}}" required pattern="\d{11}" title="Please enter exactly 11 digits." maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                @else
                    <input type="tel" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" required pattern="\d{11}" title="Please enter exactly 11 digits." maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                @endif
                    @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                
                <!-- Location -->
                <div class="form-group">
                    <label for="location" class="form-label">{{ __('Location (Iraqi Governorate)') }}&nbsp;<span style="color:red;" class="required-icon">*</span></label>
                    <select name="location" id="location" class="form-control" required>
                        <option value="" disabled selected>Select your governorate</option>
                        <option value="Baghdad">Baghdad</option>
                        <option value="Nineveh">Nineveh</option>
                        <option value="Basra">Basra</option>
                        <option value="Salah ad-Din">Salah ad-Din</option>
                        <option value="Duhok">Duhok</option>
                        <option value="Erbil">Erbil</option>
                        <option value="Sulaymaniyah">Sulaymaniyah</option>
                        <option value="Diyala">Diyala</option>
                        <option value="Wasit">Wasit</option>
                        <option value="Maysan">Maysan</option>
                        <option value="Dhi Qar">Dhi Qar</option>
                        <option value="Muthanna">Muthanna</option>
                        <option value="Babylon">Babylon</option>
                        <option value="Karbala">Karbala</option>
                        <option value="Najaf">Najaf</option>
                        <option value="Anbar">Anbar</option>
                        <option value="Diwaniyah">Diwaniyah</option>
                        <option value="Kirkuk">Kirkuk</option>
                    </select>
                    @error('location')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Payment Method -->
                <div class="form-group">
                    <label for="payment_method" class="form-label">{{ __('Payment Method') }}&nbsp;<span style="color:red;" class="required-icon">*</span></label>
                    <select name="payment_method" id="payment_method" class="form-control" required>
                        <option value="office" {{ old('payment_method') == 'office' ? 'selected' : '' }}>Office Payment</option>
                        <option value="representative" {{ old('payment_method') == 'representative' ? 'selected' : '' }}>Representative</option>
                        <option value="zain_cash" {{ old('payment_method') == 'zain_cash' ? 'selected' : '' }}>Zain Cash</option>
                        <option value="master_card" {{ old('payment_method') == 'master_card' ? 'selected' : '' }}>MasterCard</option>
                    </select>
                    @error('payment_method')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Additional Details (optional) -->
                <div class="form-group">
                    <label for="details" class="form-label">{{ __('Additional Details (Optional)') }}</label>
                    <textarea name="details" id="details" class="form-control" rows="4">{{ old('details') }}</textarea>
                </div>

                <!-- Submit Button -->
                <div class="form-group">
                    <button type="submit" class="btn-submit">{{ __('Submit Subscription') }}</button>
                </div>
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
