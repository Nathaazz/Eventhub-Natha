<nav class="navbar navbar-expand-lg modern-navbar sticky-top">

    {{-- GLOW --}}
    <div class="navbar-glow"></div>

    {{-- FLOATING SHAPES --}}
    <div class="floating-shape one"></div>
    <div class="floating-shape two"></div>

    <div class="container-fluid px-4 position-relative z-2">

        {{-- LOGO --}}
        <a class="navbar-brand d-flex align-items-center gap-3"
           href="{{ auth()->check() && auth()->user()->role === 'organizer'
                    ? route('organizer.events.index')
                    : route('user.events.index') }}">

            <div class="logo-box">

                <i class="fas fa-calendar-alt"></i>

            </div>

            <div>

                <div class="brand-title">
                    EventHub
                </div>

                <small class="brand-subtitle">
                    Smart Event Platform
                </small>

            </div>

        </a>

        {{-- TOGGLER --}}
        <button class="navbar-toggler border-0 shadow-none"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">

            <i class="fas fa-bars text-white"></i>

        </button>

        {{-- NAVBAR --}}
        <div class="collapse navbar-collapse"
             id="navbarNav">

            {{-- RIGHT --}}
            <ul class="navbar-nav ms-auto align-items-lg-center">

                @guest

                    <div class="d-flex gap-3 mt-4 mt-lg-0">

                        <a href="{{ route('login') }}"
                           class="btn modern-login-btn">

                            Login

                        </a>

                        <a href="{{ route('register') }}"
                           class="btn modern-register-btn">

                            Daftar

                        </a>

                    </div>

                @else

                    {{-- USER --}}
                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle user-dropdown d-flex align-items-center gap-3"
                           href="#"
                           role="button"
                           data-bs-toggle="dropdown">

                            {{-- AVATAR --}}
                            <div class="avatar-wrapper">

                                @if(auth()->user()->avatar)

                                    <img src="{{ Storage::url(auth()->user()->avatar) }}"
                                         class="avatar-img">

                                @else

                                    <div class="avatar-placeholder">

                                        {{ strtoupper(substr(auth()->user()->name,0,1)) }}

                                    </div>

                                @endif

                            </div>

                            {{-- INFO --}}
                            <div class="d-none d-md-block text-start">

                                <div class="user-name">

                                    {{ \Illuminate\Support\Str::limit(auth()->user()->name, 18) }}

                                </div>

                                <small class="user-role">

                                    {{ auth()->user()->role }}

                                </small>

                            </div>

                        </a>

                        {{-- DROPDOWN --}}
                        <ul class="dropdown-menu dropdown-menu-end modern-dropdown border-0">

                            {{-- USER BOX --}}
                            <li class="dropdown-user-box">

                                <div class="d-flex align-items-center gap-3">

                                    @if(auth()->user()->avatar)

                                        <img src="{{ Storage::url(auth()->user()->avatar) }}"
                                             class="dropdown-avatar">

                                    @else

                                        <div class="dropdown-avatar-placeholder">

                                            {{ strtoupper(substr(auth()->user()->name,0,1)) }}

                                        </div>

                                    @endif

                                    <div>

                                        <div class="fw-bold text-dark">

                                            {{ auth()->user()->name }}

                                        </div>

                                        <small class="text-muted">

                                            {{ auth()->user()->email }}

                                        </small>

                                    </div>

                                </div>

                            </li>

                            {{-- PROFILE --}}
                            <li>

                                <a class="dropdown-item modern-item"
                                   href="{{ route('user.profile.edit') }}">

                                    <i class="fas fa-user me-2"></i>
                                    Profile

                                </a>

                            </li>

                            {{-- ADMIN --}}
                            @if(auth()->user()->role === 'admin')

                            <li>

                                <a class="dropdown-item modern-item"
                                   href="{{ route('admin.dashboard') }}">

                                    <i class="fas fa-chart-line me-2"></i>
                                    Dashboard

                                </a>

                            </li>

                            @endif

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            {{-- LOGOUT --}}
                            <li>

                                <form method="POST"
                                      action="{{ route('logout') }}">

                                    @csrf

                                    <button type="submit"
                                            class="dropdown-item logout-item">

                                        <i class="fas fa-sign-out-alt me-2"></i>
                                        Logout

                                    </button>

                                </form>

                            </li>

                        </ul>

                    </li>

                @endguest

            </ul>

        </div>

    </div>

