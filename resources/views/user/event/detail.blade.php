@extends('layouts.user-app')

@section('content')

<div class="event-detail-page">

    {{-- HEADER --}}
    <div class="event-header">

        <div>

            <h1 class="event-page-title">
                Detail Event
            </h1>

            <p class="event-page-subtitle">
                Informasi lengkap event kampus
            </p>

        </div>

        <a href="{{ route('user.events.index') }}"
           class="back-btn">

            <i class="fa-solid fa-arrow-left"></i>

            Kembali

        </a>

    </div>

    {{-- ALERT --}}
    @if(session('success'))

        <div class="alert-modern alert-success-modern">

            <i class="fa-solid fa-circle-check"></i>

            {{ session('success') }}

        </div>

    @endif

    @if(session('error'))

        <div class="alert-modern alert-danger-modern">

            <i class="fa-solid fa-circle-xmark"></i>

            {{ session('error') }}

        </div>

    @endif

    {{-- CARD --}}
    <div class="event-card">

        {{-- IMAGE --}}
        <div class="event-image-wrapper">

            @if($event->poster_path)

                <img src="{{ asset('storage/' . $event->poster_path) }}"
                     class="event-banner">

            @else

                <img src="https://picsum.photos/1400/700?random={{ $event->id }}"
                     class="event-banner">

            @endif

            <div class="image-overlay"></div>

            <div class="event-status-badge">

                {{ ucfirst($event->status) }}

            </div>

        </div>

        {{-- BODY --}}
        <div class="event-body">

            {{-- TITLE --}}
            <h2 class="event-title">

                {{ $event->title }}

            </h2>

            {{-- META --}}
            <div class="event-meta">

                <div class="meta-item">

                    <div class="meta-icon blue">

                        <i class="fa-regular fa-calendar"></i>

                    </div>

                    <div>

                        <small>Tanggal</small>

                        <strong>
                            {{ \Carbon\Carbon::parse($event->date)->format('d F Y') }}
                        </strong>

                    </div>

                </div>

                <div class="meta-item">

                    <div class="meta-icon purple">

                        <i class="fa-regular fa-clock"></i>

                    </div>

                    <div>

                        <small>Waktu</small>

                        <strong>
                            {{ $event->start_time }} - {{ $event->end_time }}
                        </strong>

                    </div>

                </div>

                <div class="meta-item">

                    <div class="meta-icon red">

                        <i class="fa-solid fa-location-dot"></i>

                    </div>

                    <div>

                        <small>Lokasi</small>

                        <strong>
                            {{ $event->venue }}
                        </strong>

                    </div>

                </div>

            </div>

            {{-- DESCRIPTION --}}
            <div class="desc-box">

                <h4>
                    Deskripsi Event
                </h4>

                <p>

                    {{ $event->description }}

                </p>

            </div>

            {{-- INFO GRID --}}
            <div class="info-grid">

                <div class="info-card">

                    <span>
                        Organizer
                    </span>

                    <strong>
                        {{ $event->organizer->name ?? 'Organizer' }}
                    </strong>

                </div>

                <div class="info-card">

                    <span>
                        Status
                    </span>

                    <strong>
                        {{ ucfirst($event->status) }}
                    </strong>

                </div>

                <div class="info-card">

                    <span>
                        Kuota
                    </span>

                    <strong>
                        {{ $event->max_participants ?? 'Unlimited' }}
                    </strong>

                </div>

                <div class="info-card">

                    <span>
                        Total Peserta
                    </span>

                    <strong>
                        {{ $event->registrations->count() }} Peserta
                    </strong>

                </div>

            </div>

            {{-- BUTTON --}}
            <div class="button-wrapper">

                @if($isJoined)

                    <button class="joined-btn"
                            disabled>

                        <i class="fa-solid fa-circle-check me-2"></i>

                        Sudah Terdaftar

                    </button>

                @else

                    <form action="{{ route('user.events.join', $event->id) }}"
                          method="POST">

                        @csrf

                        <button type="submit"
                                class="register-btn">

                            <i class="fa-solid fa-paper-plane me-2"></i>

                            Daftar Event

                        </button>

                    </form>

                @endif

            </div>

        </div>

    </div>

</div>

<style>

/* =========================
   REMOVE TOP SPACE
========================= */

.main-content{
    padding-top:25px !important;
}

/* =========================
   PAGE
========================= */

.event-detail-page{
    width:100%;
}

/* =========================
   HEADER
========================= */

.event-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:28px;
}

/* =========================
   TITLE
========================= */

.event-page-title{
    font-size:52px;
    font-weight:800;
    color:#0f172a;
    margin-bottom:8px;
    line-height:1;
}

