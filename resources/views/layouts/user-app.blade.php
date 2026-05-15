<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>
        @yield('title', 'EventHub Kampus') - {{ config('app.name') }}
    </title>

    {{-- BOOTSTRAP --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
          rel="stylesheet">

    {{-- FONT AWESOME --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
          rel="stylesheet">

    {{-- GOOGLE FONT --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        html,
        body{
            width:100%;
            min-height:100%;
            overflow-x:hidden;
        }

        body{
            font-family:'Poppins',sans-serif;
            background:#f5f7fb;
        }

        a{
            text-decoration:none;
        }

        ul{
            margin:0;
            padding:0;
            list-style:none;
        }

        /* =========================
           LAYOUT
        ========================= */

        .app-layout{
            display:flex;
            width:100%;
            min-height:100vh;
        }

        /* =========================
           MAIN CONTENT
        ========================= */

        .main-wrapper{
            flex:1;
            width:100%;
            min-height:100vh;
            transition:.3s ease;
        }

        /* =========================
           CONTENT AREA
        ========================= */

        .main-content{
            width:100%;
            min-height:100vh;
            padding:130px 30px 30px;
        }

        /* =========================
           REMOVE BOOTSTRAP CONTAINER LIMIT
        ========================= */

        .main-content .container,
        .main-content .container-fluid{
            max-width:100% !important;
            padding-left:0 !important;
            padding-right:0 !important;
            margin-left:0 !important;
            margin-right:0 !important;
        }

        /* =========================
           CARD
        ========================= */

        .card{
            border:none;
            border-radius:24px;
            box-shadow:
                0 8px 30px rgba(0,0,0,.05);
        }

        /* =========================
           HOVER
        ========================= */

        .hover-shadow{
            transition:.25s ease;
        }

        .hover-shadow:hover{
            transform:translateY(-4px);
        }

        /* =========================
           GRADIENT
        ========================= */

        .bg-gradient-primary{
            background:
                linear-gradient(
                    135deg,
                    #667eea 0%,
                    #764ba2 100%
                ) !important;
        }

        /* =========================
           NAVBAR BRAND
        ========================= */

        .navbar-brand{
            font-weight:700;
            font-size:1.4rem;
        }

        /* =========================
           IMAGE
        ========================= */

        img{
            max-width:100%;
            display:block;
        }

        /* =========================
           MOBILE
        ========================= */

        @media(max-width:992px){

            .app-layout{
                flex-direction:column;
            }

            .main-content{
                padding:110px 20px 20px;
            }

        }

    </style>

    @stack('styles')

</head>

<body>

{{-- NAVBAR --}}
@if (!request()->routeIs('login') && !request()->routeIs('register'))

    @include('layouts.navbar')

@endif

<div class="app-layout">

    {{-- SIDEBAR --}}
    @if(auth()->check())

        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'organizer')

            @include('layouts.sidebar')

        @elseif(auth()->user()->role === 'user')

            @include('layouts.user-sidebar')

        @endif

    @endif

    {{-- MAIN --}}
    <div class="main-wrapper">

        <main class="main-content">

            @yield('content')

        </main>

    </div>

</div>

{{-- BOOTSTRAP JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>