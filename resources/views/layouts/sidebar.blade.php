<nav id="sidebar"
     class="sidebar-modern">

    {{-- AURORA --}}
    <div class="aurora aurora-1"></div>
    <div class="aurora aurora-2"></div>

    {{-- GRID --}}
    <div class="sidebar-grid"></div>

    <div class="sidebar-content">

        {{-- LOGO --}}
        <div class="text-center mb-5 fade-in">

            <div class="sidebar-logo mx-auto mb-4">

                <i class="fas fa-calendar-alt"></i>

            </div>

            <h2 class="logo-text">
                EventHub
            </h2>

            <div class="sidebar-subtitle">

                {{ auth()->user()->name }}

            </div>

        </div>

        {{-- MENU --}}
        <ul class="nav flex-column gap-3 flex-grow-1">

            {{-- DASHBOARD --}}
            <li class="nav-item">

                <a class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                   href="{{ route('dashboard') }}">

                    <div class="icon-box">

                        <i class="fas fa-house"></i>

                    </div>

                    <span>
                        Dashboard
                    </span>

                </a>

            </li>

            {{-- EVENT --}}
            <li class="nav-item">

                <a class="sidebar-link {{ request()->routeIs('organizer.events.*') ? 'active' : '' }}"
                   href="{{ route('organizer.events.index') }}">

                    <div class="icon-box">

                        <i class="fas fa-calendar"></i>

                    </div>

                    <span>
                        Event Saya
                    </span>

                    <span class="sidebar-badge">

                        {{ auth()->user()->events()->count() ?? 0 }}

                    </span>

                </a>

            </li>

            {{-- PESERTA --}}
            <li class="nav-item">

                <a class="sidebar-link {{ request()->routeIs('organizer.participants.*') && !request()->routeIs('organizer.participants.scanner') ? 'active' : '' }}"
                   href="{{ route('organizer.participants.index') }}">

                    <div class="icon-box">

                        <i class="fas fa-users"></i>

                    </div>

                    <span>
                        Peserta
                    </span>

                </a>

            </li>

            {{-- SCAN QR CODE --}}
            <li class="nav-item">

                <a class="sidebar-link {{ request()->routeIs('organizer.participants.scanner') ? 'active' : '' }}"
                   href="{{ route('organizer.participants.scanner') }}">

                    <div class="icon-box">

                        <i class="fas fa-qrcode"></i>

                    </div>

                    <span>
                        Scan QR Ticket
                    </span>

                </a>

            </li>

            {{-- SERTIFIKAT --}}
            <li class="nav-item">

                <a class="sidebar-link {{ request()->routeIs('organizer.certificates.*') ? 'active' : '' }}"
                   href="{{ route('organizer.certificates.index') }}">

                    <div class="icon-box">

                        <i class="fas fa-award"></i>

                    </div>

                    <span>
                        Sertifikat
                    </span>

                </a>

            </li>

            {{-- PROFILE --}}
            <li class="nav-item">

                <a class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}"
                   href="{{ route('user.profile.edit') }}">

                    <div class="icon-box">

                        <i class="fas fa-user-circle"></i>

                    </div>

                    <span>
                        Profile
                    </span>

                </a>

            </li>

        </ul>

        {{-- LOGOUT --}}
        <div class="logout-wrapper">

            <form action="{{ route('logout') }}"
                  method="POST">

                @csrf

                <button type="submit"
                        class="logout-btn w-100">

                    <i class="fas fa-sign-out-alt me-2"></i>

                    Logout

                </button>

            </form>

        </div>

    </div>

</nav>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

/* =========================
   SIDEBAR
========================= */

.sidebar-modern{

    width:290px;

    min-height:100vh;

    position:relative;

    overflow:hidden;

    flex-shrink:0;

    background:
        linear-gradient(
            180deg,
            #2563eb 0%,
            #3b82f6 50%,
            #1d4ed8 100%
        );

    border-radius:0 38px 38px 0;

    box-shadow:
        0 16px 45px rgba(37,99,235,.16);

}

/* =========================
   GRID
========================= */

.sidebar-grid{

    position:absolute;

    inset:0;

    background-image:
        linear-gradient(
            rgba(255,255,255,.04) 1px,
            transparent 1px
        ),
        linear-gradient(
            90deg,
            rgba(255,255,255,.04) 1px,
            transparent 1px
        );

    background-size:36px 36px;

}

/* =========================
   AURORA
========================= */

.aurora{

    position:absolute;

    border-radius:50%;

    filter:blur(90px);

    opacity:.45;

    animation:
        auroraMove 12s infinite alternate ease-in-out;

}

.aurora-1{

    width:260px;
    height:260px;

    background:
        rgba(255,255,255,.22);

    top:-80px;
    left:-120px;

}

.aurora-2{

    width:220px;
    height:220px;

    background:
        rgba(147,197,253,.30);

    bottom:-80px;
    right:-80px;

    animation-delay:4s;

}

