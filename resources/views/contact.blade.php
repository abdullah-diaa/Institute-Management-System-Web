@extends('layouts.app')

@section('content')
<link href="{{ asset('css/contact.css') }}" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="container mt-5">
    <h2 class="text-center mb-4">Get in Touch  With <span>Vox</span> Team</h2>
    <p class="text-center mb-5">Click on an icon below to reach us or enjoy our social media accounts:</p>
    
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5 class="card-title text-center">Contact Information</h5>
            <div class="row text-center">
                @php
                    $contacts = [
                        ['icon' => 'fas fa-envelope', 'label' => 'Email', 'url' => 'mailto:Vox4Training@gmail.com'],
                        ['icon' => 'fab fa-instagram', 'label' => 'Instagram', 'url' => 'https://instagram.com/vox4training'],
                        ['icon' => 'fab fa-facebook', 'label' => 'Facebook', 'url' => 'https://facebook.com/vox4training'],
                        ['icon' => 'fab fa-telegram', 'label' => 'Telegram', 'url' => 'https://t.me/vox4training'],
                        ['icon' => 'fab fa-whatsapp', 'label' => 'WhatsApp', 'url' => 'https://wa.me/9647752832127'],
                        ['icon' => 'fab fa-tiktok', 'label' => 'TikTok', 'url' => 'https://tiktok.com/@miinna.ali'],
                        ['icon' => 'fab fa-youtube', 'label' => 'YouTube', 'url' => 'https://youtube.com/@-minaali1483'],
                    ];
                @endphp
                @foreach($contacts as $contact)
                <div class="col-md-4 mb-4">
                    <div class="icon-container">
                        <a href="javascript:void(0);" class="icon-button" data-toggle="modal" data-target="#{{ strtolower($contact['label']) }}Modal">
                            <i class="{{ $contact['icon'] }} fa-4x"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Modals for each contact method -->
@foreach($contacts as $contact)
<div class="modal fade" id="{{ strtolower($contact['label']) }}Modal" tabindex="-1" aria-labelledby="{{ strtolower($contact['label']) }}ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ strtolower($contact['label']) }}ModalLabel">Contact Us via {{ $contact['label'] }}</h5>
              
            </div>
            <div class="modal-body">
                <p>For more information, please visit us at:</p>
                <p><a href="{{ $contact['url'] }}" target="_blank">{{ $contact['url'] }}</a></p>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection
