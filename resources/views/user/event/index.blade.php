@extends('layouts.user-app')

@section('content')

@php

    $joinedCount = $events->count();

    $upcomingCount = $events->where('status', 'akan datang')->count();

    $finishedCount = $events->where('status', 'selesai')->count();

@endphp

<div class="main-content-wrapper">

    {{-- HEADER --}}
    <div class="topbar">

        <div>

            <div class="page-title">
                Event
            </div>

            <div class="page-subtitle">
                Jelajahi event kampus terbaik untuk Anda
            </div>

        </div>

    </div>

    {{-- STATS --}}
    <div class="row g-4 mb-4">

        <div class="col-xl-4 col-md-6">

            <div class="stats-card">

                <div class="stats-icon blue">

                    <i class="fa-solid fa-calendar"></i>

                </div>

                <div>

                    <div class="stats-number">
                        {{ $joinedCount }}
                    </div>

                    <div class="stats-title">
                        Event Diikuti
                    </div>

                    <div class="stats-subtitle">
                        Total event aktif
                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-4 col-md-6">

            <div class="stats-card">

                <div class="stats-icon green">

                    <i class="fa-regular fa-calendar-check"></i>

                </div>

                <div>

                    <div class="stats-number">
                        {{ $upcomingCount }}
                    </div>

                    <div class="stats-title">
                        Event Mendatang
                    </div>

                    <div class="stats-subtitle">
                        Akan berlangsung
                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-4 col-md-6">

            <div class="stats-card">

                <div class="stats-icon purple">

                    <i class="fa-solid fa-calendar-check"></i>

                </div>

                <div>

                    <div class="stats-number">
                        {{ $finishedCount }}
                    </div>

                    <div class="stats-title">
                        Event Selesai
                    </div>

                    <div class="stats-subtitle">
                        Telah berlangsung
                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- EVENT CONTAINER --}}
    <div class="event-container">

        {{-- SEARCH --}}
        <form method="GET"
              action="{{ route('user.events.index') }}">

            <div class="search-filter">

                <div class="search-box">

                    <i class="fa-solid fa-magnifying-glass"></i>

                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari event...">

                </div>

                <div class="filter-select">

                    <select name="status"
                            onchange="this.form.submit()">

                        <option value="">
                            Semua Status
                        </option>

                        <option value="berlangsung"
                            {{ request('status') == 'berlangsung' ? 'selected' : '' }}>
                            Berlangsung
                        </option>

                        <option value="akan datang"
                            {{ request('status') == 'akan datang' ? 'selected' : '' }}>
                            Akan Datang
                        </option>

                        <option value="selesai"
                            {{ request('status') == 'selesai' ? 'selected' : '' }}>
                            Selesai
                        </option>

                    </select>

                </div>

            </div>

        </form>

        {{-- EVENT LIST --}}
        @forelse($events as $event)

            <a href="{{ route('user.events.detail', $event->id) }}"
               class="event-item">

                <div class="event-left">

                    @if($event->poster_path)

                        <img src="{{ asset('storage/' . $event->poster_path) }}"
                             class="event-image">

                    @else

                        <img src="https://picsum.photos/200?random={{ $event->id }}"
                             class="event-image">

                    @endif

                    <div>

                        <div class="event-title-item">

                            {{ $event->title }}

                        </div>

                        <div class="event-info">

                            <div>

                                <i class="fa-regular fa-calendar"></i>

                                {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}

                            </div>

                            <div>

                                <i class="fa-regular fa-clock"></i>

                                {{ $event->start_time }}

                            </div>

                        </div>

                        <div class="event-location">

                            <i class="fa-solid fa-location-dot"></i>

                            {{ $event->venue }}

                        </div>

                    </div>

                </div>

                <div class="d-flex align-items-center gap-4">

                    @if($event->status == 'berlangsung')

                        <div class="badge-status badge-success">
                            Berlangsung
                        </div>

                    @elseif($event->status == 'akan datang')

                        <div class="badge-status badge-warning">
                            Akan Datang
                        </div>

                    @else

                        <div class="badge-status badge-secondary">
                            Selesai
                        </div>

                    @endif

                    <div class="arrow-btn">

                        <i class="fa-solid fa-chevron-right"></i>

                    </div>

                </div>

            </a>

        @empty

            <div class="empty-event">

                <i class="fa-regular fa-calendar-xmark"></i>

                <h4>
                    Belum Ada Event
                </h4>

                <p>
                    Anda belum mengikuti event apapun
                </p>

            </div>

        @endforelse

    </div>

</div>

<style>

/* =========================
   REMOVE EMPTY TOP SPACE
========================= */

.main-content{
    padding-top:40px !important;
}

