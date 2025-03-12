@extends('layouts.app')

@section('content')
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />


<div class="container home-container">

    <section id="hero-section" class="mb-5 bg-purple text-white text-center d-flex justify-content-center align-items-center" style="height: 100vh; background-image: url('path/to/your/hero-image.jpg'); background-size: cover; background-position: center;">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h1 class="display-4 font-weight-bold mb-3">Welcome to Your Learning Journey</h1>
                    <p class="lead mb-4">Explore our wide range of language courses designed to enhance your skills and empower your future.</p>
                    <a href="#courses" class="btn btn-light btn-lg px-4 py-2">Browse Courses</a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Courses Section -->
    <section id="featured-courses" class="my-5">
        <h2 class="text-center mb-5">Latest Courses</h2>
        <div class="row">
            @if($courses->isNotEmpty())
                @foreach($courses as $course)
                    <div class="col-md-4 mb-4" data-aos="fade-up">
                        <div class="card shadow-lg rounded h-100">
                            <div class="card-img-wrapper">
                                @if($course->image)
                                    <img src="{{ asset('storage/' . $course->image) }}" class="card-img-top" alt="{{ $course->title }}" style="height: 200px; object-fit: cover;">
                                @else
                                    <img src="https://via.placeholder.com/350x200" class="card-img-top" alt="Default Image" style="height: 200px; object-fit: cover;">
                                @endif
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $course->title }}</h5>
                                <p class="card-text">
                                    {{ Str::limit($course->content, 100) }} <!-- Display limited content -->
                                </p>
                                <a href="{{ route('courses.show', $course->id) }}" class="btn btn-primary mt-auto">Learn More</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-center">No courses available.</p>
            @endif
        </div>

        <!-- Link to all courses -->
             <div class="text-center mt-4" data-aos="zoom-in">
            <a href="{{ route('courses.index') }}" class="btn btn-primary btn-lg">See All Courses</a>
        </div>
    </section>
    <!-- Posts Section -->
    <section id="featured-posts" class="my-5">
        <h2 class="text-center mb-5">Latest Posts</h2>
        <div class="row">
            @if($posts->isNotEmpty())
                @foreach($posts as $post)
                    <div class="col-md-4 mb-4" data-aos="fade-up">
                        <div class="card shadow-lg rounded h-100">
                            <div class="card-img-wrapper">
                                @if($post->image)
                                    <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="{{ $post->title }}" style="height: 200px; object-fit: cover;">
                                @else
                                    <img src="https://via.placeholder.com/350x200" class="card-img-top" alt="Default Image" style="height: 200px; object-fit: cover;">
                                @endif
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $post->title }}</h5>
                                <p class="card-text">
                                    {{ Str::limit($post->content, 100) }} <!-- Display limited content -->
                                </p>
                                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary mt-auto">Read More</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-center">No posts available.</p>
            @endif
        </div>

        <!-- Link to all posts -->
        <div class="text-center mt-4" data-aos="zoom-in">
            <a href="{{ route('posts.index') }}" class="btn btn-primary btn-lg">See All Posts</a>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials-section" class="mb-5">


    </section>

    <!-- Contact Section -->
    <section id="contact-section" class="mb-5">
        <!-- To be filled with contact information and form -->
    </section>

    <!-- Footer Section -->
    <section id="footer-section">
        <!-- To be filled with footer content -->
    </section>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    AOS.init({
        duration: 1000, // Animation duration
        once: true // Only animate once when the element comes into view
    });
</script>


@endsection
