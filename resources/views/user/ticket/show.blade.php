@extends('layouts.app')

@section('title', 'Tiket - ' . $ticket->ticket_code)

@php

    $event = $ticket->event;

    $registration = $ticket->registration;

@endphp

@push('styles')

<style>

.qr-container{

    background:
        linear-gradient(
            135deg,
            #f8f9ff 0%,
            #e8f4f8 100%
        );

    border:2px dashed #007bff;

}

.qr-code-wrapper{

    background:white;

    border-radius:20px;

    padding:30px;

    box-shadow:
        0 20px 40px rgba(0,123,255,0.15);

    border:4px solid #007bff;

}

.status-active{

    animation:pulse 2s infinite;

}

@keyframes pulse{

    0%{

        box-shadow:
            0 0 0 0 rgba(40,167,69,0.7);

    }

    70%{

        box-shadow:
            0 0 0 20px rgba(40,167,69,0);

    }

    100%{

        box-shadow:
            0 0 0 0 rgba(40,167,69,0);

    }

}

</style>

@endpush

@section('content')

<div class="row justify-content-center">

    <div class="col-xl-8 col-lg-10">

        {{-- MAIN CARD --}}
        <div class="card shadow-lg border-0 overflow-hidden mb-5">

            {{-- HEADER --}}
            <div class="bg-primary text-white p-5 text-center position-relative overflow-hidden">

                <div class="position-absolute top-0 end-0 p-4">

                    <span class="badge bg-light text-primary px-4 py-3 fs-6 fw-bold shadow">

                        <i class="fas fa-circle me-2 {{ $ticket->status == 'active' ? 'text-success' : 'text-secondary' }}"></i>

                        {{ ucfirst($ticket->status) }}

                    </span>

                </div>

                <div class="mb-4">

                    <i class="fas fa-ticket-alt fa-3x mb-3 opacity-75"></i>

                    <h2 class="display-5 fw-bold mb-2">

                        {{ $event ? \Illuminate\Support\Str::limit($event->title, 50) : 'Event Tidak Tersedia' }}

                    </h2>

                    <p class="lead mb-0 opacity-75">

                        {{ $event->venue ?? '-' }}

                    </p>

                </div>

            </div>

            {{-- BODY --}}
            <div class="p-5">

                {{-- QR --}}
                <div class="qr-container p-5 rounded-5 mb-5 text-center">

                    <div class="mb-5">

                        <h3 class="fw-bold text-primary mb-2">

                            <i class="fas fa-qrcode me-2"></i>

                            Scan untuk Validasi

                        </h3>

                        <p class="lead text-muted mb-0">

                            Tunjukkan QR Code ini di pintu masuk event

                        </p>

                    </div>

                    @if($ticket->qr_code_path)

                        <div class="qr-code-wrapper mb-5 {{ $ticket->status == 'active' ? 'status-active' : '' }}">

                            <img
                                src="{{ asset('storage/' . $ticket->qr_code_path) }}"
                                alt="QR Code Ticket"
                                class="img-fluid shadow rounded-4"
                                style="max-width:400px; height:auto;">

                        </div>

                        <div class="bg-white rounded-4 p-4 shadow">

                            <h5 class="fw-bold text-primary mb-3 text-center">

                                Ticket ID

                            </h5>

                            <div class="display-6 fw-bold text-center fs-3"
                                 style="letter-spacing:4px; font-family:'Courier New', monospace;">

                                {{ $ticket->ticket_code }}

                            </div>

                            <div class="text-center mt-3">

                                <small class="badge bg-success px-3 py-2">

                                    <i class="fas fa-check-circle me-1"></i>

                                    VALID

                                </small>

                            </div>

                        </div>

                    @else

                        <div class="alert alert-warning">

                            <i class="fas fa-exclamation-triangle me-2"></i>

                            QR Code belum tersedia.

                        </div>

                    @endif

                </div>

                {{-- DETAIL --}}
                <div class="row g-4 mb-5">

                    {{-- PARTICIPANT --}}
                    <div class="col-md-6">

                        <div class="card border-0 shadow-sm h-100">

                            <div class="card-header bg-light border-0">

                                <h6 class="fw-bold mb-0">

                                    <i class="fas fa-user-circle me-2 text-primary"></i>

                                    Peserta

                                </h6>

                            </div>

                            <div class="card-body">

                                <div class="h5 fw-bold mb-3">

                                    {{ $registration->full_name ?? '-' }}

                                </div>

                                <div class="mb-3">

                                    <span class="text-muted small">

                                        Email

                                    </span>

                                    <div class="fw-bold">

                                        {{ $registration->email ?? '-' }}

                                    </div>

                                </div>

                                <div class="mb-3">

                                    <span class="text-muted small">

                                        Telepon

                                    </span>

                                    <div>

                                        {{ $registration->phone ?? '-' }}

                                    </div>

                                </div>

                                @if($registration && $registration->institution)

                                    <div>

                                        <span class="text-muted small">

                                            Institusi

                                        </span>

                                        <div class="fw-bold">

                                            {{ $registration->institution }}

                                        </div>

                                    </div>

                                @endif

                            </div>

                        </div>

                    </div>

                    {{-- EVENT --}}
                    <div class="col-md-6">

                        <div class="card border-0 shadow-sm h-100">

                            <div class="card-header bg-light border-0">

                                <h6 class="fw-bold mb-0">

                                    <i class="fas fa-calendar-alt me-2 text-success"></i>

                                    Event Info

                                </h6>

                            </div>

                            <div class="card-body">

                                <div class="h5 fw-bold mb-3">

                                    {{ $event->title ?? '-' }}

                                </div>

                                @if($event)

                                <div class="mb-3">

                                    <div class="d-flex justify-content-between mb-2">

                                        <span class="text-muted">

                                            <i class="fas fa-calendar me-1"></i>

                                        </span>

                                        <span class="fw-bold">

                                            {{ \Carbon\Carbon::parse($event->date)->format('d F Y') }}

                                        </span>

                                    </div>

                                    @if($event->start_time && $event->end_time)

                                    <div class="d-flex justify-content-between">

                                        <span class="text-muted">

                                            <i class="fas fa-clock me-1"></i>

                                        </span>

                                        <span class="fw-bold">

                                            {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}
                                            -
                                            {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}

                                        </span>

                                    </div>

                                    @endif

                                </div>

                                <div class="p-3 bg-light rounded-3">

                                    <div class="d-flex align-items-start">

                                        <i class="fas fa-map-marker-alt text-danger me-3 mt-1"></i>

                                        <div>

                                            <div class="fw-bold">

                                                {{ $event->venue }}

                                            </div>

                                            <small class="text-muted">

                                                {{ $event->address }}

                                            </small>

                                        </div>

                                    </div>

                                </div>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

                {{-- BUTTON --}}
                <div class="text-center">

                    <div class="d-flex flex-column flex-lg-row gap-3 justify-content-center align-items-center">

                        {{-- DOWNLOAD --}}
                        <a href="{{ route('user.tickets.download', $ticket->ticket_code) }}"
                           class="btn btn-success btn-lg px-5 py-3 shadow">

                            <i class="fas fa-download me-2"></i>

                            Download PDF

                        </a>

                        {{-- PRINT --}}
                        <button class="btn btn-outline-primary btn-lg px-4 py-3"
                                onclick="printTicket()">

                            <i class="fas fa-print"></i>

                        </button>

                        {{-- BACK --}}
                        <a href="{{ route('user.tickets.index') }}"
                           class="btn btn-secondary btn-lg px-5 py-3">

                            <i class="fas fa-list me-2"></i>

                            Tiket Lainnya

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- PRINT --}}
<div id="print-section" style="display:none;">

    <div class="text-center p-5">

        @if($ticket->qr_code_path)

            <img
                src="{{ asset('storage/' . $ticket->qr_code_path) }}"
                style="max-width:300px;">

        @endif

        <h3 class="mt-4">

            {{ $ticket->ticket_code }}

        </h3>

        <p>

            {{ $event->title ?? '-' }}

        </p>

        <p>

            {{ $registration->full_name ?? '-' }}

        </p>

    </div>

</div>

@push('scripts')

<script>

function printTicket()
{

    const printContent =
        document.getElementById(
            'print-section'
        ).innerHTML;

    const originalContent =
        document.body.innerHTML;

    document.body.innerHTML =
        printContent;

    window.print();

    document.body.innerHTML =
        originalContent;

    location.reload();

}

window.addEventListener('load', function(){

    const qrImg =
        document.querySelector(
            '.qr-code-wrapper img'
        );

    if(qrImg && qrImg.naturalWidth === 0){

        setTimeout(() => {

            location.reload();

        }, 2000);

    }

});

</script>

@endpush

@endsection