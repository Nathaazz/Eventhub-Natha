{{-- resources/views/user/registration/index.blade.php --}}

@extends('layouts.user-app')

@section('title', 'Pendaftaran Saya')

@section('content')

<div class="registration-page">

    {{-- HEADER --}}
    <div class="page-header">

        <div>

            <h1 class="page-title">
                Pendaftaran Saya
            </h1>

            <p class="page-subtitle">
                Semua event yang sudah Anda daftarkan
            </p>

        </div>

    </div>

    {{-- STATS --}}
    <div class="row g-4 mb-4">

        <div class="col-lg-3 col-md-6">

            <div class="stats-card">

                <div class="stats-icon blue">

                    <i class="fas fa-clipboard-list"></i>

                </div>

                <div>

                    <div class="stats-number">

                        {{ $registrations->count() }}

                    </div>

                    <div class="stats-title">
                        Total Pendaftaran
                    </div>

                    <div class="stats-subtitle">
                        Event yang diikuti
                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="stats-card">

                <div class="stats-icon green">

                    <i class="fas fa-circle-check"></i>

                </div>

                <div>

                    <div class="stats-number">

                        {{ $registrations->where('status','approved')->count() }}

                    </div>

                    <div class="stats-title">
                        Diterima
                    </div>

                    <div class="stats-subtitle">
                        Pendaftaran diterima
                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="stats-card">

                <div class="stats-icon orange">

                    <i class="fas fa-clock"></i>

                </div>

                <div>

                    <div class="stats-number">

                        {{ $registrations->where('status','pending')->count() }}

                    </div>

                    <div class="stats-title">
                        Menunggu
                    </div>

                    <div class="stats-subtitle">
                        Menunggu konfirmasi
                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="stats-card">

                <div class="stats-icon red">

                    <i class="fas fa-circle-xmark"></i>

                </div>

                <div>

                    <div class="stats-number">

                        {{ $registrations->where('status','rejected')->count() }}

                    </div>

                    <div class="stats-title">
                        Ditolak
                    </div>

                    <div class="stats-subtitle">
                        Pendaftaran ditolak
                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- TABLE --}}
    <div class="registration-card">

        {{-- FILTER --}}
        <div class="filter-wrapper">

            <div class="search-box">

                <i class="fas fa-search"></i>

                <input type="text"
                       id="searchInput"
                       placeholder="Cari event...">

            </div>

            <div class="filter-select">

                <select id="statusFilter">

                    <option value="all">
                        Semua Status
                    </option>

                    <option value="approved">
                        Diterima
                    </option>

                    <option value="pending">
                        Menunggu
                    </option>

                    <option value="rejected">
                        Ditolak
                    </option>

                </select>

            </div>

        </div>

        {{-- TABLE --}}
        <div class="table-responsive">

            <table class="table align-middle registration-table">

                <thead>

                    <tr>

                        <th>Event</th>

                        <th>Tanggal</th>

                        <th>Lokasi</th>

                        <th>Status</th>

                        <th>Tiket</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($registrations as $registration)

                        <tr class="registration-row"
                            data-status="{{ $registration->status }}">

                            {{-- EVENT --}}
                            <td>

                                <div class="event-info">

                                    @if($registration->event->poster_path)

                                        <img src="{{ asset('storage/'.$registration->event->poster_path) }}"
                                             class="event-image">

                                    @else

                                        <img src="https://picsum.photos/200?random={{ $registration->id }}"
                                             class="event-image">

                                    @endif

                                    <div>

                                        <div class="event-title">

                                            {{ $registration->event->title }}

                                        </div>

                                        <div class="event-id">

                                            REG-{{ str_pad($registration->id, 5, '0', STR_PAD_LEFT) }}

                                        </div>

                                        <div class="event-phone">

                                            <i class="fas fa-phone"></i>

                                            {{ $registration->phone ?? '-' }}

                                        </div>

                                    </div>

                                </div>

                            </td>

                            {{-- DATE --}}
                            <td>

                                <div class="date-box">

                                    {{ \Carbon\Carbon::parse($registration->event->date)->format('d M Y') }}

                                    <br>

                                    <small>

                                        {{ $registration->event->start_time }}
                                        -
                                        {{ $registration->event->end_time }}

                                    </small>

                                </div>

                            </td>

                            {{-- LOCATION --}}
                            <td>

                                <div class="location-box">

                                    <i class="fas fa-location-dot"></i>

                                    {{ $registration->event->venue }}

                                </div>

                            </td>

                            {{-- STATUS --}}
                            <td>

                                @if($registration->status == 'approved')

                                    <span class="status-badge success">

                                        Diterima

                                    </span>

                                @elseif($registration->status == 'pending')

                                    <span class="status-badge warning">

                                        Menunggu

                                    </span>

                                @else

                                    <span class="status-badge danger">

                                        Ditolak

                                    </span>

                                @endif

                            </td>

                            {{-- TICKET --}}
                            <td>

                                @if($registration->ticket)

                                    <a href="{{ route('user.tickets.show', $registration->ticket->ticket_code) }}"
                                       class="ticket-btn">

                                        <i class="fas fa-ticket"></i>

                                        Lihat Tiket

                                    </a>

                                @else

                                    <span class="text-muted">

                                        Belum tersedia

                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5">

                                <div class="empty-state">

                                    <i class="fas fa-calendar-xmark"></i>

                                    <h3>
                                        Belum Ada Pendaftaran
                                    </h3>

                                    <p>
                                        Anda belum mendaftar event apapun
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        <div class="mt-4">

            {{ $registrations->links() }}

        </div>

    </div>

