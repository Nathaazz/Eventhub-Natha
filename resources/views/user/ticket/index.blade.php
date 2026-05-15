@extends('layouts.user-app')

@section('content')

<div class="ticket-page">

    {{-- HEADER --}}
    <div class="page-header">

        <div>

            <h1 class="page-title">
                Tiket Saya
            </h1>

            <p class="page-subtitle">
                Kelola semua tiket event yang Anda miliki
            </p>

        </div>

    </div>

    {{-- CONTAINER --}}
    <div class="ticket-container">

        {{-- TABS --}}
        <div class="ticket-tabs">

            <div class="ticket-tab active"
                 onclick="filterTickets('all', this)">
                Semua Tiket
            </div>

            <div class="ticket-tab"
                 onclick="filterTickets('active', this)">
                Aktif
            </div>

            <div class="ticket-tab"
                 onclick="filterTickets('used', this)">
                Sudah Digunakan
            </div>

        </div>

        {{-- EMPTY --}}
        @if($tickets->count() == 0)

        <div class="empty-ticket">

            <i class="fa-solid fa-ticket"></i>

            <h3>
                Belum Ada Tiket
            </h3>

            <p>
                Anda belum memiliki tiket event
            </p>

        </div>

        @endif

        {{-- LOOP TICKETS --}}
        @foreach($tickets as $ticket)

        @php

            $event = $ticket->event;

        @endphp

        @if($event)

        <div class="ticket-item {{ $ticket->status == 'used' ? 'used' : 'active' }}">

            {{-- LEFT --}}
            <div class="ticket-left">

                <img
                    src="{{ $event->poster_path
                        ? asset('storage/' . $event->poster_path)
                        : 'https://picsum.photos/300/300?random=' . $ticket->id }}"
                    class="ticket-image">

                <div>

                    {{-- TITLE --}}
                    <div class="ticket-title">

                        {{ $event->title }}

                    </div>

                    {{-- INFO --}}
                    <div class="ticket-info">

                        <div>

                            <i class="fa-regular fa-calendar"></i>

                            {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}

                        </div>

                        @if($event->start_time && $event->end_time)

                        <div>

                            <i class="fa-regular fa-clock"></i>

                            {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}
                            -
                            {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}

                        </div>

                        @endif

                    </div>

                    {{-- LOCATION --}}
                    <div class="ticket-location">

                        <i class="fa-solid fa-location-dot"></i>

                        {{ $event->venue }}

                    </div>

                    {{-- CODE --}}
                    <div class="ticket-code">

                        {{ $ticket->ticket_code }}

                    </div>

                </div>

            </div>

            {{-- RIGHT --}}
            <div class="ticket-right">

                @if($ticket->status == 'used')

                    <div class="status-badge status-secondary">

                        Sudah Digunakan

                    </div>

                @else

                    <div class="status-badge status-success">

                        Aktif

                    </div>

                @endif

                <button class="ticket-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#ticketModal{{ $ticket->id }}">

                    <i class="fa-solid fa-ticket"></i>

                    Lihat Tiket

                </button>

            </div>

        </div>

        {{-- MODAL --}}
        <div class="modal fade"
             id="ticketModal{{ $ticket->id }}"
             tabindex="-1">

            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content">

                    {{-- HEADER --}}
                    <div class="modal-header border-0">

                        <h4 class="fw-bold">
                            Detail Tiket
                        </h4>

                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"></button>

                    </div>

                    {{-- BODY --}}
                    <div class="modal-body text-center">

                        {{-- QR --}}
                        <div class="qr-wrapper">

                            @if($ticket->qr_code_path)

                                <img
                                    src="{{ asset('storage/' . $ticket->qr_code_path) }}"
                                    class="qr-image">

                            @else

                                <div class="qr-empty">

                                    QR Tidak Tersedia

                                </div>

                            @endif

                        </div>

                        {{-- EVENT --}}
                        <h3 class="fw-bold mt-4">

                            {{ $event->title }}

                        </h3>

                        {{-- PARTICIPANT --}}
                        <p class="text-secondary">

                            {{ $ticket->registration->full_name }}

                        </p>

                        {{-- DETAIL --}}
                        <div class="ticket-detail-box">

                            <div class="detail-item">

                                <span>Kode Ticket</span>

                                <strong>

                                    {{ $ticket->ticket_code }}

                                </strong>

                            </div>

                            <div class="detail-item">

                                <span>Lokasi</span>

                                <strong>

                                    {{ $event->venue }}

                                </strong>

                            </div>

                            <div class="detail-item">

                                <span>Tanggal</span>

                                <strong>

                                    {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}

                                </strong>

                            </div>

                            <div class="detail-item">

                                <span>Status</span>

                                <strong>

                                    {{ ucfirst($ticket->status) }}

                                </strong>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        @endif

        @endforeach

    </div>

</div>

<style>

.ticket-page{

    padding:0 35px 35px;

    margin-top:-70px;

}

/* HEADER */

.page-header{

    margin-bottom:35px;

}

