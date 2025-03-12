<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


    <style>
      /* Import the font from Google Fonts */
      @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

      /* Apply the font globally to all text elements */
      body {
          font-family: 'Montserrat', sans-serif !important;
      }

      
    </style>
</head>

<body>
    <div id="app">
       

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    @include('partials.sidebar') <!-- Include the sidebar here -->
                </div>
                <div id="app">
                    @include('partials.navbar')
                <div class="col-md-12">
                    <main>
                        @yield('content')
                    </main>
                </div>
            

                </div>

                @include('partials.footer')
            </div>
        </div>
    </div>

    <script>
      setTimeout(function() {
        var notificationContainer = document.getElementById('notification-container');
        notificationContainer.style.transition = 'opacity 0.3s ease'; 
        notificationContainer.style.opacity = '0';
    }, 4000);
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <script>
        $(document).ready(function(){
            console.log("jQuery is working!");
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    @stack('scripts')

</body>
</html>
