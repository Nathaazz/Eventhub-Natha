@extends('layouts.app')

@section('title', 'Peserta Event')

@section('content')

@php

$totalParticipants = $participants->count();

$approvedCount = $participants->where('status', 'approved')->count();

$pendingCount = $participants->where('status', 'pending')->count();

$rejectedCount = $participants->where('status', 'rejected')->count();

@endphp

<div class="participant-page">

    {{-- BACKGROUND --}}
    <div class="bg-blur bg-blur-1"></div>
    <div class="bg-blur bg-blur-2"></div>



    <div class="container-fluid py-4 position-relative z-2">

        {{-- HEADER --}}
        <div class="participant-topbar mb-5">

            <div>

                <h1 class="participant-title">

                    Peserta Event

                </h1>

                <p class="participant-subtitle">

                    Kelola peserta event dengan tampilan modern & realtime

                </p>

            </div>



            <form method="GET"
                  class="search-box">

                <i class="fas fa-search"></i>

                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari peserta...">

            </form>

        </div>



        {{-- STATS --}}
        <div class="row g-4 mb-5">

            {{-- TOTAL --}}
            <div class="col-lg-3 col-md-6">

                <div class="stats-card">

                    <div class="stats-glow blue"></div>

                    <div class="stats-icon blue">

                        <i class="fas fa-users"></i>

                    </div>

                    <div>

                        <small>Total Peserta</small>

                        <h2>{{ $totalParticipants }}</h2>

                    </div>

                </div>

            </div>



            {{-- APPROVED --}}
            <div class="col-lg-3 col-md-6">

                <div class="stats-card">

                    <div class="stats-glow green"></div>

                    <div class="stats-icon green">

                        <i class="fas fa-check-circle"></i>

                    </div>

                    <div>

                        <small>Diterima</small>

                        <h2>{{ $approvedCount }}</h2>

                    </div>

                </div>

            </div>



            {{-- PENDING --}}
            <div class="col-lg-3 col-md-6">

                <div class="stats-card">

                    <div class="stats-glow yellow"></div>

                    <div class="stats-icon yellow">

                        <i class="fas fa-clock"></i>

                    </div>

                    <div>

                        <small>Menunggu</small>

                        <h2>{{ $pendingCount }}</h2>

                    </div>

                </div>

            </div>



            {{-- REJECT --}}
            <div class="col-lg-3 col-md-6">

                <div class="stats-card">

                    <div class="stats-glow red"></div>

                    <div class="stats-icon red">

                        <i class="fas fa-times-circle"></i>

                    </div>

                    <div>

                        <small>Ditolak</small>

                        <h2>{{ $rejectedCount }}</h2>

                    </div>

                </div>

            </div>

        </div>



        {{-- TABLE --}}
        <div class="participant-table-card">

            <div class="table-header">

                <div>

                    <h4 class="fw-bold mb-1">

                        Daftar Peserta

                    </h4>

                    <small class="text-muted">

                        Semua peserta event organizer

                    </small>

                </div>

            </div>



            <div class="table-responsive">

                <table class="table align-middle participant-table mb-0">

                    <thead>

                        <tr>

                            <th>#</th>
                            <th>Peserta</th>
                            <th>Event</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Tiket</th>
                            <th class="text-center">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($participants as $participant)

                        <tr>

                            {{-- NO --}}
                            <td class="fw-semibold">

                                {{ $loop->iteration }}

                            </td>



                            {{-- USER --}}
                            <td>

                                <div class="d-flex align-items-center gap-3">

                                    @if($participant->user && $participant->user->avatar)

                                        <img src="{{ asset('storage/' . $participant->user->avatar) }}"
                                             class="participant-avatar">

                                    @else

                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($participant->user->name ?? 'User') }}"
                                             class="participant-avatar">

                                    @endif



                                    <div>

                                        <div class="fw-semibold">

                                            {{ $participant->user->name ?? '-' }}

                                        </div>

                                        <small class="text-muted">

                                            {{ $participant->user->email ?? '-' }}

                                        </small>

                                    </div>

                                </div>

                            </td>



                            {{-- EVENT --}}
                            <td>

                                <div class="event-pill">

                                    {{ $participant->event->title ?? '-' }}

                                </div>

                            </td>



                            {{-- DATE --}}
                            <td>

                                <div class="fw-semibold">

                                    {{ \Carbon\Carbon::parse($participant->created_at)->format('d M Y') }}

                                </div>

                                <small class="text-muted">

                                    {{ \Carbon\Carbon::parse($participant->created_at)->format('H:i') }} WIB

                                </small>

                            </td>



                            {{-- STATUS --}}
                            <td>

                                @if($participant->status === 'approved')

                                    <span class="status-badge approved">

                                        <i class="fas fa-check-circle"></i>
                                        Diterima

                                    </span>

                                @elseif($participant->status === 'rejected')

                                    <span class="status-badge rejected">

                                        <i class="fas fa-times-circle"></i>
                                        Ditolak

                                    </span>

                                @else

                                    <span class="status-badge pending">

                                        <i class="fas fa-clock"></i>
                                        Pending

                                    </span>

                                @endif

                            </td>



                            {{-- TICKET --}}
                            <td>

                                @if($participant->ticket)

                                    <span class="ticket-badge">

                                        <i class="fas fa-ticket-alt"></i>
                                        Tersedia

                                    </span>

                                @else

                                    <span class="ticket-empty">

                                        Belum Ada

                                    </span>

                                @endif

                            </td>



                            {{-- ACTION --}}
                            <td>

                                <div class="d-flex justify-content-center gap-2">

                                    {{-- APPROVE --}}
                                    @if($participant->status !== 'approved')

                                    <form action="{{ route('organizer.participants.approve', $participant->id) }}"
                                          method="POST">

                                        @csrf

                                        <button class="action-btn approve-btn">

                                            <i class="fas fa-check"></i>

                                        </button>

                                    </form>

                                    @endif



                                    {{-- REJECT --}}
                                    @if($participant->status !== 'rejected')

                                    <form action="{{ route('organizer.participants.reject', $participant->id) }}"
                                          method="POST">

                                        @csrf

                                        <button class="action-btn reject-btn">

                                            <i class="fas fa-times"></i>

                                        </button>

                                    </form>

                                    @endif

                                </div>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="7">

                                <div class="empty-state">

                                    <i class="fas fa-users-slash"></i>

                                    <h4>

                                        Belum Ada Peserta

                                    </h4>

                                    <p>

                                        Peserta event akan tampil di sini

                                    </p>

                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>



            {{-- FOOTER --}}
            <div class="table-footer">

                <div class="text-muted">

                    Menampilkan
                    {{ $participants->firstItem() ?? 0 }}
                    -
                    {{ $participants->lastItem() ?? 0 }}
                    dari
                    {{ $participants->total() }}
                    peserta

                </div>

                {{ $participants->links() }}

            </div>

        </div>

    </div>

