<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'EventHub Kampus') - {{ config('app.name') }}</title>

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>

        body{
            font-family: 'Poppins', sans-serif;
            background: #f5f7fb;
        }

        .sidebar{
            background: linear-gradient(180deg, #f8f9fa 0%, #eef2f7 100%);
        }

        .hover-shadow{
            transition: .25s ease;
        }

        .hover-shadow:hover{
            transform: translateY(-4px);
        }

        .bg-gradient-primary{
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        }

        .navbar-brand{
            font-weight: 700;
            font-size: 1.4rem;
        }

        .main-content{
            min-height: 100vh;
        }

    </style>

    @stack('styles')

</head>

<body>



{{-- NAVBAR --}}
@if (!request()->routeIs('login') && !request()->routeIs('register'))

    @include('layouts.navbar')

@endif



<div class="container-fluid py-4">

    <div class="row">



        {{-- SIDEBAR --}}
        @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'organizer']))

            @include('layouts.sidebar')

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">

        @else

            <main class="col-12 px-4 main-content">

        @endif



        {{-- CONTENT --}}
        @yield('content')



        </main>

    </div>

</div>



<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>