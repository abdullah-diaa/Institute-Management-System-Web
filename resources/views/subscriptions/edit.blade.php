@extends('layouts.app')

@section('content')
<link href="{{ asset('css/subscriptions/create.css') }}" rel="stylesheet">
@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@if(auth()->check() && auth()->user()->role === 'admin' && auth()->user()->status == '1')
<div class="container">
    <div class="card">
        <div class="card-header bg-purple">{{ __('Edit Subscription for') }} {{ $subscription->course->name }}</div>

        <div class="card-body">
            <form action="{{ route('subscriptions.update', $subscription->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="phone" value="{{ $subscription->phone }}">
                <input type="hidden" name="location" value="{{ $subscription->location }}">
                <input type="hidden" name="payment_method" value="{{ $subscription->payment_method }}">
            
                <!-- Request Status -->
                <div class="form-group">
                    <label for="request_status" class="form-label">{{ __('Request Status') }}&nbsp;<span style="color:red;" class="required-icon">*</span></label>
                    <select name="request_status" id="request_status" class="form-control" required onchange="toggleNoteInput()">
                        <option value="pending" {{ $subscription->request_status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="successful" {{ $subscription->request_status == 'successful' ? 'selected' : '' }}>Successful</option>
                        <option value="failed" {{ $subscription->request_status == 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                    @error('request_status')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Approved By (Automatically filled) -->
                <div class="form-group">
                  
                    <input type="text" name="approved_by" id="approved_by" class="form-control" value="{{ auth()->user()->id }}" hidden>
                </div>

                <!-- Note (shown if 'failed' is selected) -->
                <div class="form-group" id="noteContainer" style="display: none;">
                    <label for="note">{{ __('Note for Failure Reason (Optional)') }}</label>
                    <textarea name="note" id="note" class="form-control" rows="4">{{ old('note', $subscription->note) }}</textarea>
                </div>

                <!-- Submit Button -->
                <div class="form-group">
                    <button type="submit" class="btn-submit">{{ __('Update Subscription') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@elseif (auth()->check() && auth()->user()->role === 'student' && auth()->user()->status == '1' && $subscription->user_id === auth()->user()->id && $subscription->request_status === 'pending' )




<div class="container">
    <div class="card">
        <div class="card-header bg-purple">{{ __('Edit Subscription for') }} {{ $subscription->course->name }}</div>

        <div class="card-body">
            <form action="{{ route('subscriptions.update', $subscription->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Your Name -->
                <div class="form-group">
                    <label for="name" class="form-label">{{ __('Your Name') }}&nbsp;<span style="color:red;" class="required-icon">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ auth()->user()->name }}" readonly required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Your Email -->
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
                    <input type="tel" name="phone" id="phone" class="form-control" value="{{ old('phone', $subscription->phone) }}" required pattern="\d{11}" title="Please enter exactly 11 digits." maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Location -->
                <div class="form-group">
                    <label for="location" class="form-label">{{ __('Location (Iraqi Governorate)') }}&nbsp;<span style="color:red;" class="required-icon">*</span></label>
                    <select name="location" id="location" class="form-control" required>
                        <option value="" disabled>Select your governorate</option>
                        <option value="Baghdad" {{ $subscription->location == 'Baghdad' ? 'selected' : '' }}>Baghdad</option>
                        <option value="Nineveh" {{ $subscription->location == 'Nineveh' ? 'selected' : '' }}>Nineveh</option>
                        <option value="Basra" {{ $subscription->location == 'Basra' ? 'selected' : '' }}>Basra</option>
                        <option value="Salah ad-Din" {{ $subscription->location == 'Salah ad-Din' ? 'selected' : '' }}>Salah ad-Din</option>
                        <option value="Duhok" {{ $subscription->location == 'Duhok' ? 'selected' : '' }}>Duhok</option>
                        <option value="Erbil" {{ $subscription->location == 'Erbil' ? 'selected' : '' }}>Erbil</option>
                        <option value="Sulaymaniyah" {{ $subscription->location == 'Sulaymaniyah' ? 'selected' : '' }}>Sulaymaniyah</option>
                        <option value="Diyala" {{ $subscription->location == 'Diyala' ? 'selected' : '' }}>Diyala</option>
                        <option value="Wasit" {{ $subscription->location == 'Wasit' ? 'selected' : '' }}>Wasit</option>
                        <option value="Maysan" {{ $subscription->location == 'Maysan' ? 'selected' : '' }}>Maysan</option>
                        <option value="Dhi Qar" {{ $subscription->location == 'Dhi Qar' ? 'selected' : '' }}>Dhi Qar</option>
                        <option value="Muthanna" {{ $subscription->location == 'Muthanna' ? 'selected' : '' }}>Muthanna</option>
                        <option value="Babylon" {{ $subscription->location == 'Babylon' ? 'selected' : '' }}>Babylon</option>
                        <option value="Karbala" {{ $subscription->location == 'Karbala' ? 'selected' : '' }}>Karbala</option>
                        <option value="Najaf" {{ $subscription->location == 'Najaf' ? 'selected' : '' }}>Najaf</option>
                        <option value="Anbar" {{ $subscription->location == 'Anbar' ? 'selected' : '' }}>Anbar</option>
                        <option value="Diwaniyah" {{ $subscription->location == 'Diwaniyah' ? 'selected' : '' }}>Diwaniyah</option>
                        <option value="Kirkuk" {{ $subscription->location == 'Kirkuk' ? 'selected' : '' }}>Kirkuk</option>
                    </select>
                    @error('location')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>



             
                    <input type="hidden" name="request_status" id="request_status" value="pending">
                   
                

                <!-- Payment Method -->
                <div class="form-group">
                    <label for="payment_method" class="form-label">{{ __('Payment Method') }}&nbsp;<span style="color:red;" class="required-icon">*</span></label>
                    <select name="payment_method" id="payment_method" class="form-control" required>
                        <option value="office" {{ $subscription->payment_method == 'office' ? 'selected' : '' }}>Office Payment</option>
                        <option value="representative" {{ $subscription->payment_method == 'representative' ? 'selected' : '' }}>Representative</option>
                        <option value="zain_cash" {{ $subscription->payment_method == 'zain_cash' ? 'selected' : '' }}>Zain Cash</option>
                        <option value="master_card" {{ $subscription->payment_method == 'master_card' ? 'selected' : '' }}>MasterCard</option>
                    </select>
                    @error('payment_method')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="details" class="form-label">{{ __('Additional Details (Optional)') }}</label>
                    <textarea name="details" id="details" class="form-control" rows="4">{{ old('details', $subscription->details) }}</textarea>
                    @error('details')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                </div>
                <!-- Submit Button -->
                <div class="form-group">
                    <button type="submit" class="btn-submit">{{ __('Update Subscription') }}</button>
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
<script>
    // Function to toggle visibility of the note input field
    function toggleNoteInput() {
        const statusSelect = document.getElementById('request_status');
        const noteContainer = document.getElementById('noteContainer');
        
        if (statusSelect.value === 'failed') {
            noteContainer.style.display = 'block'; // Show the note input
        } else {
            noteContainer.style.display = 'none'; // Hide the note input
        }
    }

    // Initialize the visibility based on the current status
    document.addEventListener('DOMContentLoaded', () => {
        toggleNoteInput(); // Call it on load to set the initial state
    });
</script>
@endsection