</nav>

<style>

/* =========================
   FIX NAVBAR PROFILE ONLY
========================= */

.modern-navbar{

    background:
        linear-gradient(
            135deg,
            #2563eb 0%,
            #3b82f6 45%,
            #1d4ed8 100%
        );

    padding:15px 0;

    position:relative;

    overflow:visible;

    border-radius:0 0 34px 34px;

    box-shadow:
        0 14px 40px rgba(37,99,235,.18);

    z-index:999;

    /*
    |--------------------------------------------------------------------------
    | FIX AGAR TIDAK MEMBESAR SAAT PROFILE
    |--------------------------------------------------------------------------
    */

    min-height:unset !important;

    height:auto !important;

    max-height:none !important;

}

/* =========================
   FIX COLLAPSE
========================= */

.modern-navbar .navbar-collapse{

    flex-grow:0 !important;

}

/* =========================
   FIX NAV UL
========================= */

.modern-navbar .navbar-nav{

    align-items:center !important;

}

/* =========================
   FIX USER DROPDOWN
========================= */

.user-dropdown{

    padding:0 !important;

    min-height:auto !important;

}

/* FLOATING SHAPES */
.floating-shape{

    position:absolute;

    border-radius:50%;

    background:
        rgba(255,255,255,.08);

    animation:
        floatingShape 8s ease-in-out infinite;

}

.floating-shape.one{

    width:140px;
    height:140px;

    top:-40px;
    right:120px;

}

.floating-shape.two{

    width:90px;
    height:90px;

    bottom:-20px;
    right:260px;

    animation-delay:3s;

}

@keyframes floatingShape{

    0%{
        transform:translateY(0px);
    }

    50%{
        transform:translateY(-18px);
    }

    100%{
        transform:translateY(0px);
    }

}

/* GLOW */
.navbar-glow{

    position:absolute;

    width:360px;
    height:360px;

    background:
        radial-gradient(
            circle,
            rgba(255,255,255,.16),
            transparent 70%
        );

    border-radius:50%;

    filter:blur(120px);

    top:-180px;
    right:-120px;

    animation:pulseGlow 8s infinite alternate;

    pointer-events:none;

}

@keyframes pulseGlow{

    from{
        transform:scale(1);
    }

    to{
        transform:scale(1.18);
    }

}

/* LOGO */
.logo-box{

    width:60px;
    height:60px;

    border-radius:22px;

    background:
        linear-gradient(
            135deg,
            rgba(255,255,255,.24),
            rgba(255,255,255,.08)
        );

    border:1px solid rgba(255,255,255,.12);

    backdrop-filter:blur(16px);

    display:flex;
    align-items:center;
    justify-content:center;

    color:white;
    font-size:24px;

    box-shadow:
        0 12px 28px rgba(255,255,255,.10);

    animation:
        floatingLogo 5s ease-in-out infinite;

}

@keyframes floatingLogo{

    0%{
        transform:translateY(0);
    }

    50%{
        transform:translateY(-6px);
    }

    100%{
        transform:translateY(0);
    }

}

.brand-title{

    color:white;

    font-size:28px;

    font-weight:700;

    letter-spacing:-.5px;

}

.brand-subtitle{

    color:rgba(255,255,255,.78);

    font-size:12px;

}

/* PROFILE */
.avatar-wrapper{
    position:relative;
}

.avatar-wrapper::before{

    content:'';

    position:absolute;

    inset:-5px;

    border-radius:50%;

    background:
        linear-gradient(
            135deg,
            rgba(255,255,255,.4),
            transparent
        );

    animation:
        rotateGlow 4s linear infinite;

}

