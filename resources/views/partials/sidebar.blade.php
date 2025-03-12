<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link href="{{ asset('css/partials/sidebar.css') }}" rel="stylesheet">


<div class="sidebar closed">
    <div class="sidebar-content-container">
        <div class="sidebar-content">
            <div class="profile">

                @if(auth()->check() && auth()->user()->profile)


                <a href="{{ route('profiles.show', auth()->user()->profile->id) }}">
                    <img src="{{ asset('storage/' . auth()->user()->profile->profile_picture) }}" alt="Profile">
                </a>
            
             
           


              
                 
                @endif
                @if(auth()->check())
                <h3>{{ auth()->user()->name }}</h3> 
                @endif
            </div>

            <ul class="menu">
                <!-- Links for other components -->
                <li class="menu-item {{ request()->is('home') ? 'active' : '' }}">
                    <a href="{{ route('home') }}">
                        <i class="fas fa-tachometer-alt menu-icon"></i> Dashboard
                    </a>
                </li>

                <!-- Users -->
                <li class="menu-item {{ request()->is('users*') ? 'active' : '' }}">
                    <a href="{{ route('users.index') }}">
                        <i class="fas fa-users menu-icon"></i> Users
                    </a>
                </li>

                <!-- Profiles -->
                <li class="menu-item {{ request()->is('profiles*') ? 'active' : '' }}">
                    <a href="{{ route('profiles.index') }}">
                        <i class="fas fa-user menu-icon"></i> Profiles
                    </a>
                </li>


                <li class="menu-item {{ request()->is('courses*') ? 'active' : '' }}">
                    <a href="{{ route('courses.index') }}">
                        <i class="fas fa-book menu-icon"></i> Courses
                    </a>
                </li>

                
                <!-- Subscriptions (Sub-item under Profiles) -->
                <li class="menu-item {{ request()->is('subscriptions*') ? 'active' : '' }}">
                    <a href="{{ route('subscriptions.index') }}">
                        <i class="fas fa-list-alt menu-icon"></i> Subscriptions
                    </a>
                </li>

                <!-- Courses -->
               
              
                <!-- Assignments -->
                <li class="menu-item {{ request()->is('assignments*') ? 'active' : '' }}">
                    <a href="{{ route('assignments.index') }}">
                        <i class="fas fa-tasks menu-icon"></i> Assignments
                    </a>
                </li>


                <!-- Contact Us -->
                <li class="menu-item {{ request()->is('contact') ? 'active' : '' }}">
                    <a href="{{ route('contact') }}">
                        <i class="fas fa-envelope menu-icon"></i> Contact Us
                    </a>
                </li>

                <!-- About Us -->
                <li class="menu-item {{ request()->is('about') ? 'active' : '' }}">
                    <a href="{{ route('about') }}">
                        <i class="fas fa-info-circle menu-icon"></i> About Us
                    </a>
                </li>

                <!-- Our Location -->
                <li class="menu-item {{ request()->is('location') ? 'active' : '' }}">
                    <a href="{{ route('location') }}">
                        <i class="fas fa-map-marker-alt menu-icon"></i> Location
                    </a>
                </li>
           
                <!-- Settings -->
                <li class="menu-item {{ request()->is('settings') ? 'active' : '' }}">
                    <a href="{{ route('settings.index') }}">
                        <i class="fas fa-list menu-icon"></i> Settings
                    </a>
                </li>


                <!-- Logout -->
                <li class="menu-item">
                    <a href="#" onclick="logoutWithConfirmation()">
                        <i class="fas fa-sign-out-alt menu-icon"></i> Logout
                    </a>
                </li>
            </ul>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
    <div class="sidebar-toggle" onclick="toggleSidebar()">&#9776;</div>
</div>
<script>




    function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    
    if (sidebar.classList.contains('closed')) {
        // Open the sidebar
        sidebar.classList.remove('closed');
        sidebar.style.left = '0'; // Move sidebar to the left edge
        sidebarToggle.style.left = '250px'; // Move toggle button to the right
    } else {
        // Close the sidebar
        sidebar.classList.add('closed');
        sidebar.style.left = '-250px'; // Move sidebar off-screen to the left
        sidebarToggle.style.left = '10px'; // Move toggle button back to the left edge
    }
}


// Add event listener to the document body
document.body.addEventListener('click', function(event) {
    const sidebar = document.querySelector('.sidebar');
    const sidebarToggle = document.querySelector('.sidebar-toggle');

    // Check if the clicked element is not inside the sidebar
    if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
        // Close the sidebar if it's open
        if (!sidebar.classList.contains('closed')) {
            sidebar.classList.add('closed');
            sidebar.style.left = '-250px'; // Move sidebar off-screen to the left
            sidebarToggle.style.left = '10px'; // Move toggle button back to the left edge
        }
    }
});
    function logoutWithConfirmation() {
        if (confirm("Are you sure you want to log out?")) {
    document.getElementById('logout-form').submit();
}

    }
</script>