</div>



<style>

.participant-page{

    position: relative;

    overflow: hidden;

}



/* BACKGROUND */
.bg-blur{

    position: absolute;

    border-radius: 50%;

    filter: blur(100px);

    opacity: .22;

}

.bg-blur-1{

    width: 420px;
    height: 420px;

    background: #3b82f6;

    top: -120px;
    left: -100px;

}

.bg-blur-2{

    width: 350px;
    height: 350px;

    background: #60a5fa;

    bottom: -100px;
    right: -80px;

}



/* HEADER */
.participant-title{

    font-size: 46px;

    font-weight: 800;

    color: #0f172a;

}

.participant-subtitle{

    color: #64748b;

    font-size: 16px;

}



/* TOPBAR */
.participant-topbar{

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 20px;

}



/* SEARCH */
.search-box{

    width: 360px;
    height: 64px;

    border-radius: 22px;

    background:
        rgba(255,255,255,.7);

    backdrop-filter:
        blur(16px);

    border:
        1px solid rgba(255,255,255,.5);

    padding: 0 24px;

    display: flex;
    align-items: center;
    gap: 14px;

    box-shadow:
        0 10px 40px rgba(37,99,235,.08);

}

.search-box i{

    color: #94a3b8;

}

.search-box input{

    width: 100%;

    border: none;
    outline: none;

    background: transparent;

}



/* STATS */
.stats-card{

    position: relative;

    overflow: hidden;

    border-radius: 32px;

    padding: 30px;

    background:
        rgba(255,255,255,.75);

    backdrop-filter:
        blur(18px);

    border:
        1px solid rgba(255,255,255,.5);

    box-shadow:
        0 14px 50px rgba(15,23,42,.06);

    display: flex;
    align-items: center;
    gap: 22px;

    transition: .4s;

}

.stats-card:hover{

    transform:
        translateY(-8px);

}