/* =========================
   WRAPPER
========================= */

.main-content-wrapper{
    width:100%;
    padding:0;
    margin:0;
}

/* =========================
   TOPBAR
========================= */

.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:35px;
}

/* =========================
   TITLE
========================= */

.page-title{
    font-size:52px;
    font-weight:800;
    line-height:1;
    color:#111827;
}

.page-subtitle{
    margin-top:10px;
    color:#6b7280;
    font-size:17px;
}

/* =========================
   STATS
========================= */

.stats-card{
    background:white;
    border-radius:26px;
    padding:28px;
    display:flex;
    align-items:center;
    gap:22px;
    box-shadow:0 8px 25px rgba(0,0,0,.04);
    transition:.3s;
    height:100%;
}

.stats-card:hover{
    transform:translateY(-4px);
}

/* =========================
   ICON
========================= */

.stats-icon{
    width:78px;
    height:78px;
    border-radius:24px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:30px;
}

.blue{
    background:#dbeafe;
    color:#2563eb;
}

.green{
    background:#dcfce7;
    color:#16a34a;
}

.purple{
    background:#f3e8ff;
    color:#9333ea;
}

/* =========================
   STATS TEXT
========================= */

.stats-number{
    font-size:52px;
    font-weight:800;
    line-height:1;
}

.stats-title{
    font-size:24px;
    font-weight:700;
}

.stats-subtitle{
    color:#6b7280;
}

/* =========================
   EVENT CONTAINER
========================= */

.event-container{
    background:white;
    border-radius:28px;
    padding:28px;
    box-shadow:0 8px 25px rgba(0,0,0,.04);
}

/* =========================
   SEARCH
========================= */

.search-filter{
    display:flex;
    justify-content:space-between;
    gap:20px;
    margin-bottom:28px;
}

.search-box{
    width:340px;
    position:relative;
}

.search-box input{
    width:100%;
    height:60px;
    border-radius:18px;
    border:1px solid #e5e7eb;
    padding-left:52px;
    outline:none;
}

.search-box i{
    position:absolute;
    left:18px;
    top:20px;
    color:#6b7280;
}

.filter-select{
    width:230px;
}

.filter-select select{
    width:100%;
    height:60px;
    border-radius:18px;
    border:1px solid #e5e7eb;
    padding:0 18px;
    outline:none;
}

/* =========================
   EVENT ITEM
========================= */

.event-item{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:22px;
    border-radius:26px;
    border:1px solid #f1f5f9;
    margin-bottom:20px;
    text-decoration:none;
    color:black;
    transition:.3s;
}

.event-item:hover{
    transform:translateY(-3px);
    box-shadow:0 10px 25px rgba(0,0,0,.05);
    color:black;
}

.event-left{
    display:flex;
    align-items:center;
    gap:22px;
}

.event-image{
    width:110px;
    height:110px;
    border-radius:20px;
    object-fit:cover;
}

.event-title-item{
    font-size:36px;
    font-weight:800;
    line-height:1.1;
}

.event-info{
    display:flex;
    gap:20px;
    margin:12px 0;
    color:#6b7280;
}

.event-location{
    color:#4b5563;
}

/* =========================
   BADGE
========================= */

.badge-status{
    padding:10px 18px;
    border-radius:999px;
    font-size:14px;
    font-weight:700;
}

.badge-success{
    background:#dcfce7;
    color:#16a34a;
}

.badge-warning{
    background:#fef3c7;
    color:#ca8a04;
}

.badge-secondary{
    background:#e5e7eb;
    color:#374151;
}

/* =========================
   ARROW
========================= */

.arrow-btn{
    width:54px;
    height:54px;
    border-radius:50%;
    background:#f3f4f6;
    display:flex;
    align-items:center;
    justify-content:center;
}

/* =========================
   EMPTY
========================= */

.empty-event{
    padding:80px 20px;
    text-align:center;
}

.empty-event i{
    font-size:70px;
    color:#9ca3af;
    margin-bottom:20px;
}

.empty-event h4{
    font-weight:700;
}

.empty-event p{
    color:#6b7280;
}

/* =========================
   MOBILE
========================= */

@media(max-width:991px){

    .main-content{
        padding-top:20px !important;
    }

    .topbar{
        flex-direction:column;
        align-items:flex-start;
        gap:20px;
    }

    .search-filter{
        flex-direction:column;
    }

    .search-box,
    .filter-select{
        width:100%;
    }

    .event-item{
        flex-direction:column;
        align-items:flex-start;
        gap:20px;
    }

    .event-left{
        flex-direction:column;
        align-items:flex-start;
    }

    .event-title-item{
        font-size:28px;
    }

}

</style>

@endsection