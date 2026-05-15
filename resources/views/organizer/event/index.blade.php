@extends('layouts.app')

@section('title', 'Event Saya')

@section('content')

<div class="event-page">

    {{-- BACKGROUND --}}
    <div class="bg-circle bg-circle-1"></div>
    <div class="bg-circle bg-circle-2"></div>

    <div class="container-fluid py-4 px-4 position-relative z-2">

        {{-- HEADER --}}
        <div class="topbar-modern mb-5">

            {{-- LEFT --}}
            <div>

                <h1 class="page-title">
                    Event Saya
                </h1>

                <p class="page-subtitle">
                    Kelola semua event Anda dengan tampilan modern
                </p>

            </div>

            {{-- RIGHT --}}
            <div class="topbar-actions">

                {{-- SEARCH --}}
                <form method="GET"
                      action="{{ route('organizer.events.index') }}"
                      class="search-modern">

                    <i class="fas fa-search"></i>

                    <input type="text"
                           name="search"
                           placeholder="Cari event..."
                           value="{{ request('search') }}">

                </form>

                {{-- BUTTON --}}
                <a href="{{ route('organizer.events.create') }}"
                   class="btn-create-modern">

                    <i class="fas fa-plus"></i>

                    <span>Buat Event</span>

                </a>

            </div>

        </div>

        {{-- SUCCESS --}}
        @if(session('success'))

            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
                {{ session('success') }}
            </div>

        @endif

        {{-- ERROR --}}
        @if($errors->any())

            <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">

                <ul class="mb-0 ps-3">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        {{-- STATS --}}
        <div class="row g-4 mb-5">

            {{-- TOTAL --}}
            <div class="col-md-6 col-xl-3">

                <div class="stats-modern">

                    <div class="stats-icon blue">
                        <i class="fas fa-calendar-alt"></i>
                    </div>

                    <div>

                        <small>Total Event</small>

                        <h2>{{ $events->count() }}</h2>

                    </div>

                </div>

            </div>

            {{-- BERLANGSUNG --}}
            <div class="col-md-6 col-xl-3">

                <div class="stats-modern">

                    <div class="stats-icon green">
                        <i class="fas fa-play-circle"></i>
                    </div>

                    <div>

                        <small>Berlangsung</small>

                        <h2>
                            {{ $events->where('status', 'berlangsung')->count() }}
                        </h2>

                    </div>

                </div>

            </div>

            {{-- AKAN DATANG --}}
            <div class="col-md-6 col-xl-3">

                <div class="stats-modern">

                    <div class="stats-icon yellow">
                        <i class="fas fa-clock"></i>
                    </div>

                    <div>

                        <small>Akan Datang</small>

                        <h2>
                            {{ $events->where('status', 'akan datang')->count() }}
                        </h2>

                    </div>

                </div>

            </div>

            {{-- SELESAI --}}
            <div class="col-md-6 col-xl-3">

                <div class="stats-modern">

                    <div class="stats-icon gray">
                        <i class="fas fa-check-circle"></i>
                    </div>

                    <div>

                        <small>Selesai</small>

                        <h2>
                            {{ $events->where('status', 'selesai')->count() }}
                        </h2>

                    </div>

                </div>

            </div>

        </div>

        {{-- EVENT --}}
        <div class="row g-4">

            @forelse($events as $event)

                <div class="col-md-6 col-xl-4">

                    <div class="event-card-modern">

                        {{-- IMAGE --}}
                        <div class="event-image-wrapper">

                            @if($event->poster_path)

                                <img src="{{ asset('storage/' . $event->poster_path) }}"
                                     class="event-image"
                                     alt="{{ $event->title }}">

                            @else

                                <div class="event-placeholder">

                                    <div>

                                        <div class="placeholder-icon">
                                            🎉
                                        </div>

                                        <small>
                                            Tidak ada poster
                                        </small>

                                    </div>

                                </div>

                            @endif

                            {{-- STATUS --}}
                            <div class="event-status">

                                @if($event->status == 'berlangsung')

                                    <span class="status-pill green">
                                        Berlangsung
                                    </span>

                                @elseif($event->status == 'akan datang')

                                    <span class="status-pill yellow">
                                        Akan Datang
                                    </span>

                                @else

                                    <span class="status-pill gray">
                                        Selesai
                                    </span>

                                @endif

                            </div>

                        </div>

                        {{-- BODY --}}
                        <div class="event-content">

                            {{-- TITLE --}}
                            <h4 class="event-title">
                                {{ $event->title }}
                            </h4>

                            {{-- DESC --}}
                            <p class="event-description">

                                {{ \Illuminate\Support\Str::limit($event->description ?? '-', 95) }}

                            </p>

                            {{-- INFO --}}
                            <div class="event-info-list">

                                {{-- DATE --}}
                                <div class="event-info-item">

                                    <div class="info-icon blue">
                                        <i class="fas fa-calendar"></i>
                                    </div>

                                    <div>

                                        <div class="fw-semibold">

                                            {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}

                                        </div>

                                        <small>

                                            {{ $event->start_time ? \Carbon\Carbon::parse($event->start_time)->format('H:i') : '--:--' }}

                                            -

                                            {{ $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('H:i') : '--:--' }}

                                            WIB

                                        </small>

                                    </div>

                                </div>

                                {{-- LOCATION --}}
                                <div class="event-info-item">

                                    <div class="info-icon red">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>

                                    <div>

                                        <div class="fw-semibold">
                                            {{ $event->venue }}
                                        </div>

                                        <small>
                                            Lokasi Event
                                        </small>

                                    </div>

                                </div>

                            </div>

                            {{-- ACTION --}}
                            <div class="event-actions">

                                {{-- EDIT --}}
                                <a href="{{ route('organizer.events.edit', $event->id) }}"
                                   class="btn-edit-modern">

                                    <i class="fas fa-pen"></i>

                                    Edit

                                </a>

                                {{-- DELETE --}}
                                <form action="{{ route('organizer.events.destroy', $event->id) }}"
                                      method="POST"
                                      class="w-100"
                                      onsubmit="return confirm('Yakin ingin menghapus event ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn-delete-modern">

                                        <i class="fas fa-trash"></i>

                                        Hapus

                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            @empty

                {{-- EMPTY --}}
                <div class="col-12">

                    <div class="empty-modern">

                        <div class="empty-icon">
                            📅
                        </div>

                        <h2>
                            Belum Ada Event
                        </h2>

                        <p>
                            Mulai buat event pertama Anda sekarang
                        </p>

                        <a href="{{ route('organizer.events.create') }}"
                           class="btn-create-modern mt-3">

                            <i class="fas fa-plus"></i>

                            <span>Buat Event</span>

                        </a>

                    </div>

                </div>

            @endforelse

        </div>

        {{-- PAGINATION --}}
        @if(method_exists($events, 'links'))

            <div class="mt-5 d-flex justify-content-center">

                {{ $events->links() }}

            </div>

        @endif

    </div>

