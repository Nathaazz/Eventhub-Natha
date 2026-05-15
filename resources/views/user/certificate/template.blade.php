<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <title>
        Certificate
    </title>

    <style>

        @page {
            size: A4 landscape;
            margin: 0;
        }

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{

            font-family: DejaVu Sans, sans-serif;

            width:100%;

            height:100%;

            background:#f8fafc;
        }

        .certificate{

            width:1123px;

            height:794px;

            position:relative;

            overflow:hidden;

            background:white;

            border:20px solid #2563eb;
        }

        /*
        |--------------------------------------------------------------------------
        | BACKGROUND IMAGE
        |--------------------------------------------------------------------------
        */

        .bg{

            position:absolute;

            inset:0;

            width:100%;

            height:100%;

            object-fit:cover;

            opacity:.12;
        }

        /*
        |--------------------------------------------------------------------------
        | WATERMARK
        |--------------------------------------------------------------------------
        */

        .watermark{

            position:absolute;

            inset:0;

            display:flex;

            align-items:center;

            justify-content:center;

            font-size:120px;

            color:rgba(37,99,235,.05);

            font-weight:bold;

            z-index:1;
        }

        /*
        |--------------------------------------------------------------------------
        | CONTENT
        |--------------------------------------------------------------------------
        */

        .content{

            position:relative;

            z-index:2;

            text-align:center;

            padding:45px 70px;
        }

        /*
        |--------------------------------------------------------------------------
        | LOGO
        |--------------------------------------------------------------------------
        */

        .logo{

            width:75px;

            margin-bottom:18px;
        }

        /*
        |--------------------------------------------------------------------------
        | TITLE
        |--------------------------------------------------------------------------
        */

        .title{

            font-size:54px;

            color:#2563eb;

            font-weight:bold;

            margin-top:5px;

            letter-spacing:2px;
        }

        /*
        |--------------------------------------------------------------------------
        | SUBTITLE
        |--------------------------------------------------------------------------
        */

        .subtitle{

            margin-top:18px;

            color:#64748b;

            font-size:22px;
        }

        /*
        |--------------------------------------------------------------------------
        | NAME
        |--------------------------------------------------------------------------
        */

        .name{

            font-size:50px;

            font-weight:bold;

            margin:40px 0 20px;

            color:#0f172a;
        }

        /*
        |--------------------------------------------------------------------------
        | DESCRIPTION
        |--------------------------------------------------------------------------
        */

        .desc{

            font-size:22px;

            color:#475569;

            line-height:1.7;

            max-width:850px;

            margin:auto;
        }

        /*
        |--------------------------------------------------------------------------
        | EVENT
        |--------------------------------------------------------------------------
        */

        .event{

            font-size:34px;

            color:#2563eb;

            font-weight:bold;

            margin-top:22px;

            margin-bottom:18px;
        }

        /*
        |--------------------------------------------------------------------------
        | DATE
        |--------------------------------------------------------------------------
        */

        .date{

            margin-top:10px;

            font-size:20px;

            color:#64748b;
        }

        /*
        |--------------------------------------------------------------------------
        | FOOTER
        |--------------------------------------------------------------------------
        */

        .footer{

            position:absolute;

            bottom:95px;

            left:70px;

            right:70px;

            display:flex;

            justify-content:space-between;

            align-items:center;
        }

        /*
        |--------------------------------------------------------------------------
        | SIGNATURE
        |--------------------------------------------------------------------------
        */

        .signature{

            width:260px;

            text-align:center;
        }

        .line{

            width:100%;

            border-top:2px solid #0f172a;

            margin-bottom:12px;
        }

        .sign-name{

            font-size:20px;

            font-weight:bold;

            color:#0f172a;
        }

        /*
        |--------------------------------------------------------------------------
        | CERTIFICATE NUMBER
        |--------------------------------------------------------------------------
        */

        .number{

            position:absolute;

            bottom:30px;

            left:50px;

            color:#64748b;

            font-size:15px;
        }

    </style>

</head>

<body>

<div class="certificate">

    {{-- BACKGROUND --}}
    @if($event->certificate_background)

        <img src="{{ public_path('storage/' . $event->certificate_background) }}"
             class="bg">

    @endif

    {{-- WATERMARK --}}
    <div class="watermark">

        CERTIFICATE

    </div>

    <div class="content">

        {{-- LOGO --}}
        <div>

            <img src="{{ public_path('logo.png') }}"
                 class="logo">

        </div>

        {{-- TITLE --}}
        <div class="title">

            {{ strtoupper($event->certificate_title ?? 'Certificate') }}

        </div>

        {{-- SUBTITLE --}}
        <div class="subtitle">

            This certificate is proudly presented to

        </div>

        {{-- NAME --}}
        <div class="name">

            {{ $certificate->name }}

        </div>

        {{-- DESCRIPTION --}}
        <div class="desc">

            {{ $event->certificate_description }}

        </div>

        {{-- EVENT --}}
        <div class="event">

            {{ $event->title }}

        </div>

        {{-- DATE --}}
        <div class="date">

            {{ \Carbon\Carbon::parse($event->date)->format('d F Y') }}

        </div>

    </div>

    {{-- FOOTER --}}
    <div class="footer">

        {{-- ORGANIZER --}}
        <div class="signature">

            <div class="line"></div>

            <div class="sign-name">

                {{ $event->certificate_signature }}

            </div>

        </div>

        {{-- EVENTHUB --}}
        <div class="signature">

            <div class="line"></div>

            <div class="sign-name">

                EventHub Organizer

            </div>

        </div>

    </div>

    {{-- NUMBER --}}
    <div class="number">

        Certificate No:
        {{ $certificate->certificate_number }}

    </div>

</div>

</body>
</html>