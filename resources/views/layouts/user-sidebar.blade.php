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

                <a class="sidebar-link {{ request()->routeIs('user.events.*') ? 'active' : '' }}"
                   href="{{ route('user.events.index') }}">

                    <div class="icon-box">

                        <i class="fas fa-calendar"></i>

                    </div>

                    <span>
                        Event Saya
                    </span>

                    <span class="sidebar-badge">

                        {{ \App\Models\Event::count() }}

                    </span>

                </a>

            </li>

            {{-- PENDAFTARAN SAYA --}}
            <li class="nav-item">

                <a class="sidebar-link {{ request()->routeIs('user.registration.*') ? 'active' : '' }}"
                   href="{{ route('user.registration.index') }}">

                    <div class="icon-box">

                        <i class="fas fa-clipboard-check"></i>

                    </div>

                    <span>
                        Pendaftaran Saya
                    </span>

                    <span class="sidebar-badge">

                        {{ \App\Models\Registration::where('user_id', auth()->id())->count() }}

                    </span>

                </a>

            </li>

            {{-- TICKET --}}
            <li class="nav-item">

                <a class="sidebar-link {{ request()->routeIs('user.tickets.*') ? 'active' : '' }}"
                   href="{{ route('user.tickets.index') }}">

                    <div class="icon-box">

                        <i class="fas fa-ticket-alt"></i>

                    </div>

                    <span>
                        Ticket Saya
                    </span>

                    <span class="sidebar-badge">

                        {{ \App\Models\Ticket::whereHas('registration', function($q){

                            $q->where('user_id', auth()->id());

                        })->count() }}

                    </span>

                </a>

            </li>

            {{-- SERTIFIKAT --}}
            <li class="nav-item">

                <a class="sidebar-link {{ request()->routeIs('user.certificate.*') ? 'active' : '' }}"
                   href="{{ route('user.certificate.index') }}">

                    <div class="icon-box">

                        <i class="fas fa-award"></i>

                    </div>

                    <span>
                        Sertifikat
                    </span>

                    <span class="sidebar-badge">

                        {{ \App\Models\Certificate::where('user_id', auth()->id())->count() }}

                    </span>

                </a>

            </li>

            {{-- PROFILE --}}
            <li class="nav-item">

                <a class="sidebar-link {{ request()->routeIs('user.profile.*') ? 'active' : '' }}"
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

    min-height:calc(100vh - 110px);

    margin-top:35px;

    margin-right:24px;

    position:relative;

    flex-shrink:0;

    overflow:hidden;

    border-radius:0 40px 40px 0;

    background:
        linear-gradient(
            180deg,
            #2563eb 0%,
            #3b82f6 50%,
            #1d4ed8 100%
        );

    box-shadow:
        0 20px 50px rgba(37,99,235,.18);

}

/* =========================
   CONTENT
========================= */

.sidebar-content{

    position:relative;

    z-index:2;

    display:flex;

    flex-direction:column;

    min-height:calc(100vh - 110px);

    padding:28px 22px 30px;

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
   LOGO
========================= */

.sidebar-logo{

    width:92px;
    height:92px;

    border-radius:32px;

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

    font-size:36px;

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

    font-size:34px;

    font-weight:800;

    margin-bottom:4px;

}

.sidebar-subtitle{

    color:
        rgba(255,255,255,.78);

    font-size:16px;

    font-weight:500;

}

/* =========================
   MENU
========================= */

.sidebar-link{

    display:flex;

    align-items:center;

    gap:16px;

    padding:18px 20px;

    border-radius:30px;

    text-decoration:none;

    color:
        rgba(255,255,255,.95);

    font-weight:600;

    transition:
        all .35s cubic-bezier(.4,0,.2,1);

    position:relative;

    overflow:hidden;

}

.sidebar-link::before{

    content:'';

    position:absolute;

    inset:0;

    background:
        linear-gradient(
            90deg,
            rgba(255,255,255,.16),
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
        translateX(6px);

    background:
        rgba(255,255,255,.14);

    color:white;

}

.sidebar-link.active{

    background:
        linear-gradient(
            135deg,
            rgba(255,255,255,.24),
            rgba(255,255,255,.10)
        );

    box-shadow:
        0 18px 35px rgba(255,255,255,.10);

    color:white;

}

/* =========================
   ICON
========================= */

.icon-box{

    width:52px;
    height:52px;

    border-radius:18px;

    background:
        rgba(255,255,255,.14);

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:18px;

    transition:.35s;

}

.sidebar-link:hover .icon-box{

    transform:
        rotate(-8deg)
        scale(1.08);

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

    font-size:12px;

}

/* =========================
   LOGOUT
========================= */

.logout-wrapper{

    margin-top:auto;

    padding-top:40px;

}

.logout-btn{

    height:64px;

    border:none;

    border-radius:28px;

    background:
        linear-gradient(
            135deg,
            rgba(255,255,255,.18),
            rgba(255,255,255,.08)
        );

    color:white;

    font-weight:700;

    transition:.35s;

    backdrop-filter:
        blur(12px);

}

.logout-btn:hover{

    transform:
        translateY(-4px);

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

        margin-top:20px;

        margin-right:0;

        min-height:auto;

        border-radius:0 0 36px 36px;

    }

    .sidebar-content{

        min-height:auto;

        padding:30px 20px;

    }

}

</style>