@keyframes rotateGlow{

    from{
        transform:rotate(0deg);
    }

    to{
        transform:rotate(360deg);
    }

}

.avatar-img{

    position:relative;

    width:66px;
    height:66px;

    border-radius:50%;

    object-fit:cover;

    border:3px solid rgba(255,255,255,.22);

    box-shadow:
        0 10px 24px rgba(255,255,255,.12);

    transition:.35s;

    z-index:2;

}

.avatar-placeholder{

    position:relative;

    width:66px;
    height:66px;

    border-radius:50%;

    background:
        rgba(255,255,255,.18);

    color:white;

    font-weight:700;

    display:flex;
    align-items:center;
    justify-content:center;

    border:3px solid rgba(255,255,255,.18);

    font-size:20px;

    z-index:2;

}

.user-name{

    color:white;

    font-size:15px;

    font-weight:600;

    line-height:1.2;

}

.user-role{

    color:rgba(255,255,255,.74);

    text-transform:capitalize;

    font-size:12px;

}

.user-dropdown::after{
    color:rgba(255,255,255,.75);
}

/* DROPDOWN */
.dropdown{
    position:relative;
}

.modern-dropdown{

    position:absolute;

    top:82px;
    right:0;

    border-radius:30px;

    overflow:hidden;

    min-width:295px;

    padding:10px;

    background:white;

    border:none;

    z-index:9999;

    animation:
        dropdownFade .3s ease;

    box-shadow:
        0 24px 55px rgba(0,0,0,.14);

}

@keyframes dropdownFade{

    from{
        opacity:0;
        transform:
            translateY(14px)
            scale(.96);
    }

    to{
        opacity:1;
        transform:
            translateY(0)
            scale(1);
    }

}

/* USER BOX */
.dropdown-user-box{

    padding:18px;

    border-radius:24px;

    background:
        linear-gradient(
            135deg,
            #eff6ff,
            #dbeafe
        );

    margin-bottom:10px;

}

/* AVATAR */
.dropdown-avatar{

    width:68px;
    height:68px;

    border-radius:50%;

    object-fit:cover;

}

.dropdown-avatar-placeholder{

    width:68px;
    height:68px;

    border-radius:50%;

    background:
        linear-gradient(
            135deg,
            #2563eb,
            #1d4ed8
        );

    color:white;

    display:flex;
    align-items:center;
    justify-content:center;

    font-weight:700;

    font-size:22px;

}

/* ITEM */
.modern-item{

    padding:15px 18px;

    border-radius:18px;

    transition:.3s;

    font-weight:500;

}

.modern-item:hover{

    background:#eff6ff;

    color:#2563eb;

    transform:translateX(5px);

}

/* LOGOUT */
.logout-item{

    padding:15px 18px;

    border-radius:18px;

    color:#dc2626;

    background:transparent;

    border:none;

    width:100%;

    text-align:left;

    transition:.3s;

}

.logout-item:hover{

    background:#fef2f2;

    transform:translateX(5px);

}

/* BUTTON */
.modern-login-btn{

    border-radius:18px;

    padding:11px 24px;

    font-weight:600;

    background:
        rgba(255,255,255,.14);

    color:white;

    border:1px solid rgba(255,255,255,.12);

    backdrop-filter:blur(10px);

    transition:.3s;

}

.modern-register-btn{

    background:white;

    color:#2563eb;

    border-radius:18px;

    padding:11px 24px;

    font-weight:600;

    border:none;

    transition:.3s;

}

/* TOGGLER */
.navbar-toggler:focus{
    box-shadow:none;
}

/* MOBILE */
@media(max-width:992px){

    .navbar-collapse{
        padding-top:24px;
    }

    .modern-navbar{
        border-radius:0 0 24px 24px;
    }

    .modern-dropdown{

        width:100%;

        min-width:unset;

        right:0;

    }

}

</style>