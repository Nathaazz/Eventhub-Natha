@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')

<div class="container-fluid profile-page-container">

    <div class="profile-wrapper">

        <div class="card border-0 shadow-lg profile-card">

            {{-- HEADER --}}
            <div class="profile-header">

                <div class="profile-overlay"></div>

                <div class="profile-header-content">

                    {{-- AVATAR --}}
                    <div class="avatar-wrapper">

                        <img id="avatar-preview"

                             src="{{ auth()->user()->avatar
                                    ? Storage::url(auth()->user()->avatar)
                                    : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&size=200&background=2563eb&color=fff' }}"

                             class="profile-avatar"

                             alt="Avatar">

                    </div>

                    {{-- NAME --}}
                    <h2 class="profile-name">

                        {{ auth()->user()->name }}

                    </h2>

                    {{-- EMAIL --}}
                    <p class="profile-email">

                        {{ auth()->user()->email }}

                    </p>

                </div>

            </div>

            {{-- BODY --}}
            <div class="card-body profile-body">

                {{-- ERROR --}}
                @if ($errors->any())

                    <div class="alert alert-danger rounded-4 mb-4">

                        <ul class="mb-0">

                            @foreach ($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                @endif

                {{-- FORM --}}
                <form method="POST"
                      action="{{ route('user.profile.update') }}"
                      enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    {{-- FILE --}}
                    <input type="file"
                           class="d-none"
                           name="avatar"
                           id="avatar-input"
                           accept="image/*">

                    <div class="row">

                        {{-- NAME --}}
                        <div class="col-lg-6 mb-4">

                            <label class="form-label fw-bold">

                                Nama Lengkap

                            </label>

                            <input type="text"
                                   class="form-control profile-input"
                                   name="name"
                                   value="{{ old('name', auth()->user()->name) }}">

                        </div>

                        {{-- EMAIL --}}
                        <div class="col-lg-6 mb-4">

                            <label class="form-label fw-bold">

                                Email

                            </label>

                            <input type="email"
                                   class="form-control profile-input"
                                   name="email"
                                   value="{{ old('email', auth()->user()->email) }}">

                        </div>

                        {{-- PHONE --}}
                        <div class="col-lg-6 mb-4">

                            <label class="form-label fw-bold">

                                Nomor Telepon

                            </label>

                            <input type="text"
                                   class="form-control profile-input"
                                   name="phone"
                                   value="{{ old('phone', auth()->user()->phone) }}">

                        </div>

                        {{-- ROLE --}}
                        <div class="col-lg-6 mb-4">

                            <label class="form-label fw-bold">

                                Role

                            </label>

                            <input type="text"
                                   class="form-control profile-input bg-light"
                                   value="{{ auth()->user()->role }}"
                                   readonly>

                        </div>

                        {{-- PASSWORD --}}
                        <div class="col-lg-6 mb-4">

                            <label class="form-label fw-bold">

                                Password Baru

                            </label>

                            <input type="password"
                                   class="form-control profile-input"
                                   name="password"
                                   placeholder="Kosongkan jika tidak diganti">

                        </div>

                        {{-- CONFIRM --}}
                        <div class="col-lg-6 mb-4">

                            <label class="form-label fw-bold">

                                Konfirmasi Password

                            </label>

                            <input type="password"
                                   class="form-control profile-input"
                                   name="password_confirmation">

                        </div>

                    </div>

                    {{-- BUTTON --}}
                    <div class="d-flex flex-wrap gap-3 pt-2">

                        <button type="submit"
                                class="btn-save-profile">

                            <i class="fas fa-save me-2"></i>

                            Simpan Perubahan

                        </button>

                        <a href="{{ url()->previous() }}"
                           class="btn-back-profile">

                            Kembali

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<style>

/* =========================
   FIX NAVBAR
========================= */

.main-content{

    padding-top:120px !important;

}

/* =========================
   PAGE
========================= */

.profile-page-container{

    padding-left:30px;
    padding-right:30px;
    padding-bottom:30px;

}

/* =========================
   WRAPPER
========================= */

.profile-wrapper{

    max-width:1050px;

    margin:0 auto;

}

/* =========================
   CARD
========================= */

.profile-card{

    border-radius:34px;

    overflow:hidden;

    background:white;

}

/* =========================
   HEADER
========================= */

.profile-header{

    position:relative;

    background:linear-gradient(
        135deg,
        #2563eb,
        #1e40af
    );

    padding:55px 30px;

    overflow:hidden;

}

/* =========================
   OVERLAY
========================= */

.profile-overlay{

    position:absolute;

    inset:0;

    background:
        radial-gradient(
            circle at top right,
            rgba(255,255,255,.16),
            transparent 28%
        );

}

/* =========================
   CONTENT
========================= */

.profile-header-content{

    position:relative;

    z-index:2;

    text-align:center;

}

/* =========================
   AVATAR
========================= */

.avatar-wrapper{

    margin-bottom:18px;

}

.profile-avatar{

    width:130px;
    height:130px;

    border-radius:50%;

    object-fit:cover;

    cursor:pointer;

    border:5px solid rgba(255,255,255,.9);

    box-shadow:
        0 10px 30px rgba(0,0,0,.18);

    transition:.3s;

}

.profile-avatar:hover{

    transform:scale(1.04);

}

/* =========================
   NAME
========================= */

.profile-name{

    color:white;

    font-size:42px;

    font-weight:800;

    margin-bottom:6px;

}

/* =========================
   EMAIL
========================= */

.profile-email{

    color:rgba(255,255,255,.82);

    font-size:18px;

    margin:0;

}

/* =========================
   BODY
========================= */

.profile-body{

    padding:42px;

}

/* =========================
   INPUT
========================= */

.profile-input{

    height:58px;

    border:none;

    border-radius:18px;

    background:#f8fafc;

    padding:0 20px;

    font-size:15px;

    transition:.25s;

}

.profile-input:focus{

    background:white;

    border:2px solid #2563eb;

    box-shadow:none;

}

/* =========================
   BUTTON SAVE
========================= */

.btn-save-profile{

    border:none;

    height:56px;

    padding:0 34px;

    border-radius:18px;

    background:linear-gradient(
        135deg,
        #2563eb,
        #1d4ed8
    );

    color:white;

    font-weight:700;

    transition:.3s;

}

.btn-save-profile:hover{

    transform:translateY(-2px);

}

/* =========================
   BUTTON BACK
========================= */

.btn-back-profile{

    height:56px;

    padding:0 34px;

    border-radius:18px;

    background:#f1f5f9;

    color:#0f172a;

    text-decoration:none;

    display:flex;

    align-items:center;

    justify-content:center;

    font-weight:700;

    transition:.3s;

}

.btn-back-profile:hover{

    background:#e2e8f0;

    color:#0f172a;

}

/* =========================
   MOBILE
========================= */

@media(max-width:992px){

    .profile-page-container{

        padding-left:15px;
        padding-right:15px;

    }

    .profile-name{

        font-size:34px;

    }

    .profile-email{

        font-size:15px;

    }

    .profile-avatar{

        width:110px;
        height:110px;

    }

    .profile-body{

        padding:28px 20px;

    }

}

</style>

@push('scripts')

<script>

document.getElementById('avatar-preview')

    .addEventListener('click', function () {

        document.getElementById('avatar-input').click();

});

document.getElementById('avatar-input')

    .addEventListener('change', function (e) {

        const file = e.target.files[0];

        if (file) {

            const reader = new FileReader();

            reader.onload = function (e) {

                document.getElementById('avatar-preview')

                    .src = e.target.result;

            };

            reader.readAsDataURL(file);

        }

});

</script>

@endpush

@endsection