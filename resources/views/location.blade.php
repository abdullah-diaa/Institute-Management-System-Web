@extends('layouts.app')

@section('content')
<link href="{{ asset('css/location.css') }}" rel="stylesheet">
<div class="container">
    <div class="card shadow-sm ">
        <div class="card-header  text-white text-center">
            <h2>Our Location</h2>
            <p class="lead">Find us easily on the map below</p>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="address-info">
                        <h4>Address</h4>
                        <p>42nd St, Baghdad, Baghdad Governorate</p>
                        <div class="contact-container">
    <h4 class="contact-heading">Contact Us</h4>
    
    <div class="contact-item">
        <a href="mailto:Vox4Training@gmail.com" class="contact-link">
            <i class="fas fa-envelope contact-icon" style="    margin-right: 5px;
    color: #6f42c1; "></i>
        </a>
        <p>Email Us</p>
    </div>

    <div class="contact-item">
        <a href="https://wa.me/9647752832127" class="contact-link" target="_blank">
            <i class="fab fa-whatsapp contact-icon"></i>
        </a>
        <p>Chat with Us on WhatsApp</p>
    </div>

    <div class="more-info">
        <p>If you need all our contact info, please <a href="{{ route('contact') }}" class="contact-info-link">click here</a> for more details.</p>
    </div>
</div>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="map-container">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d13337.412002767536!2d44.4369115!3d33.3095857!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x155781645fc7d491%3A0x9ae8f41fae13c569!2zVm94IGZvciBUcmFpbmluZyDapNmI2YPYsyDZhNmE2KrYr9ix2YrYqA!5e0!3m2!1sen!2siq!4v1727790210681!5m2!1sen!2siq" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <p>We look forward to seeing you in Vox!</p>
        </div>
    </div>
</div>
@endsection
