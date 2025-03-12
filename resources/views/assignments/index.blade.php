@extends('layouts.app')

@section('content')
<link href="{{ asset('css/assignments/index.css') }}" rel="stylesheet">

@if(auth()->check() && (auth()->user()->role === 'admin' || (auth()->user()->role === 'student' )) && auth()->user()->status == '1')
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
    <div class="row justify-content-center">
        <div class="col-md-12">

            @if(auth()->user()->role === 'admin') 
          
            
            <div class="container">
                <form method="GET" action="{{ route('assignments.index') }}">
                    <div class="form-group">
                    <b>  <label for="course_id">Select Course:</label></b>  
                        <select name="course_id" id="course_id" class="form-control" onchange="this.form.submit()">
                            <option value="" {{ request('course_id') == null ? 'selected' : '' }}>All Courses</option>

                            @if($courses->isEmpty())
                                <option value="#">There are no courses available</option>
                            @else

                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->title }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        
                    </div>
                </form>
            </div>
            
            <!-- Include jQuery -->
          

@endif
           
            <div class="card">
                <div class="card-header bg-purple text-white">Assignments</div>

                <div class="card-body">
                  @if(auth()->user()->role === 'admin') 
                  



                  
                 
                            <a href="{{ route('assignments.create') }}" class="btn btn-primary  mb-3">Create New Assignment</a>
                            @if($assignments->isEmpty())

                            <p>There is no assignment yet</p>
                            @else
                            @foreach ($assignments as $assignment)
                            <div class="card mb-3">
                                <div class="d-flex align-items-center">
                                    @if ($assignment->user->profile && $assignment->user->profile->profile_picture)
                                        <img src="{{ asset('storage/' . $assignment->user->profile->profile_picture) }}" alt="{{ $assignment->user->name }}" class="profile-picture">
                                    @endif
                                    <a href="{{ route('profiles.show', $assignment->user->profile->id) }}" class="username-decoration font-weight-bold">
                                        {{ $assignment->user->name }}
                                    </a>
                                </div>
                                <div class="card-body">
                                    @if (auth()->user()->id == $assignment->user_id)
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-cog"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="{{ route('assignments.edit', $assignment->id) }}"><i class="fas fa-edit"></i> Edit</a>
                                            <form action="{{ route('assignments.destroy', $assignment->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this Assignment?')"><i class="fas fa-trash"></i> Delete</button>
                                            </form>
                                        </div>
                                    </div>

                                     @endif


                                    <h5 class="card-title">{{ $assignment->title }}</h5>
                                    <br>
                                    <h6 class="card-subtitle mb-2 text-muted"><b>Course :</b> &nbsp;
                                        
               <b><a href="{{ route('courses.show', $assignment->course->id) }}" class="username-decoration font-weight-bold">{{  $assignment->course->title }}</a></b> 

                                        <br><br>
                                        
                                     <br>
                               <b>    <p class="card-text">{{ $assignment->description }}</p>  </b>   <br>

                                    @if($assignment->file)
                                    <a href="{{ asset('storage/' . $assignment->file) }}" target="_blank" class="file-btn">
                                        <i class="fas fa-file-alt"></i> View/Download File
                                    </a>
                                @endif
                                <br>    <br>

                                    <p class="card-text">
                                        Due Date: <span style="font-weight:550;">{{ $assignment->due_date ?  $assignment->due_date->format('Y-m-d / h:i A') : 'N/A' }}</span>

                                        @if ($assignment->due_date < \Carbon\Carbon::now())
                                            <span class="text-danger">(Late)</span>
                                        @endif
                                    </p>
                                    


                                 
                                </div>
                               
                                <div class="card-footer bg-light">
                                    <div class="row justify-content-between align-items-center">
                                        <div class="col-auto w-100">
                                            <a href="{{ route('answers.index', ['assignment' => $assignment->id]) }}" class="btn btn-primary  w-100">View Answers</a>
                                        </div>
                                        
                   

   </div>
         </div>
    
      </div> 
      <br><br>
     @endforeach  
@endif


      @elseif(auth()->user()->role === 'student')



      <div class="container">
        <form method="GET" action="{{ route('assignments.index') }}">
            <div class="form-group">
              <b> <label for="course_id">Select Course:</label></b>
             

             
                <select name="course_id" id="course_id" class="form-control" onchange="this.form.submit()">
                    <option value="" {{ request('course_id') == null ? 'selected' : '' }}>All Assignments</option>
                    
                    @if($courses->isEmpty())
                        <option value="#">There are no courses available</option>
                    @else
                    @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                        {{ $course->title }}
                    </option>
                @endforeach
                
                    @endif
                </select>
            </div>
        </form>
    </div>
    
    @if($assignments->isEmpty())

    <p>There is no assignment yet</p>
    @else
      @foreach ($assignments as $assignment)

      <div class="card mb-3 shadow-sm">

        <div class="d-flex align-items-center">
            @if ($assignment->user->profile && $assignment->user->profile->profile_picture)
                <img src="{{ asset('storage/' . $assignment->user->profile->profile_picture) }}" alt="{{ $assignment->user->name }}" class="profile-picture">
            @endif
            <a href="{{ route('profiles.show', $assignment->user->profile->id) }}" class="username-decoration font-weight-bold">
                {{ $assignment->user->name }}
            </a>
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $assignment->title }}</h5>
            <br>
            <h6 class="card-subtitle mb-2 text-muted"><b>Course :</b>&nbsp;
                                        
                <b><a href="{{ route('courses.show', $assignment->course->id) }}" class="username-decoration font-weight-bold">{{  $assignment->course->title }}</a></b> 
 
             </h6>  <br><br>            <b><p class="card-text">{{ $assignment->description }}</p></b>
            <br>
          
            
            @if($assignment->file)
            <a href="{{ asset('storage/' . $assignment->file) }}" target="_blank" class="file-btn">
                <i class="fas fa-file-alt"></i> View/Download File
            </a>
        @endif
        <br><br>

            <p class="card-text">
              Due Date: <span style="font-weight:550;">{{ $assignment->due_date ?  $assignment->due_date->format('Y-m-d / h:i A') : 'N/A' }}</span>
                @if ($assignment->due_date < \Carbon\Carbon::now())
                    <span class="text-danger">(Late)</span>
                @endif
            </p>


        </div>
    
        <div class="card-footer bg-light d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-upload" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-label="Upload icon">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M12 17v-11l-3 3m6 0l-3 -3" />
                    <line x1="12" y1="14" x2="12" y2="21" />
                </svg>
    
                @if($assignment->answers()->where('user_id', auth()->user()->id)->exists())
                    <div class="d-inline-flex align-items-center ms-2">
                        <p class="mb-0">Answer Uploaded</p>
                        <i class="fas fa-check-circle text-success ms-1" aria-hidden="true"></i>
                    </div>
                @else
                    <a href="{{ route('answers.create', ['assignment' => $assignment->id]) }}" class="btn btn-outline-purple btn-sm ms-2">Upload Answer</a>
                @endif
            </div>
        </div>
    </div>
    <br><br>

        

  @endforeach
@endif
      @endif

        </div>

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


@endsection