</div>

<style>

body{
    background:#f4f7fb;
}

/* PAGE */
.event-page{
    position: relative;
    overflow: hidden;
}

/* BG */
.bg-circle{
    position:absolute;
    border-radius:50%;
    filter:blur(100px);
    opacity:.18;
}

.bg-circle-1{
    width:350px;
    height:350px;
    background:#3b82f6;
    top:-120px;
    left:-100px;
}

.bg-circle-2{
    width:300px;
    height:300px;
    background:#60a5fa;
    bottom:-100px;
    right:-80px;
}

/* TOPBAR */
.topbar-modern{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:20px;
}

.page-title{
    font-size:46px;
    font-weight:800;
    color:#0f172a;
}

.page-subtitle{
    color:#64748b;
}

/* ACTION */
.topbar-actions{
    display:flex;
    align-items:center;
    gap:16px;
}

/* SEARCH */
.search-modern{
    width:320px;
    height:62px;
    border-radius:20px;
    background:rgba(255,255,255,.7);
    backdrop-filter:blur(14px);
    padding:0 22px;
    display:flex;
    align-items:center;
    gap:14px;
    border:1px solid rgba(255,255,255,.4);
    box-shadow:0 10px 35px rgba(37,99,235,.08);
}

.search-modern input{
    width:100%;
    border:none;
    outline:none;
    background:transparent;
}

.search-modern i{
    color:#94a3b8;
}

/* BUTTON */
.btn-create-modern{
    height:62px;
    padding:0 28px;
    border-radius:20px;
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    color:white;
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    gap:12px;
    font-weight:600;
    box-shadow:0 14px 34px rgba(37,99,235,.25);
    transition:.35s;
}

.btn-create-modern:hover{
    transform:translateY(-4px);
    color:white;
}

/* STATS */
.stats-modern{
    background:rgba(255,255,255,.72);
    backdrop-filter:blur(16px);
    border:1px solid rgba(255,255,255,.4);
    border-radius:28px;
    padding:28px;
    display:flex;
    align-items:center;
    gap:20px;
    box-shadow:0 14px 40px rgba(15,23,42,.06);
    transition:.35s;
}

