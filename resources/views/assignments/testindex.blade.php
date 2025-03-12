@extends('layouts.app')

@section('content')
<link href="{{ asset('css/assignments/index.css') }}" rel="stylesheet">

@if(auth()->check() && ( auth()->user()->role === 'admin' || (auth()->user()->role === 'student' && auth()->user()->member == '1' )) && auth()->user()->status == '1')
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

@foreach ($assignments as $assignment)
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header bg-purple text-white">Assignments</div>

                    <div class="card-body">
                      @if(auth()->user()->role === 'admin')
                                <a href="{{ route('assignments.create') }}" class="btn btn-primary bg-purple mb-3">Create New Assignment</a>
@endif



                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $assignment->title }}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Course: {{ $assignment->course->title }}</h6>
                                    <p class="card-text">{{ $assignment->description }}</p>
                                    <p class="card-text">Due Date: {{ $assignment->due_date }}</p>
                                    <p class="card-text">Posted By: {{ $assignment->user->name }}</p>
                                </div>
                                <div class="card-footer bg-light">
                                    <div class="row justify-content-between align-items-center">
                                        <div class="col-auto">
                               
                             
                             
                             
            
                             
                          
    @if(auth()->user()->role === 'admin')
    <a href="{{ route('answers.index', ['assignment' => $assignment->id]) }}" class="btn btn-primary bg-purple">View Answers</a>
@elseif(auth()->user()->role == 'student')
                @if($assignment->answers()->where('user_id', auth()->user()->id)->exists())
     <p class="text-success d-inline-block">Answer Uploaded</p> &nbsp
    <i class="fas fa-check-circle text-success"></i>
                @else
                    <a href="{{ route('answers.create', ['assignment' => $assignment->id]) }}" class="btn btn-outline-purple btn-sm">Upload Answer</a>
                @endif

@endif


       </div>
                                            @if(auth()->user()->role === 'admin')
                                     <div class="col-auto">
                        <a href="{{ route('assignments.edit', ['assignment' => $assignment->id]) }}" class="btn btn-primary btn-sm mr-2">Edit</a>
                        <form action="{{ route('assignments.destroy', ['assignment' => $assignment->id]) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this assignment?')">Delete</button>
                        </form>
                    </div>       @elseif(auth()->user()->role === 'student' &&  $assignment->isNotEmpty())
                                        <div class="col-auto">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-upload" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M12 17v-11l-3 3m6 0l-3 -3" />
                                                <path d="M12 17l-3 -3m6 3l-3 -3" />
                                                <path d="M12 17l-3 -3m6 3l-3 -3" />
                                                <line x1="12" y1="14" x2="12" y2="21" />
                                            </svg>
                                        </div>
                                      
                                    </div>
                                </div>
                            </div>
                            

                       
                    </div>
                </div>
            </div>
        </div>
    </div>
@elseif(auth()->user()->role === 'student' && auth()->user()->member == '1' && $assignment->isEmpty() && auth()->user()->status == '1')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-purple text-white">
            <h5>{{ __('Assignments') }}</h5>
        </div>

        <div class="card-body">
            <div class="alert alert-info text-center" role="alert">
                <strong>{{ __('There are no assignments available for you at the moment.') }}</strong>
            </div>
        </div>
    </div>
</div>
@else
<div class="container">
    <div class="card">
        <div class="card-header bg-purple">{{ __('Page Not Found') }}</div>

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
@endforeach
@endsection

