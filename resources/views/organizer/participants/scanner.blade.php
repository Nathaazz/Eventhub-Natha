{{-- resources/views/organizer/participants/scanner.blade.php --}}

@extends('layouts.app')

@section('title', 'QR Scanner Attendance')

@section('content')

<div class="scanner-page">

    {{-- HEADER --}}
    <div class="scanner-header">

        <div>

            <h1 class="scanner-title">

                QR Attendance Scanner

            </h1>

            <p class="scanner-subtitle">

                Scan QR tiket peserta untuk check-in event

            </p>

        </div>

        <div class="scanner-live-badge">

            <span class="live-dot"></span>

            LIVE SCANNER

        </div>

    </div>

    {{-- MAIN CARD --}}
    <div class="scanner-card">

        <div class="row g-4">

            {{-- CAMERA --}}
            <div class="col-lg-7">

                <div class="camera-card">

                    <div class="camera-header">

                        <div class="camera-icon">

                            <i class="fas fa-camera"></i>

                        </div>

                        <div>

                            <h4 class="mb-1 fw-bold">

                                Kamera Scanner

                            </h4>

                            <small class="text-muted">

                                Arahkan QR tiket ke kamera

                            </small>

                        </div>

                    </div>

                    {{-- QR READER --}}
                    <div id="reader"></div>

                </div>

            </div>

            {{-- RESULT --}}
            <div class="col-lg-5">

                <div class="result-card">

                    <div class="result-header">

                        <div class="result-icon">

                            <i class="fas fa-user-check"></i>

                        </div>

                        <div>

                            <h4 class="mb-1 fw-bold">

                                Status Check-in

                            </h4>

                            <small class="text-muted">

                                Hasil scan QR peserta

                            </small>

                        </div>

                    </div>

                    {{-- RESULT BOX --}}
                    <div id="scan-result">

                        <div class="empty-result">

                            <i class="fas fa-qrcode"></i>

                            <h5>

                                Menunggu Scan QR

                            </h5>

                            <p>

                                Silakan arahkan QR tiket ke kamera

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- HTML5 QR --}}
<script src="https://unpkg.com/html5-qrcode"></script>

<script>

let scanning = false;

function onScanSuccess(decodedText)
{

    if(scanning){

        return;

    }

    scanning = true;

    fetch(
        '{{ route("organizer.participants.scan") }}',
        {

            method:'POST',

            headers:{

                'Content-Type':'application/json',

                'X-CSRF-TOKEN':
                    '{{ csrf_token() }}'

            },

            body:JSON.stringify({

                ticket_code:decodedText

            })

        }
    )
    .then(response => response.json())

    .then(data => {

        const resultBox =
            document.getElementById('scan-result');

        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        if(data.success){

            resultBox.innerHTML = `

                <div class="success-box">

                    <div class="success-icon">

                        <i class="fas fa-circle-check"></i>

                    </div>

                    <h3>

                        Check-in Berhasil

                    </h3>

                    <div class="participant-info">

                        <div class="info-item">

                            <span>Peserta</span>

                            <strong>${data.participant}</strong>

                        </div>

                        <div class="info-item">

                            <span>Nomor HP</span>

                            <strong>${data.phone}</strong>

                        </div>

                        <div class="info-item">

                            <span>Event</span>

                            <strong>${data.event}</strong>

                        </div>

                        <div class="info-item">

                            <span>Waktu</span>

                            <strong>${data.time}</strong>

                        </div>

                    </div>

                </div>

            `;

        }

        /*
        |--------------------------------------------------------------------------
        | ERROR
        |--------------------------------------------------------------------------
        */

        else{

            resultBox.innerHTML = `

                <div class="error-box">

                    <div class="error-icon">

                        <i class="fas fa-circle-xmark"></i>

                    </div>

                    <h3>

                        Scan Gagal

                    </h3>

                    <p>

                        ${data.message}

                    </p>

                </div>

            `;

        }

        /*
        |--------------------------------------------------------------------------
        | SOUND
        |--------------------------------------------------------------------------
        */

        playBeep();

        setTimeout(() => {

            scanning = false;

        }, 2500);

    })

    .catch(error => {

        console.log(error);

        scanning = false;

    });

}

/*
|--------------------------------------------------------------------------
| START SCANNER
|--------------------------------------------------------------------------
*/

new Html5QrcodeScanner(
    "reader",
    {

        fps:10,

        qrbox:{
            width:280,
            height:280
        }

    }
).render(onScanSuccess);

