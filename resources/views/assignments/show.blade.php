@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-purple text-white text-center">
                    <h2>{{ $course->title }}</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            @if($course->image)
                                <img src="{{ asset('storage/' . $course->image) }}" class="img-fluid rounded" alt="{{ $course->title }}">
                            @endif
                        </div>
                        <div class="col-md-8">
                            <p class="lead">{{ $course->content ? $course->content : 'No content available' }}</p>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">Price:</span>
                                    <span class="badge bg-light">
@if(isset($course->previous_price) && isset($course->price) && $course->previous_price > $course->price)
    <del class="text-muted">IQ {{ rtrim(rtrim(number_format($course->previous_price, 10, '.', ''), '0'), '.') }}</del> &nbsp; <strong class="text-danger">IQ {{ rtrim(rtrim(number_format($course->price, 10, '.', ''), '0'), '.') }}</strong> <i class="fas fa-tags text-success"></i>
@else
    <strong class="text-dark">IQ {{ isset($course->previous_price) ? rtrim(rtrim(number_format($course->previous_price, 10, '.', ''), '0'), '.') : 'N/A' }}</strong>
@endif


                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">Status:</span>
                                    <span class="badge bg-info">{{ isset($course->status) ? ($course->status ? 'Active' : 'Inactive') : 'N/A' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">Course Format:</span>
                                    <span class="badge bg-secondary">{{ $course->delivery_mode ? ucfirst($course->delivery_mode) : 'N/A' }}</span>
<li class="list-group-item d-flex justify-content-between align-items-center">
    <span class="fw-bold">Start Date:</span>
    <span class="badge bg-warning">{{ $course->start_date ? $course->start_date->format('Y-m-d') : 'N/A' }}</span>
</li>
<li class="list-group-item d-flex justify-content-between align-items-center">
    <span class="fw-bold">End Date:</span>
    <span class="badge bg-dark">{{ $course->end_date ? $course->end_date->format('Y-m-d') : 'N/A' }}</span>
</li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">Maximum Students:</span>
                                    <span class="badge bg-success">{{ $course->max_students ?? 'Unlimited' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">Author:</span>
                                    <span class="badge bg-danger">{{ $course->author->name ?? 'Unknown' }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-purple text-center">
                    <button class="btn btn-primary"><i class="fas fa-shopping-cart me-2"></i> Subscribe Now</button>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.bg-purple {
    background-color: #6a0dad !important;
}
.text-white {
    color: #fff !important;
}
.card {
    border: none;
    border-radius: 15px;
}
.card-header {
    border-radius: 15px 15px 0 0;
}
.card-footer {
    border-radius: 0 0 15px 15px;
}
.shadow {
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
}
.list-group-item {
    border: none;
}
.list-group-item span {
    white-space: nowrap;
}
.btn-primary {
    background-color: #8a3ab9;
    border-color: #8a3ab9;
}
.btn-primary:hover {
    background-color: #6a0dad;
    border-color: #6a0dad;
}
</style>
@endsection



