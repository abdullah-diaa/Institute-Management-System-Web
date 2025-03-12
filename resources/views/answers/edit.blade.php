@extends('layouts.app')

@section('content')
<link href="{{ asset('css/posts/create.css') }}" rel="stylesheet">
@if(auth()->check() && auth()->user()->role === 'admin')
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
            <div class="card-header">{{ __('Edit Course') }}</div>

            <div class="card-body">
                <form action="{{ route('courses.update', $course->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="published_by" value="{{ auth()->id() }}">

                    <div class="form-group">
                        <label class="form-label" for="title">{{ __('Title') }}&nbsp;<span style="color:red;" class="required-icon">*</span></label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ $course->title }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="content">{{ __('Content') }}&nbsp;<span style="color:red;" class="required-icon">*</span></label>
                        <textarea name="content" id="content" class="form-control" rows="6" required>{{ $course->content }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="author_id">{{ __('Author') }}&nbsp;<span style="color:red;" class="required-icon">*</span></label>
                        <select name="author_id" id="author_id" class="form-control" required>
                            <option value="">Select Author</option>
                            @foreach($admins as $admin)
                                <option value="{{ $admin->id }}" {{ $admin->id == $course->author_id ? 'selected' : '' }}>{{ $admin->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="previous_price">{{ __('Previous Price') }}&nbsp;<span style="color:red;" class="required-icon">*</span></label>
                        <input type="number" name="previous_price" id="previous_price" class="form-control" value="{{ $course->previous_price }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="price">{{ __('Price') }}&nbsp;<span style="color:red;" class="required-icon">*</span></label>
                        <input type="number" name="price" id="price" class="form-control" value="{{ $course->price }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="status">{{ __('Status') }}</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1" {{ $course->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $course->status == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="delivery_mode">{{ __('Course Format') }}</label>
                        <select name="delivery_mode" id="delivery_mode" class="form-control">
                            <option value="present" {{ $course->delivery_mode == 'present' ? 'selected' : '' }}>Present</option>
                            <option value="online" {{ $course->delivery_mode == 'online' ? 'selected' : '' }}>Online</option>
                        </select>
                    </div>
<div class="mb-3">
    <label for="start_date" class="form-label">Start Date</label>
    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $course->start_date ? $course->start_date->format('Y-m-d') : '' }}">
</div>
<div class="mb-3">
    <label for="end_date" class="form-label">End Date</label>
    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $course->end_date ? $course->end_date->format('Y-m-d') : '' }}">
</div>


                 
                    <div class="form-group">
                        <label class="form-label" for="max_students">{{ __('Max Students') }}</label>
                        <input type="number" name="max_students" id="max_students" class="form-control" value="{{ $course->max_students }}">
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-md-right form-label" for="image">{{ __('Image') }}&nbsp;<span style="color:red;" class="required-icon">*</span></label>
                        <div class="col-md-9">
                            <div class="input-file-wrapper">
                                <input type="file" name="image" id="image" class="form-control">
                                <button type="button" class="form-control custom-file-button">
                                    <i class="fas fa-upload"></i> {{ __('Choose File') }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">{{ __('Update Course') }}</button>
                </form>
            </div>
        </div>
    </div>
@else
    <div class="container">
        <div class="card">
            <div class="card-header bg-purple">{{ __('Page Not Found') }}</div>

            <div class="card-body">
               <div class="alert"><b>{{ __('The page you are looking for does not exist.') }}</b></div>
            </div>
        </div>
    </div>

    <script>
        setTimeout(function() {
            window.location.href = "{{ route('login') }}";
        }, 3000); // Redirect after 3 seconds
    </script>
@endif
@endsection