</div>

<style>

body{
    background:#f4f7fb;
}

/* PAGE */
.registration-page{

    width:100%;

    min-height:100vh;

    padding:0 20px 40px;

    margin-top:-70px;

}

/* HEADER */
.page-header{

    margin-bottom:35px;

}

.page-title{

    font-size:58px;

    font-weight:800;

    color:#0f172a;

    margin-bottom:10px;

    line-height:1.1;

}

.page-subtitle{

    color:#64748b;

    font-size:18px;

}

/* STATS */
.stats-card{

    background:white;

    border-radius:28px;

    padding:28px;

    display:flex;

    align-items:center;

    gap:22px;

    height:100%;

    box-shadow:
        0 10px 30px rgba(0,0,0,.04);

}

.stats-icon{

    width:78px;

    height:78px;

    border-radius:22px;

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

.orange{
    background:#fef3c7;
    color:#d97706;
}

.red{
    background:#fee2e2;
    color:#dc2626;
}

.stats-number{

    font-size:42px;

    font-weight:800;

    color:#0f172a;

}

.stats-title{

    font-size:20px;

    font-weight:700;

}

.stats-subtitle{

    color:#64748b;

}

/* CARD */
.registration-card{

    background:white;

    border-radius:32px;

    padding:32px;

    box-shadow:
        0 10px 30px rgba(0,0,0,.04);

}

/* FILTER */
.filter-wrapper{

    display:flex;

    justify-content:space-between;

    gap:20px;

    margin-bottom:30px;

    flex-wrap:wrap;

}

.search-box{

    position:relative;

    width:340px;

}

.search-box i{

    position:absolute;

    left:18px;

    top:18px;

    color:#94a3b8;

}

.search-box input{

    width:100%;

    height:58px;

    border-radius:18px;

    border:1px solid #e2e8f0;

    padding-left:50px;

    outline:none;

}

.filter-select select{

    height:58px;

    border-radius:18px;

    border:1px solid #e2e8f0;

    padding:0 18px;

    outline:none;

}

/* TABLE */
.registration-table thead th{

    padding:18px;

    color:#64748b;

    font-size:15px;

    font-weight:700;

}

.registration-table tbody td{

    padding:22px 18px;

    vertical-align:middle;

}

.event-info{

    display:flex;

    align-items:center;

    gap:18px;

}

.event-image{

    width:90px;

    height:90px;

    border-radius:20px;

    object-fit:cover;

}

.event-title{

    font-size:24px;

    font-weight:800;

    color:#0f172a;

}

.event-id{

    color:#64748b;

    margin-top:4px;

}

.event-phone{

    margin-top:6px;

    color:#2563eb;

    font-size:14px;

}

.location-box{

    color:#475569;

    font-weight:500;

}

.status-badge{

    padding:10px 20px;

    border-radius:999px;

    font-weight:700;

    font-size:14px;

}

.status-badge.success{

    background:#dcfce7;

    color:#16a34a;

}

.status-badge.warning{

    background:#fef3c7;

    color:#d97706;

}

.status-badge.danger{

    background:#fee2e2;

    color:#dc2626;

}

.ticket-btn{

    background:#2563eb;

    color:white;

    text-decoration:none;

    padding:12px 20px;

    border-radius:14px;

    font-weight:600;

    display:inline-flex;

    align-items:center;

    gap:10px;

}

.ticket-btn:hover{

    background:#1d4ed8;

    color:white;

}

.empty-state{

    padding:70px 20px;

    text-align:center;

}

.empty-state i{

    font-size:70px;

    color:#cbd5e1;

    margin-bottom:20px;

}

.empty-state h3{

    font-size:28px;

    font-weight:800;

}

.empty-state p{

    color:#64748b;

}

@media(max-width:992px){

    .registration-page{

        margin-top:0;

    }

    .search-box{

        width:100%;

    }

    .page-title{

        font-size:40px;

    }

}

</style>

<script>

document.addEventListener('DOMContentLoaded', function(){

    const searchInput = document.getElementById('searchInput');

    const statusFilter = document.getElementById('statusFilter');

    const rows = document.querySelectorAll('.registration-row');

    function filterTable(){

        const search = searchInput.value.toLowerCase();

        const status = statusFilter.value;

        rows.forEach(row => {

            const title = row.querySelector('.event-title')
                .innerText
                .toLowerCase();

            const rowStatus = row.dataset.status;

            const matchSearch = title.includes(search);

            const matchStatus =
                status === 'all' ||
                rowStatus === status;

            if(matchSearch && matchStatus){

                row.style.display = '';

            }else{

                row.style.display = 'none';

            }

        });

    }

    searchInput.addEventListener('keyup', filterTable);

    statusFilter.addEventListener('change', filterTable);

});

</script>

@endsection