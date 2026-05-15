<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <title>
        E-Ticket
    </title>

    <style>

        body{

            font-family:Arial, sans-serif;

            padding:40px;

            color:#111827;

        }

        .ticket{

            border:3px solid #2563eb;

            border-radius:24px;

            padding:35px;

        }

        .header{

            text-align:center;

            margin-bottom:30px;

        }

        .header h1{

            font-size:34px;

            color:#2563eb;

            margin-bottom:10px;

        }

        .divider{

            height:2px;

            background:#e5e7eb;

            margin:25px 0;

        }

        .detail{

            margin-bottom:14px;

            font-size:16px;

        }

        .detail strong{

            display:inline-block;

            width:120px;

            color:#374151;

        }

        .ticket-code{

            margin-top:25px;

            font-size:24px;

            font-weight:bold;

            color:#2563eb;

            letter-spacing:2px;

        }

        .qr-wrapper{

            text-align:center;

            margin-top:35px;

        }

        .qr-wrapper img{

            width:220px;

            height:220px;

        }

        .footer{

            text-align:center;

            margin-top:35px;

            font-size:14px;

            color:#6b7280;

        }

    </style>

</head>

<body>

<div class="ticket">

    {{-- HEADER --}}
    <div class="header">

        <h1>
            E-TICKET
        </h1>

        <p>
            EventHub Digital Ticket
        </p>

    </div>

    <div class="divider"></div>

    {{-- DETAIL --}}
    <div class="detail">

        <strong>Kode</strong>

        : {{ $ticket->ticket_code }}

    </div>

    <div class="detail">

        <strong>Nama</strong>

        : {{ $ticket->registration->full_name }}

    </div>

    <div class="detail">

        <strong>Email</strong>

        : {{ $ticket->registration->email }}

    </div>

    <div class="detail">

        <strong>Telepon</strong>

        : {{ $ticket->registration->phone }}

    </div>

    <div class="detail">

        <strong>Event</strong>

        : {{ $ticket->event->title }}

    </div>

    <div class="detail">

        <strong>Tanggal</strong>

        : {{ \Carbon\Carbon::parse($ticket->event->date)->format('d M Y') }}

    </div>

    <div class="detail">

        <strong>Lokasi</strong>

        : {{ $ticket->event->venue }}

    </div>

    {{-- CODE --}}
    <div class="ticket-code">

        {{ $ticket->ticket_code }}

    </div>

    {{-- QR --}}
    @if($ticket->qr_code_path)

    <div class="qr-wrapper">

        <img
            src="{{ public_path('storage/' . $ticket->qr_code_path) }}">

    </div>

    @endif

    {{-- FOOTER --}}
    <div class="footer">

        Tunjukkan QR Code ini saat memasuki event

    </div>

</div>

</body>

</html>