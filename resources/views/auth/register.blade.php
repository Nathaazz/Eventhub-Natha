@extends('layouts.app')

@section('title', 'Daftar Akun')

@section('content')
<style>
:root{
    --primary:#2563eb;
}

/* BACKGROUND */
body{
    margin:0;
    background:linear-gradient(145deg,#2563eb,#1e40af);
}

/* CONTAINER */
.container-fluid{
    padding:0!important;
}

.register-container{
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
    position:relative;
    overflow:hidden;
}

/* FLOAT */
.float{
    position:absolute;
    border-radius:50%;
    background:rgba(255,255,255,0.08);
    animation:float 10s infinite ease-in-out;
}

.float:nth-child(1){
    width:120px;
    height:120px;
    top:8%;
    left:15%;
}

.float:nth-child(2){
    width:70px;
    height:70px;
    bottom:12%;
    right:15%;
}

.float:nth-child(3){
    width:40px;
    height:40px;
    top:60%;
    left:70%;
}

@keyframes float{
    0%,100%{
        transform:translateY(0);
    }

    50%{
        transform:translateY(-30px);
    }
}

/* GLOW */
.glow{
    position:absolute;
    width:300px;
    height:300px;
    background:radial-gradient(circle, rgba(255,255,255,0.15), transparent);
    border-radius:50%;
    filter:blur(40px);
    animation:glowMove 12s infinite alternate;
}

.glow.one{
    top:10%;
    left:10%;
}

.glow.two{
    bottom:10%;
    right:10%;
}

@keyframes glowMove{
    from{
        transform:translate(0,0);
    }

    to{
        transform:translate(40px,40px);
    }
}

/* MASKOT */
.mascot{
    width:140px;
    height:140px;
    background:white;
    border-radius:18px;
    border:4px solid #1e3a8a;
    position:absolute;
    top:40px;
    left:50%;
    transform:translateX(-50%);
    animation:floatMascot 4s ease-in-out infinite;
    z-index:1;
    box-shadow:0 15px 40px rgba(0,0,0,0.3);
}

@keyframes floatMascot{
    0%,100%{
        transform:translateX(-50%) translateY(0);
    }

    50%{
        transform:translateX(-50%) translateY(-15px);
    }
}

/* HEADER */
.mascot::before{
    content:'';
    position:absolute;
    width:100%;
    height:30px;
    background:#1e3a8a;
    border-radius:14px 14px 0 0;
}

/* RING */
.ring{
    width:14px;
    height:14px;
    border:3px solid white;
    border-radius:50%;
    position:absolute;
    top:-8px;
}

.ring.left{
    left:25px;
}

.ring.right{
    right:25px;
}

/* FACE */
.eyes{
    position:absolute;
    top:50px;
    left:50%;
    transform:translateX(-50%);
    display:flex;
    gap:20px;
}

.eye{
    width:18px;
    height:18px;
    background:white;
    border:2px solid #1e3a8a;
    border-radius:50%;
}

.mascot.blink .eye{
    height:4px;
}

.mouth{
    width:35px;
    height:20px;
    background:#1e3a8a;
    border-radius:0 0 20px 20px;
    position:absolute;
    bottom:25px;
    left:50%;
    transform:translateX(-50%);
}

/* CARD */
.register-card{
    width:100%;
    max-width:430px;
    background:white;
    padding:70px 40px 50px;
    border-radius:20px;
    box-shadow:0 25px 80px rgba(0,0,0,0.25);
    text-align:center;
    position:relative;
    z-index:2;
}

/* FORM */
.form-control,
.form-select{
    border-radius:12px;
    padding:13px;
    border:2px solid #e2e8f0;
}

.form-control:focus,
.form-select:focus{
    border-color:var(--primary);
    box-shadow:0 0 0 3px rgba(37,99,235,0.2);
}

/* ROLE OPTION */
.role-box{
    display:flex;
    gap:12px;
    margin-top:10px;
}

.role-option{
    flex:1;
    border:2px solid #dbeafe;
    border-radius:14px;
    padding:14px;
    cursor:pointer;
    transition:0.3s;
    text-align:center;
}

.role-option:hover{
    border-color:#2563eb;
    background:#eff6ff;
}

.role-option input{
    display:none;
}

.role-option.active{
    border-color:#2563eb;
    background:#eff6ff;
}

/* BUTTON */
.btn-primary{
    background:linear-gradient(135deg,#2563eb,#1e40af);
    border:none;
    border-radius:12px;
    padding:13px;
    font-weight:600;
}

.btn-primary:hover{
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
}

/* RESPONSIVE */
@media(max-width:768px){

    .mascot{
        display:none;
    }

}
</style>

<div class="register-container">

    <div class="float"></div>
    <div class="float"></div>
    <div class="float"></div>

    <div class="glow one"></div>
    <div class="glow two"></div>

    <!-- MASKOT -->
    <div class="mascot" id="mascot">

        <div class="ring left"></div>
        <div class="ring right"></div>

        <div class="eyes">
            <div class="eye"></div>
            <div class="eye"></div>
        </div>

        <div class="mouth"></div>

    </div>

    <!-- FORM -->
    <div class="register-card">

        <h4 class="mb-1 text-dark fw-bold">
            EventHub
        </h4>

        <small class="text-muted">
            Buat akun baru kamu
        </small>

        <form method="POST"
              action="{{ route('register') }}"
              class="mt-4 text-start">

            @csrf

            <!-- ROLE -->
            <div class="mb-4">

                <label class="fw-semibold mb-2">
                    Pilih Role
                </label>

                <div class="role-box">

                    <label class="role-option active" id="userRole">

                        <input type="radio"
                               name="role"
                               value="user"
                               checked>

                        <div class="fs-3 mb-2">👤</div>

                        <div class="fw-semibold">
                            User
                        </div>

                        <small class="text-muted">
                            Peserta Event
                        </small>

                    </label>

                    <label class="role-option" id="organizerRole">

                        <input type="radio"
                               name="role"
                               value="organizer">

                        <div class="fs-3 mb-2">🎯</div>

                        <div class="fw-semibold">
                            Organizer
                        </div>

                        <small class="text-muted">
                            Pembuat Event
                        </small>

                    </label>

                </div>

            </div>

            <!-- NAME -->
            <div class="mb-3">

                <label>Nama</label>

                <input type="text"
                       name="name"
                       class="form-control"
                       required>

            </div>

            <!-- PHONE -->
            <div class="mb-3">

                <label>No HP</label>

                <input type="tel"
                       name="phone"
                       class="form-control">

            </div>

            <!-- EMAIL -->
            <div class="mb-3">

                <label>Email</label>

                <input type="email"
                       name="email"
                       class="form-control"
                       required>

            </div>

            <!-- PASSWORD -->
            <div class="mb-3">

                <label>Password</label>

                <div class="input-group">

                    <input type="password"
                           name="password"
                           id="passwordReg"
                           class="form-control"
                           required>

                    <button type="button"
                            class="btn btn-outline-secondary"
                            id="togglePasswordReg">

                        👁

                    </button>

                </div>

            </div>

            <!-- CONFIRM -->
            <div class="mb-4">

                <label>Konfirmasi Password</label>

                <input type="password"
                       name="password_confirmation"
                       class="form-control"
                       required>

            </div>

            <!-- BUTTON -->
            <button class="btn btn-primary w-100">
                Daftar Sekarang
            </button>

        </form>

        <div class="mt-3">

            <small>
                Sudah punya akun?
            </small>

            <br>

            <a href="{{ route('login') }}"
               class="text-primary fw-semibold">

                Masuk

            </a>

        </div>

    </div>

</div>

<script>
const mascot=document.getElementById('mascot');

function blink(){

    mascot.classList.add('blink');

    setTimeout(()=>{
        mascot.classList.remove('blink');
    },120);

    setTimeout(blink,Math.random()*4000+2000);
}

blink();

/* TOGGLE PASSWORD */
document.getElementById('togglePasswordReg').onclick=()=>{

    let input=document.getElementById('passwordReg');

    input.type=input.type==='password'
        ? 'text'
        : 'password';
};

/* ROLE ACTIVE */
const roleOptions=document.querySelectorAll('.role-option');

roleOptions.forEach(option=>{

    option.addEventListener('click',()=>{

        roleOptions.forEach(o=>{
            o.classList.remove('active');
        });

        option.classList.add('active');

    });

});
</script>

@endsection