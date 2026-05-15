{{-- resources/views/user/dashboard.blade.php --}}

@php
use Illuminate\Support\Facades\Auth;
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Peserta - EventHub</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>

        *{
            font-family: 'Poppins', sans-serif;
        }

        body{
            background: #f4f6fb;
            margin: 0;
        }

        .sidebar{
            width: 260px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: linear-gradient(180deg,#2563eb,#7c3aed);
            padding: 25px 20px;
            color: white;
        }

        .logo{
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 40px;
        }

        .logo span{
            color: #ffd700;
        }

        .menu-title{
            font-size: 13px;
            opacity: .7;
            margin-bottom: 10px;
        }

        .menu a{
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 18px;
            text-decoration: none;
            color: white;
            border-radius: 14px;
            margin-bottom: 10px;
            transition: .3s;
            font-weight: 500;
        }

        .menu a:hover,
        .menu a.active{
            background: rgba(255,255,255,0.18);
        }

        .menu a i{
            width: 20px;
        }

        .logout{
            position: absolute;
            bottom: 30px;
            width: 85%;
        }

        .main{
            margin-left: 260px;
            padding: 30px;
        }

        .topbar{
            background: linear-gradient(90deg,#2563eb,#7c3aed);
            padding: 18px 30px;
            border-radius: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            margin-bottom: 30px;
        }

        .profile{
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .profile img{
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid white;
        }

        .card-box{
            background: white;
            border-radius: 20px;
            padding: 22px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            height: 100%;
        }

        .icon-box{
            width: 60px;
            height: 60px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
            margin-bottom: 15px;
        }

        .blue{
            background: #dbeafe;
            color: #2563eb;
        }

        .green{
            background: #dcfce7;
            color: #16a34a;
        }

        .orange{
            background: #ffedd5;
            color: #ea580c;
        }

        .purple{
            background: #f3e8ff;
            color: #9333ea;
        }

        .stat-number{
            font-size: 35px;
            font-weight: 700;
        }

        .section-card{
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            margin-top: 25px;
        }

        .section-title{
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .event-item{
            display: flex;
            gap: 15px;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .event-item:last-child{
            border-bottom: none;
        }

        .event-image{
            width: 70px;
            height: 70px;
            border-radius: 12px;
            object-fit: cover;
        }

        .event-title{
            font-weight: 600;
            font-size: 17px;
        }

        .event-info{
            color: #666;
            font-size: 14px;
        }

        .badge-status{
            padding: 8px 14px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
        }

        .bg-success-soft{
            background: #dcfce7;
            color: #16a34a;
        }

        .bg-warning-soft{
            background: #fef3c7;
            color: #ca8a04;
        }

        .bg-secondary-soft{
            background: #e5e7eb;
            color: #6b7280;
        }

        .ticket-card{
            border: 1px solid #eee;
            border-radius: 18px;
            padding: 18px;
            margin-bottom: 18px;
            transition: .3s;
        }

        .ticket-card:hover{
            transform: translateY(-3px);
        }

        .ticket-title{
            font-weight: 600;
            font-size: 17px;
        }

        .event-coming{
            border: 1px solid #eee;
            border-radius: 18px;
            padding: 18px;
            transition: .3s;
        }

        .event-coming:hover{
            transform: translateY(-5px);
        }

        @media(max-width:991px){

            .sidebar{
                width: 100%;
                height: auto;
                position: relative;
            }

            .main{
                margin-left: 0;
            }

            .logout{
                position: relative;
                bottom: 0;
                width: 100%;
                margin-top: 20px;
            }
        }

    </style>
</head>
<body>

<div class="sidebar">

    <div class="logo">
        <i class="fa-solid fa-calendar-days"></i> EventHub <span>Kampus</span>
    </div>

    <div class="menu-title">MENU PESERTA</div>

    <div class="menu">

        <a href="/user/dashboard" class="active">
            <i class="fa-solid fa-house"></i>
            Dashboard
        </a>

        <a href="/user/events">
            <i class="fa-solid fa-calendar"></i>
            Event
        </a>

        <a href="#">
            <i class="fa-solid fa-file-signature"></i>
            Pendaftaran Saya
        </a>

        <a href="#">
            <i class="fa-solid fa-ticket"></i>
            Tiket Saya
        </a>

        <a href="#">
            <i class="fa-solid fa-award"></i>
            Sertifikat Saya
        </a>

        <a href="#">
            <i class="fa-solid fa-user"></i>
            Profil
        </a>

        <a href="#">
            <i class="fa-solid fa-gear"></i>
            Pengaturan
        </a>
    </div>

    <div class="logout">
        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit" class="btn btn-light w-100 rounded-pill fw-semibold">
                <i class="fa-solid fa-right-from-bracket"></i>
                Logout
            </button>
        </form>
    </div>

</div>

<div class="main">

    {{-- TOPBAR --}}
    <div class="topbar">

        <div>
            <h3 class="fw-bold mb-1">Dashboard Peserta</h3>
            <small>Selamat datang di EventHub Kampus</small>
        </div>

        <div class="profile">

            @if(Auth::user()->photo ?? false)
                <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="">
            @else
                <img src="https://i.pravatar.cc/100?u={{ Auth::user()->id }}" alt="">
            @endif

            <div>
                <div class="fw-bold">
                    {{ Auth::user()->name }}
                </div>

                <small>
                    {{ ucfirst(Auth::user()->role ?? 'Peserta') }}
                </small>
            </div>

        </div>

    </div>

    {{-- STATISTIK --}}
    <div class="row g-4">

        <div class="col-md-3">
            <div class="card-box">

                <div class="icon-box blue">
                    <i class="fa-solid fa-calendar"></i>
                </div>

                <div class="stat-number">4</div>
                <div class="fw-semibold">Event Diikuti</div>
                <small class="text-muted">Total event aktif</small>

            </div>
        </div>

        <div class="col-md-3">
            <div class="card-box">

                <div class="icon-box green">
                    <i class="fa-solid fa-ticket"></i>
                </div>

                <div class="stat-number">4</div>
                <div class="fw-semibold">Tiket Saya</div>
                <small class="text-muted">Tiket dimiliki</small>

            </div>
        </div>

        <div class="col-md-3">
            <div class="card-box">

                <div class="icon-box orange">
                    <i class="fa-solid fa-award"></i>
                </div>

                <div class="stat-number">2</div>
                <div class="fw-semibold">Sertifikat Saya</div>
                <small class="text-muted">Sertifikat diperoleh</small>

            </div>
        </div>

        <div class="col-md-3">
            <div class="card-box">

                <div class="icon-box purple">
                    <i class="fa-solid fa-star"></i>
                </div>

                <div class="stat-number">250</div>
                <div class="fw-semibold">Poin Saya</div>
                <small class="text-muted">Total poin</small>

            </div>
        </div>

    </div>

    {{-- CONTENT --}}
    <div class="row mt-4">

        {{-- EVENT SAYA --}}
        <div class="col-lg-7">

            <div class="section-card">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="section-title mb-0">Event Saya</div>

                    <a href="/user/events" class="text-decoration-none fw-semibold">
                        Lihat Semua
                    </a>
                </div>

                {{-- ITEM --}}
                <div class="event-item">

                    <img src="https://picsum.photos/100/100?1" class="event-image">

                    <div class="flex-grow-1">
                        <div class="event-title">
                            Seminar Digital Marketing
                        </div>

                        <div class="event-info">
                            20 Mei 2026 • Aula Kampus
                        </div>
                    </div>

                    <span class="badge-status bg-success-soft">
                        Berlangsung
                    </span>

                </div>

                <div class="event-item">

                    <img src="https://picsum.photos/100/100?2" class="event-image">

                    <div class="flex-grow-1">
                        <div class="event-title">
                            Workshop UI/UX Design
                        </div>

                        <div class="event-info">
                            25 Mei 2026 • Lab Komputer
                        </div>
                    </div>

                    <span class="badge-status bg-warning-soft">
                        Akan Datang
                    </span>

                </div>

                <div class="event-item">

                    <img src="https://picsum.photos/100/100?3" class="event-image">

                    <div class="flex-grow-1">
                        <div class="event-title">
                            Webinar Artificial Intelligence
                        </div>

                        <div class="event-info">
                            10 Juni 2026 • Zoom Meeting
                        </div>
                    </div>

                    <span class="badge-status bg-secondary-soft">
                        Selesai
                    </span>

                </div>

            </div>

        </div>

        {{-- TIKET --}}
        <div class="col-lg-5">

            <div class="section-card">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="section-title mb-0">Tiket Saya</div>

                    <a href="#" class="text-decoration-none fw-semibold">
                        Lihat Semua
                    </a>
                </div>

                <div class="ticket-card">

                    <div class="ticket-title">
                        Seminar Digital Marketing
                    </div>

                    <small class="text-muted">
                        EVH-2026-00123
                    </small>

                    <div class="mt-2">
                        <span class="badge bg-success">
                            Aktif
                        </span>
                    </div>

                </div>

                <div class="ticket-card">

                    <div class="ticket-title">
                        Workshop UI/UX Design
                    </div>

                    <small class="text-muted">
                        EVH-2026-00456
                    </small>

                    <div class="mt-2">
                        <span class="badge bg-primary">
                            Digunakan
                        </span>
                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- EVENT MENDATANG --}}
    <div class="section-card">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div class="section-title mb-0">
                Event Mendatang
            </div>

            <a href="#" class="text-decoration-none fw-semibold">
                Lihat Semua
            </a>

        </div>

        <div class="row g-4">

            <div class="col-md-4">

                <div class="event-coming">

                    <div class="d-flex align-items-center gap-3 mb-3">

                        <div class="icon-box blue m-0" style="width:55px;height:55px;">
                            <i class="fa-solid fa-calendar"></i>
                        </div>

                        <div>
                            <div class="fw-semibold">
                                Workshop UI/UX
                            </div>

                            <small class="text-muted">
                                25 Mei 2026
                            </small>
                        </div>

                    </div>

                    <div class="text-muted small">
                        Lab Komputer 2
                    </div>

                    <div class="mt-3">
                        <span class="badge bg-primary">
                            80 Peserta
                        </span>
                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="event-coming">

                    <div class="d-flex align-items-center gap-3 mb-3">

                        <div class="icon-box purple m-0" style="width:55px;height:55px;">
                            <i class="fa-solid fa-microphone"></i>
                        </div>

                        <div>
                            <div class="fw-semibold">
                                Talkshow Karir
                            </div>

                            <small class="text-muted">
                                30 Mei 2026
                            </small>
                        </div>

                    </div>

                    <div class="text-muted small">
                        Aula Kampus
                    </div>

                    <div class="mt-3">
                        <span class="badge bg-success">
                            150 Peserta
                        </span>
                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="event-coming">

                    <div class="d-flex align-items-center gap-3 mb-3">

                        <div class="icon-box orange m-0" style="width:55px;height:55px;">
                            <i class="fa-solid fa-users"></i>
                        </div>

                        <div>
                            <div class="fw-semibold">
                                Public Speaking
                            </div>

                            <small class="text-muted">
                                15 Juni 2026
                            </small>
                        </div>

                    </div>

                    <div class="text-muted small">
                        Ruang Seminar
                    </div>

                    <div class="mt-3">
                        <span class="badge bg-warning text-dark">
                            90 Peserta
                        </span>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>