/*
|--------------------------------------------------------------------------
| SOUND
|--------------------------------------------------------------------------
*/

function playBeep()
{

    const audio = new Audio(
        "https://actions.google.com/sounds/v1/cartoon/wood_plank_flicks.ogg"
    );

    audio.play();

}

</script>

<style>

/* =========================
   PAGE
========================= */

.scanner-page{

    padding:35px;

}

/* =========================
   HEADER
========================= */

.scanner-header{

    display:flex;

    justify-content:space-between;

    align-items:center;

    flex-wrap:wrap;

    gap:20px;

    margin-bottom:35px;

}

.scanner-title{

    font-size:54px;

    font-weight:800;

    color:#0f172a;

    margin-bottom:6px;

}

.scanner-subtitle{

    color:#64748b;

    font-size:18px;

    margin:0;

}

/* =========================
   LIVE BADGE
========================= */

.scanner-live-badge{

    display:flex;

    align-items:center;

    gap:10px;

    background:#dcfce7;

    color:#15803d;

    padding:14px 22px;

    border-radius:999px;

    font-weight:700;

}

.live-dot{

    width:12px;
    height:12px;

    border-radius:50%;

    background:#22c55e;

    animation:pulse 1s infinite;

}

@keyframes pulse{

    0%{
        transform:scale(1);
        opacity:1;
    }

    50%{
        transform:scale(1.4);
        opacity:.5;
    }

    100%{
        transform:scale(1);
        opacity:1;
    }

}

/* =========================
   CARD
========================= */

.scanner-card{

    background:white;

    border-radius:36px;

    padding:35px;

    box-shadow:
        0 15px 40px rgba(0,0,0,.05);

}

/* =========================
   CAMERA
========================= */

.camera-card{

    background:#f8fafc;

    border-radius:30px;

    padding:28px;

    height:100%;

}

.camera-header{

    display:flex;

    align-items:center;

    gap:16px;

    margin-bottom:28px;

}

.camera-icon{

    width:68px;
    height:68px;

    border-radius:22px;

    background:#dbeafe;

    color:#2563eb;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:28px;

}

/* =========================
   RESULT
========================= */

.result-card{

    background:#f8fafc;

    border-radius:30px;

    padding:28px;

    height:100%;

}

.result-header{

    display:flex;

    align-items:center;

    gap:16px;

    margin-bottom:28px;

}

.result-icon{

    width:68px;
    height:68px;

    border-radius:22px;

    background:#dcfce7;

    color:#16a34a;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:28px;

}

/* =========================
   EMPTY
========================= */

.empty-result{

    text-align:center;

    padding:70px 20px;

}

.empty-result i{

    font-size:72px;

    color:#cbd5e1;

    margin-bottom:20px;

}

.empty-result h5{

    font-weight:800;

    margin-bottom:10px;

}

.empty-result p{

    color:#64748b;

}

/* =========================
   SUCCESS
========================= */

.success-box{

    text-align:center;

    padding:25px;

}

.success-icon{

    width:100px;
    height:100px;

    border-radius:50%;

    background:#dcfce7;

    color:#16a34a;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:50px;

    margin:0 auto 25px;

}

.success-box h3{

    font-size:34px;

    font-weight:800;

    margin-bottom:25px;

    color:#15803d;

}

.participant-info{

    display:flex;

    flex-direction:column;

    gap:16px;

}

.info-item{

    background:white;

    border-radius:20px;

    padding:18px;

}

.info-item span{

    display:block;

    color:#64748b;

    margin-bottom:4px;

}

.info-item strong{

    font-size:18px;

    color:#0f172a;

}

/* =========================
   ERROR
========================= */

.error-box{

    text-align:center;

    padding:40px 20px;

}

.error-icon{

    width:100px;
    height:100px;

    border-radius:50%;

    background:#fee2e2;

    color:#dc2626;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:50px;

    margin:0 auto 25px;

}

.error-box h3{

    font-size:34px;

    font-weight:800;

    margin-bottom:14px;

    color:#dc2626;

}

.error-box p{

    color:#64748b;

    font-size:17px;

}

/* =========================
   QR SCANNER STYLE
========================= */

#reader{

    border:none !important;

    overflow:hidden;

    border-radius:28px;

}

#reader video{

    border-radius:28px;

}

/* =========================
   MOBILE
========================= */

@media(max-width:992px){

    .scanner-page{

        padding:20px;

    }

    .scanner-title{

        font-size:40px;

    }

    .scanner-card{

        padding:20px;

    }

}

</style>

@endsection