@keyframes auroraMove{

    from{
        transform:
            translateY(0)
            scale(1);
    }

    to{
        transform:
            translateY(25px)
            scale(1.12);
    }

}

/* =========================
   CONTENT
========================= */

.sidebar-content{

    position:relative;

    z-index:2;

    display:flex;

    flex-direction:column;

    min-height:100vh;

    padding:130px 22px 30px;

}

/* =========================
   LOGO
========================= */

.sidebar-logo{

    width:86px;
    height:86px;

    border-radius:30px;

    background:
        linear-gradient(
            135deg,
            rgba(255,255,255,.26),
            rgba(255,255,255,.08)
        );

    border:
        1px solid rgba(255,255,255,.14);

    backdrop-filter:
        blur(18px);

    display:flex;

    align-items:center;

    justify-content:center;

    color:white;

    font-size:34px;

    box-shadow:
        0 20px 40px rgba(255,255,255,.10);

    animation:
        floatingLogo 6s ease-in-out infinite;

}

@keyframes floatingLogo{

    0%{
        transform:translateY(0);
    }

    50%{
        transform:translateY(-10px);
    }

    100%{
        transform:translateY(0);
    }

}

.logo-text{

    color:white;

    font-size:32px;

    font-weight:800;

    letter-spacing:-.5px;

    margin-bottom:4px;

}

.sidebar-subtitle{

    color:
        rgba(255,255,255,.78);

    font-size:15px;

    font-weight:500;

}

/* =========================
   MENU
========================= */

.sidebar-link{

    display:flex;

    align-items:center;

    gap:14px;

    padding:17px 18px;

    border-radius:28px;

    text-decoration:none;

    color:
        rgba(255,255,255,.92);

    font-weight:600;

    transition:
        all .35s cubic-bezier(.4,0,.2,1);

    position:relative;

    overflow:hidden;

    backdrop-filter:
        blur(14px);

}

.sidebar-link::before{

    content:'';

    position:absolute;

    inset:0;

    background:
        linear-gradient(
            90deg,
            rgba(255,255,255,.20),
            transparent
        );

    transform:
        translateX(-100%);

    transition:.7s;

}

.sidebar-link:hover::before{

    transform:
        translateX(100%);

}

.sidebar-link:hover{

    transform:
        translateX(8px)
        scale(1.02);

    background:
        rgba(255,255,255,.16);

    box-shadow:
        0 16px 34px rgba(255,255,255,.10);

    color:white;

}

.sidebar-link.active{

    background:
        linear-gradient(
            135deg,
            rgba(255,255,255,.28),
            rgba(255,255,255,.10)
        );

    box-shadow:
        0 16px 34px rgba(255,255,255,.14);

    color:white;

}

/* =========================
   ICON
========================= */

.icon-box{

    width:50px;
    height:50px;

    border-radius:18px;

    background:
        rgba(255,255,255,.14);

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:17px;

    transition:.35s;

    box-shadow:
        inset 0 1px 1px rgba(255,255,255,.12);

}

.sidebar-link:hover .icon-box{

    transform:
        rotate(-8deg)
        scale(1.1);

    background:
        rgba(255,255,255,.22);

}

/* =========================
   BADGE
========================= */

.sidebar-badge{

    margin-left:auto;

    width:30px;
    height:30px;

    border-radius:50%;

    display:flex;

    align-items:center;

    justify-content:center;

    background:
        rgba(255,255,255,.18);

    border:
        1px solid rgba(255,255,255,.14);

    color:white;

    font-size:11px;

    font-weight:600;

}

/* =========================
   LOGOUT
========================= */

.logout-wrapper{

    margin-top:auto;

    padding-top:40px;

}

.logout-btn{

    height:60px;

    border:none;

    border-radius:26px;

    background:
        linear-gradient(
            135deg,
            rgba(255,255,255,.18),
            rgba(255,255,255,.08)
        );

    color:white;

    font-weight:600;

    transition:.35s;

    backdrop-filter:
        blur(12px);

}

.logout-btn:hover{

    transform:
        translateY(-4px)
        scale(1.02);

    background:
        linear-gradient(
            135deg,
            rgba(239,68,68,.95),
            rgba(220,38,38,.88)
        );

    box-shadow:
        0 18px 36px rgba(239,68,68,.24);

}

/* =========================
   ANIMATION
========================= */

.fade-in{

    animation:fadeIn 1s ease;

}

@keyframes fadeIn{

    from{
        opacity:0;
        transform:
            translateY(-15px);
    }

    to{
        opacity:1;
        transform:
            translateY(0);
    }

}

/* =========================
   MOBILE
========================= */

@media(max-width:992px){

    .sidebar-modern{

        width:100%;

        min-height:auto;

        border-radius:
            0 0 36px 36px;

    }

    .sidebar-content{

        min-height:auto;

        padding:120px 20px 30px;

    }

}

</style>