.stats-modern:hover{
    transform:translateY(-6px);
}

.stats-modern h2{
    font-size:42px;
    font-weight:800;
}

/* ICON */
.stats-icon{
    width:76px;
    height:76px;
    border-radius:24px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:28px;
}

.stats-icon.blue{
    background:rgba(59,130,246,.12);
    color:#2563eb;
}

.stats-icon.green{
    background:rgba(34,197,94,.12);
    color:#16a34a;
}

.stats-icon.yellow{
    background:rgba(245,158,11,.12);
    color:#d97706;
}

.stats-icon.gray{
    background:rgba(148,163,184,.14);
    color:#64748b;
}

/* CARD */
.event-card-modern{
    background:rgba(255,255,255,.78);
    backdrop-filter:blur(18px);
    border:1px solid rgba(255,255,255,.5);
    border-radius:34px;
    overflow:hidden;
    box-shadow:0 20px 55px rgba(15,23,42,.08);
    transition:.35s;
    height:100%;
}

.event-card-modern:hover{
    transform:translateY(-8px);
}

/* IMAGE */
.event-image-wrapper{
    height:240px;
    position:relative;
    overflow:hidden;
}

.event-image{
    width:100%;
    height:100%;
    object-fit:cover;
    transition:.5s;
}

.event-card-modern:hover .event-image{
    transform:scale(1.05);
}

/* STATUS */
.event-status{
    position:absolute;
    top:18px;
    right:18px;
}

.status-pill{
    padding:10px 18px;
    border-radius:999px;
    font-size:13px;
    font-weight:700;
    backdrop-filter:blur(12px);
}

.status-pill.green{
    background:rgba(34,197,94,.18);
    color:#16a34a;
}

.status-pill.yellow{
    background:rgba(245,158,11,.18);
    color:#d97706;
}

.status-pill.gray{
    background:rgba(148,163,184,.18);
    color:#64748b;
}

/* PLACEHOLDER */
.event-placeholder{
    width:100%;
    height:100%;
    display:flex;
    align-items:center;
    justify-content:center;
    background:linear-gradient(135deg,#eff6ff,#dbeafe);
    text-align:center;
}

.placeholder-icon{
    font-size:70px;
}

/* CONTENT */
.event-content{
    padding:28px;
}

.event-title{
    font-size:28px;
    font-weight:700;
    margin-bottom:10px;
    color:#0f172a;
}

.event-description{
    color:#64748b;
    margin-bottom:24px;
}

/* INFO */
.event-info-list{
    display:flex;
    flex-direction:column;
    gap:18px;
    margin-bottom:26px;
}

.event-info-item{
    display:flex;
    align-items:center;
    gap:14px;
}

.info-icon{
    width:48px;
    height:48px;
    border-radius:16px;
    display:flex;
    align-items:center;
    justify-content:center;
}

.info-icon.blue{
    background:rgba(59,130,246,.12);
    color:#2563eb;
}

.info-icon.red{
    background:rgba(239,68,68,.12);
    color:#dc2626;
}

/* BUTTON */
.event-actions{
    display:flex;
    gap:14px;
}

.btn-edit-modern,
.btn-delete-modern{
    height:56px;
    border-radius:18px;
    border:none;
    width:100%;
    font-weight:600;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    transition:.35s;
}

.btn-edit-modern{
    background:rgba(59,130,246,.1);
    color:#2563eb;
    text-decoration:none;
}

.btn-delete-modern{
    background:linear-gradient(135deg,#ef4444,#dc2626);
    color:white;
}

.btn-edit-modern:hover,
.btn-delete-modern:hover{
    transform:translateY(-3px);
}

/* EMPTY */
.empty-modern{
    background:rgba(255,255,255,.72);
    backdrop-filter:blur(16px);
    border-radius:34px;
    padding:90px 30px;
    text-align:center;
    box-shadow:0 20px 55px rgba(15,23,42,.08);
}

.empty-icon{
    font-size:90px;
    margin-bottom:20px;
}

/* MOBILE */
@media(max-width:992px){

    .topbar-modern{
        flex-direction:column;
        align-items:stretch;
    }

    .topbar-actions{
        flex-direction:column;
    }

    .search-modern{
        width:100%;
    }

    .btn-create-modern{
        justify-content:center;
        width:100%;
    }

    .event-actions{
        flex-direction:column;
    }

}

</style>

@endsection