.event-page-subtitle{
    color:#64748b;
    font-size:17px;
    margin:0;
}

/* =========================
   BACK BUTTON
========================= */

.back-btn{
    display:flex;
    align-items:center;
    gap:10px;
    padding:14px 22px;
    border-radius:18px;
    text-decoration:none;
    background:white;
    color:#111827;
    font-weight:600;
    box-shadow:0 5px 20px rgba(0,0,0,.05);
    transition:.3s;
}

.back-btn:hover{
    transform:translateY(-2px);
    color:#2563eb;
}

/* =========================
   ALERT
========================= */

.alert-modern{
    padding:18px 22px;
    border-radius:20px;
    margin-bottom:24px;
    font-weight:600;
    display:flex;
    align-items:center;
    gap:12px;
}

.alert-success-modern{
    background:#dcfce7;
    color:#15803d;
}

.alert-danger-modern{
    background:#fee2e2;
    color:#dc2626;
}

/* =========================
   CARD
========================= */

.event-card{
    background:white;
    border-radius:34px;
    overflow:hidden;
    box-shadow:0 12px 40px rgba(15,23,42,.06);
}

/* =========================
   IMAGE
========================= */

.event-image-wrapper{
    position:relative;
}

.event-banner{
    width:100%;
    height:480px;
    object-fit:cover;
}

.image-overlay{
    position:absolute;
    inset:0;
    background:linear-gradient(
        to top,
        rgba(0,0,0,.45),
        transparent
    );
}

/* =========================
   STATUS
========================= */

.event-status-badge{
    position:absolute;
    top:30px;
    right:30px;
    background:rgba(255,255,255,.18);
    backdrop-filter:blur(16px);
    color:white;
    padding:12px 22px;
    border-radius:999px;
    font-weight:700;
    border:1px solid rgba(255,255,255,.18);
}

/* =========================
   BODY
========================= */

.event-body{
    padding:42px;
}

/* =========================
   EVENT TITLE
========================= */

.event-title{
    font-size:48px;
    font-weight:800;
    color:#0f172a;
    margin-bottom:35px;
}

/* =========================
   META
========================= */

.event-meta{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:22px;
    margin-bottom:40px;
}

.meta-item{
    display:flex;
    align-items:center;
    gap:16px;
    background:#f8fafc;
    border-radius:24px;
    padding:20px;
}

.meta-item small{
    display:block;
    color:#64748b;
    margin-bottom:4px;
}

.meta-item strong{
    color:#0f172a;
}

/* =========================
   ICON
========================= */

.meta-icon{
    width:58px;
    height:58px;
    border-radius:18px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:22px;
}

.blue{
    background:#dbeafe;
    color:#2563eb;
}

.purple{
    background:#ede9fe;
    color:#7c3aed;
}

.red{
    background:#fee2e2;
    color:#dc2626;
}

/* =========================
   DESC
========================= */

.desc-box{
    margin-bottom:40px;
}

.desc-box h4{
    font-size:28px;
    font-weight:700;
    margin-bottom:18px;
    color:#0f172a;
}

.desc-box p{
    color:#475569;
    line-height:2;
    font-size:17px;
}

/* =========================
   INFO GRID
========================= */

.info-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:22px;
    margin-bottom:40px;
}

.info-card{
    background:#f8fafc;
    border-radius:24px;
    padding:24px;
}

.info-card span{
    display:block;
    color:#64748b;
    margin-bottom:10px;
}

.info-card strong{
    color:#0f172a;
    font-size:18px;
}

/* =========================
   BUTTON
========================= */

.button-wrapper{
    display:flex;
    align-items:center;
    gap:16px;
}

.register-btn{
    border:none;
    height:62px;
    padding:0 34px;
    border-radius:20px;
    background:linear-gradient(
        135deg,
        #2563eb,
        #7c3aed
    );
    color:white;
    font-weight:700;
    font-size:16px;
    transition:.3s;
    box-shadow:0 10px 25px rgba(37,99,235,.25);
}

.register-btn:hover{
    transform:translateY(-3px);
}

.joined-btn{
    border:none;
    height:62px;
    padding:0 34px;
    border-radius:20px;
    background:#d1fae5;
    color:#059669;
    font-weight:700;
}

/* =========================
   MOBILE
========================= */

@media(max-width:991px){

    .main-content{
        padding-top:10px !important;
    }

    .event-header{
        flex-direction:column;
        align-items:flex-start;
        gap:20px;
    }

    .event-page-title{
        font-size:38px;
    }

    .event-title{
        font-size:34px;
    }

    .event-body{
        padding:24px;
    }

    .event-banner{
        height:260px;
    }

}

</style>

@endsection