/* GLOW */
.stats-glow{

    position: absolute;

    width: 180px;
    height: 180px;

    border-radius: 50%;

    filter: blur(60px);

    opacity: .2;

    top: -80px;
    right: -80px;

}

.stats-glow.blue{
    background: #3b82f6;
}

.stats-glow.green{
    background: #22c55e;
}

.stats-glow.yellow{
    background: #f59e0b;
}

.stats-glow.red{
    background: #ef4444;
}



/* ICON */
.stats-icon{

    width: 84px;
    height: 84px;

    border-radius: 26px;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 32px;

}

.stats-icon.blue{

    background:
        rgba(59,130,246,.12);

    color:
        #2563eb;

}

.stats-icon.green{

    background:
        rgba(34,197,94,.12);

    color:
        #16a34a;

}

.stats-icon.yellow{

    background:
        rgba(245,158,11,.12);

    color:
        #d97706;

}

.stats-icon.red{

    background:
        rgba(239,68,68,.12);

    color:
        #dc2626;

}



/* TABLE CARD */
.participant-table-card{

    border-radius: 34px;

    overflow: hidden;

    background:
        rgba(255,255,255,.75);

    backdrop-filter:
        blur(18px);

    border:
        1px solid rgba(255,255,255,.5);

    box-shadow:
        0 18px 60px rgba(15,23,42,.08);

}



/* HEADER */
.table-header{

    padding: 28px 34px;

    border-bottom:
        1px solid rgba(226,232,240,.8);

}



/* TABLE */
.participant-table thead{

    background:
        rgba(248,250,252,.9);

}

.participant-table th{

    padding: 22px;

    color: #475569;

    font-size: 14px;

    border: none;

}

.participant-table td{

    padding: 22px;

    border-color:
        rgba(226,232,240,.5);

}

.participant-table tbody tr{

    transition: .35s;

}

.participant-table tbody tr:hover{

    background:
        rgba(239,246,255,.75);

}



/* AVATAR */
.participant-avatar{

    width: 58px;
    height: 58px;

    border-radius: 50%;

    object-fit: cover;

    border:
        3px solid rgba(255,255,255,.7);

    box-shadow:
        0 6px 16px rgba(15,23,42,.12);

}



/* EVENT */
.event-pill{

    display: inline-flex;

    padding: 10px 16px;

    border-radius: 999px;

    background:
        rgba(59,130,246,.12);

    color:
        #2563eb;

    font-weight: 600;

}



/* STATUS */
.status-badge{

    display: inline-flex;

    align-items: center;
    gap: 8px;

    padding: 10px 18px;

    border-radius: 999px;

    font-size: 13px;

    font-weight: 700;

}

.status-badge.approved{

    background:
        rgba(34,197,94,.12);

    color:
        #16a34a;

}

.status-badge.pending{

    background:
        rgba(245,158,11,.12);

    color:
        #d97706;

}

.status-badge.rejected{

    background:
        rgba(239,68,68,.12);

    color:
        #dc2626;

}



/* TICKET */
.ticket-badge{

    display: inline-flex;

    align-items: center;
    gap: 8px;

    background:
        rgba(59,130,246,.12);

    color:
        #2563eb;

    padding: 10px 16px;

    border-radius: 999px;

    font-weight: 600;

}

.ticket-empty{

    color: #94a3b8;

}



/* ACTION */
.action-btn{

    width: 44px;
    height: 44px;

    border: none;

    border-radius: 16px;

    transition: .35s;

    color: white;

}

.action-btn:hover{

    transform:
        translateY(-4px)
        scale(1.05);

}

.approve-btn{

    background:
        linear-gradient(
            135deg,
            #22c55e,
            #16a34a
        );

    box-shadow:
        0 10px 20px rgba(34,197,94,.25);

}

.reject-btn{

    background:
        linear-gradient(
            135deg,
            #ef4444,
            #dc2626
        );

    box-shadow:
        0 10px 20px rgba(239,68,68,.25);

}



/* EMPTY */
.empty-state{

    padding: 90px 20px;

    text-align: center;

}

.empty-state i{

    font-size: 70px;

    color: #cbd5e1;

    margin-bottom: 20px;

}



/* FOOTER */
.table-footer{

    padding: 24px 34px;

    border-top:
        1px solid rgba(226,232,240,.7);

    display: flex;
    justify-content: space-between;
    align-items: center;

}



/* MOBILE */
@media(max-width:992px){

    .participant-topbar{

        flex-direction: column;

        align-items: stretch;

    }

    .search-box{

        width: 100%;

    }

}

</style>

@endsection