.page-title{

    font-size:52px;

    font-weight:800;

    color:#111827;

    margin-bottom:8px;

}

.page-subtitle{

    color:#6b7280;

    font-size:17px;

}

/* CONTAINER */

.ticket-container{

    background:white;

    border-radius:28px;

    padding:28px;

    box-shadow:
        0 8px 25px rgba(0,0,0,.04);

}

/* TABS */

.ticket-tabs{

    display:flex;

    gap:35px;

    border-bottom:1px solid #eee;

    padding-bottom:15px;

    margin-bottom:30px;

    overflow:auto;

}

.ticket-tab{

    cursor:pointer;

    font-weight:700;

    font-size:20px;

    color:#6b7280;

    padding-bottom:10px;

    transition:.3s;

    white-space:nowrap;

}

.ticket-tab.active{

    color:#2563eb;

    border-bottom:3px solid #2563eb;

}

/* ITEM */

.ticket-item{

    display:flex;

    justify-content:space-between;

    align-items:center;

    padding:22px;

    border:1px solid #eee;

    border-radius:24px;

    margin-bottom:20px;

    transition:.3s;

}

.ticket-item:hover{

    transform:translateY(-3px);

    box-shadow:
        0 5px 20px rgba(0,0,0,.05);

}

/* LEFT */

.ticket-left{

    display:flex;

    gap:20px;

    align-items:center;

}

.ticket-image{

    width:110px;
    height:110px;

    border-radius:18px;

    object-fit:cover;

}

/* TITLE */

.ticket-title{

    font-size:32px;

    font-weight:800;

    margin-bottom:12px;

}

/* INFO */

.ticket-info{

    display:flex;

    gap:20px;

    flex-wrap:wrap;

    color:#6b7280;

    margin-bottom:10px;

}

.ticket-location{

    color:#4b5563;

    margin-bottom:10px;

}

.ticket-code{

    display:inline-block;

    background:#eff6ff;

    color:#2563eb;

    padding:8px 14px;

    border-radius:12px;

    font-weight:700;

    font-size:14px;

}

/* RIGHT */

.ticket-right{

    display:flex;

    flex-direction:column;

    align-items:end;

    gap:18px;

}

/* BADGE */

.status-badge{

    padding:10px 18px;

    border-radius:30px;

    font-size:14px;

    font-weight:700;

}

.status-success{

    background:#dcfce7;

    color:#16a34a;

}

.status-secondary{

    background:#e5e7eb;

    color:#6b7280;

}

/* BUTTON */

.ticket-btn{

    border:1px solid #3b82f6;

    color:#2563eb;

    background:white;

    padding:12px 24px;

    border-radius:14px;

    font-weight:700;

    transition:.3s;

}

.ticket-btn:hover{

    background:#2563eb;

    color:white;

}

/* MODAL */

.modal-content{

    border:none;

    border-radius:26px;

}

.qr-wrapper{

    width:240px;

    height:240px;

    margin:auto;

    padding:14px;

    background:#f8fafc;

    border-radius:24px;

}

.qr-image{

    width:100%;

    height:100%;

    object-fit:contain;

}

.qr-empty{

    width:100%;

    height:100%;

    display:flex;

    align-items:center;

    justify-content:center;

    color:#94a3b8;

    font-weight:700;

}

.ticket-detail-box{

    margin-top:30px;

    display:flex;

    flex-direction:column;

    gap:16px;

}

.detail-item{

    background:#f8fafc;

    padding:16px;

    border-radius:16px;

}

.detail-item span{

    display:block;

    color:#6b7280;

    margin-bottom:4px;

}

.detail-item strong{

    color:#111827;

}

/* EMPTY */

.empty-ticket{

    text-align:center;

    padding:70px 20px;

}

.empty-ticket i{

    font-size:90px;

    color:#cbd5e1;

    margin-bottom:20px;

}

.empty-ticket h3{

    font-size:34px;

    font-weight:800;

    margin-bottom:10px;

}

.empty-ticket p{

    color:#6b7280;

}

/* MOBILE */

@media(max-width:991px){

    .ticket-page{

        padding:20px;

        margin-top:0;

    }

    .ticket-item{

        flex-direction:column;

        align-items:start;

        gap:20px;

    }

    .ticket-right{

        width:100%;

        align-items:start;

    }

    .ticket-left{

        flex-direction:column;

        align-items:start;

    }

    .ticket-title{

        font-size:26px;

    }

}

</style>

<script>

function filterTickets(type, element)
{

    let tickets =
        document.querySelectorAll('.ticket-item');

    let tabs =
        document.querySelectorAll('.ticket-tab');

    tabs.forEach(tab => {

        tab.classList.remove('active');

    });

    element.classList.add('active');

    tickets.forEach(ticket => {

        if(type === 'all'){

            ticket.style.display = 'flex';

        }
        else{

            if(ticket.classList.contains(type)){

                ticket.style.display = 'flex';

            }
            else{

                ticket.style.display = 'none';

            }

        }

    });

}

</script>

@endsection