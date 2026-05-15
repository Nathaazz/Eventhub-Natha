@extends('layouts.app')

@section('title', 'Masuk')

@section('content')

<style>
:root{
    --primary:#2563eb;
    --secondary:#1e40af;
    --bg:#f8fafc;
    --white:#ffffff;
}

body{
    margin:0;
    background:var(--bg);
    overflow:hidden;
}

.container-fluid{
    padding:0!important;
}

/* MAIN */
.login-container{
    display:flex;
    height:100vh;
    width:100%;
}

/* LEFT */
.login-left{
    width:50%;
    background:linear-gradient(145deg,#2563eb,#1e3a8a);
    position:relative;
    overflow:hidden;
    display:flex;
    justify-content:center;
    align-items:center;
}

/* FLOATING ELEMENTS */
.float{
    position:absolute;
    opacity:.18;
    animation:float 8s ease-in-out infinite;
}

.float.circle1{
    width:140px;
    height:140px;
    border-radius:50%;
    background:white;
    top:8%;
    left:15%;
}

.float.circle2{
    width:70px;
    height:70px;
    border-radius:50%;
    background:white;
    bottom:10%;
    left:28%;
    animation-delay:2s;
}

.float.square{
    width:26px;
    height:26px;
    background:white;
    transform:rotate(45deg);
    top:28%;
    right:20%;
    animation-delay:1s;
}

.float.line{
    width:120px;
    height:120px;
    border:2px solid rgba(255,255,255,.2);
    border-radius:30px;
    bottom:18%;
    right:10%;
    animation-delay:3s;
}

.float.glow{
    width:300px;
    height:300px;
    background:radial-gradient(circle,rgba(255,255,255,.25),transparent);
    filter:blur(20px);
    border-radius:50%;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
}

/* FLOAT */
@keyframes float{
    0%,100%{
        transform:translateY(0);
    }
    50%{
        transform:translateY(-20px);
    }
}

/* MASCOT WRAP */
.mascot-wrapper{
    position:relative;
    width:260px;
    height:260px;
    display:flex;
    justify-content:center;
    align-items:center;
}

/* GLOW */
.mascot-glow{
    position:absolute;
    width:240px;
    height:240px;
    background:radial-gradient(circle,rgba(255,255,255,.25),transparent);
    border-radius:50%;
    filter:blur(30px);
}

/* MASCOT */
.mascot{
    width:180px;
    height:180px;
    background:white;
    border-radius:22px;
    border:4px solid #1e3a8a;
    position:relative;
    animation:floatMascot 4s ease-in-out infinite;
    box-shadow:0 30px 60px rgba(0,0,0,.25);
}

/* FLOAT MASCOT */
@keyframes floatMascot{
    0%,100%{
        transform:translateY(0);
    }
    50%{
        transform:translateY(-12px);
    }
}

/* HEADER */
.mascot::before{
    content:'';
    position:absolute;
    width:100%;
    height:42px;
    top:0;
    left:0;
    background:#1e3a8a;
    border-radius:18px 18px 0 0;
}

/* RING */
.ring{
    width:18px;
    height:18px;
    border:4px solid white;
    border-radius:50%;
    position:absolute;
    top:-10px;
}

.ring.left{
    left:30px;
}

.ring.right{
    right:30px;
}

/* EYES */
.eyes{
    position:absolute;
    top:68px;
    left:50%;
    transform:translateX(-50%);
    display:flex;
    gap:28px;
}

.eye{
    width:30px;
    height:30px;
    background:white;
    border:3px solid #1e3a8a;
    border-radius:50%;
    position:relative;
    transition:.2s;
    overflow:hidden;
}

/* PUPIL */
.pupil{
    width:10px;
    height:10px;
    background:#1e3a8a;
    border-radius:50%;
    position:absolute;
    top:8px;
    left:8px;
    transition:.1s;
}

/* BLINK */
.mascot.blink .eye,
.mascot.closed .eye{
    height:4px;
    margin-top:12px;
    background:#1e3a8a;
}

.mascot.blink .pupil,
.mascot.closed .pupil{
    display:none;
}

/* BLUSH */
.blush{
    width:20px;
    height:10px;
    background:#c7d2fe;
    border-radius:50%;
    position:absolute;
    top:104px;
}

.blush.left{
    left:35px;
}

.blush.right{
    right:35px;
}

/* MOUTH */
.mouth{
    width:52px;
    height:34px;
    background:#1e3a8a;
    border-radius:0 0 30px 30px;
    position:absolute;
    bottom:38px;
    left:50%;
    transform:translateX(-50%);
    overflow:hidden;
}

/* TEETH */
.teeth{
    width:100%;
    height:12px;
    background:white;
}

/* HAND */
.hand{
    width:24px;
    height:58px;
    background:white;
    border:3px solid #1e3a8a;
    position:absolute;
    top:65px;
    border-radius:20px;
}

.hand.left{
    left:-26px;
    transform:rotate(-25deg);
    animation:wave 2s infinite;
}

.hand.right{
    right:-26px;
    transform:rotate(25deg);
}

/* WAVE */
@keyframes wave{
    0%,100%{
        transform:rotate(-25deg);
    }
    50%{
        transform:rotate(-40deg);
    }
}

/* LEGS */
.leg{
    width:20px;
    height:34px;
    background:#1e3a8a;
    position:absolute;
    bottom:-30px;
    border-radius:10px;
}

.leg.left{
    left:42px;
}

.leg.right{
    right:42px;
}

/* SHADOW */
.shadow{
    width:120px;
    height:18px;
    background:rgba(0,0,0,.18);
    border-radius:50%;
    position:absolute;
    bottom:-45px;
    left:50%;
    transform:translateX(-50%);
}

/* RIGHT */
.login-right{
    width:50%;
    display:flex;
    justify-content:center;
    align-items:center;
    background:white;
    position:relative;
}

/* CARD */
.login-card{
    width:100%;
    max-width:420px;
    padding:55px;
}

/* TITLE */
.login-title{
    font-size:42px;
    font-weight:700;
    margin-bottom:5px;
}

.login-sub{
    color:#64748b;
    margin-bottom:35px;
}

/* FORM */
.form-control{
    border-radius:14px;
    border:2px solid #e2e8f0;
    padding:14px;
    transition:.2s;
}

.form-control:focus{
    border-color:#2563eb;
    box-shadow:0 0 0 4px rgba(37,99,235,.12);
}

/* BUTTON */
.btn-primary{
    background:linear-gradient(145deg,#2563eb,#1d4ed8);
    border:none;
    border-radius:14px;
    padding:14px;
    font-weight:600;
    transition:.3s;
}

.btn-primary:hover{
    transform:translateY(-2px);
    box-shadow:0 15px 30px rgba(37,99,235,.25);
}

/* TOGGLE */
.password-btn{
    border:2px solid #e2e8f0;
    border-left:none;
    border-radius:0 14px 14px 0;
    background:white;
    width:60px;
}

/* ALERT */
.alert{
    border:none;
    border-radius:14px;
}

/* RESPONSIVE */
@media(max-width:992px){

    .login-left{
        display:none;
    }

    .login-right{
        width:100%;
    }

    .login-card{
        max-width:500px;
    }
}
</style>

<div class="login-container">

    <!-- LEFT -->
    <div class="login-left">

        <div class="float circle1"></div>
        <div class="float circle2"></div>
        <div class="float square"></div>
        <div class="float line"></div>
        <div class="float glow"></div>

        <div class="mascot-wrapper">

            <div class="mascot-glow"></div>

            <div class="mascot" id="mascot">

                <div class="ring left"></div>
                <div class="ring right"></div>

                <div class="eyes">

                    <div class="eye">
                        <div class="pupil"></div>
                    </div>

                    <div class="eye">
                        <div class="pupil"></div>
                    </div>

                </div>

                <div class="blush left"></div>
                <div class="blush right"></div>

                <div class="mouth">
                    <div class="teeth"></div>
                </div>

                <div class="hand left"></div>
                <div class="hand right"></div>

                <div class="leg left"></div>
                <div class="leg right"></div>

                <div class="shadow"></div>

            </div>

        </div>

    </div>

    <!-- RIGHT -->
    <div class="login-right">

        <div class="login-card">

            {{-- SUCCESS --}}
            @if(session('success'))
                <div class="alert alert-success mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ERROR --}}
            @if(session('error'))
                <div class="alert alert-danger mb-4">
                    {{ session('error') }}
                </div>
            @endif

            {{-- VALIDATION --}}
            @if($errors->any())
                <div class="alert alert-danger mb-4">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="login-title">
                EventHub
            </div>

            <div class="login-sub">
                Masuk ke akun kamu
            </div>

            <form method="POST"
                  action="{{ route('login') }}">

                @csrf

                <!-- EMAIL -->
                <div class="mb-4">

                    <label class="mb-2 fw-semibold">
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="form-control"
                        required
                    >

                </div>

                <!-- PASSWORD -->
                <div class="mb-4">

                    <label class="mb-2 fw-semibold">
                        Password
                    </label>

                    <div class="input-group">

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control"
                            required
                        >

                        <button
                            type="button"
                            class="password-btn"
                            id="togglePassword">

                            👁

                        </button>

                    </div>

                </div>

                <!-- REMEMBER -->
                <div class="mb-4 form-check">

                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="remember"
                        id="remember">

                    <label
                        class="form-check-label"
                        for="remember">

                        Ingat saya

                    </label>

                </div>

                <!-- BUTTON -->
                <button class="btn btn-primary w-100">
                    Masuk
                </button>

            </form>

            <!-- REGISTER -->
            <div class="text-center mt-4">

                <small class="text-muted">
                    Belum punya akun?
                </small>

                <br>

                <a href="{{ route('register') }}"
                   class="fw-semibold text-decoration-none">

                    Daftar akun

                </a>

            </div>

        </div>

    </div>

</div>

<script>
const mascot=document.getElementById('mascot');
const pupils=document.querySelectorAll('.pupil');
const password=document.getElementById('password');

/* EYES FOLLOW */
document.addEventListener('mousemove',e=>{

    const x=(e.clientX/window.innerWidth-0.5)*8;
    const y=(e.clientY/window.innerHeight-0.5)*8;

    pupils.forEach(p=>{
        p.style.transform=`translate(${x}px,${y}px)`;
    });

});

/* BLINK */
function blink(){

    mascot.classList.add('blink');

    setTimeout(()=>{
        mascot.classList.remove('blink');
    },150);

    setTimeout(blink,Math.random()*4000+2000);
}

blink();

/* PASSWORD MODE */
password.addEventListener('focus',()=>{
    mascot.classList.add('closed');
});

password.addEventListener('blur',()=>{
    mascot.classList.remove('closed');
});

/* TOGGLE PASSWORD */
document.getElementById('togglePassword').onclick=()=>{

    password.type=password.type==='password'
        ? 'text'
        : 'password';
};
</script>

@endsection