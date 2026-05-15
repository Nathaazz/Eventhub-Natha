@extends('layouts.user-app')

@section('title', 'Profile')

@section('content')

<style>

/* =========================
   HILANGKAN NAVBAR ATAS
========================= */

.modern-navbar,
.navbar,
header{

    display:none !important;

}

/* =========================
   FULL LAYOUT FIX
========================= */

.main-content{

    padding-top:30px !important;

}

.content-wrapper{

    margin-left:290px;

    width:calc(100% - 290px);

}

@media(max-width:992px){

    .content-wrapper{

        margin-left:0;

        width:100%;

    }

}

/* =========================
   PROFILE WRAPPER
========================= */

.profile-wrapper{

    padding:35px;

    margin-top:0;

}



/* CONTAINER */
.profile-container{

    max-width:1100px;

    margin:auto;

}



/* CARD */
.profile-card{

    background:white;

    border-radius:34px;

    overflow:hidden;

    box-shadow:
        0 15px 40px rgba(0,0,0,.06);

}



/* HEADER */
.profile-header{

    position:relative;

    background:
        linear-gradient(
            135deg,
            #2563eb,
            #1e3a8a
        );

    padding:70px 20px 90px;

    overflow:hidden;

}

.header-pattern{

    position:absolute;

    inset:0;

    background:
        radial-gradient(
            circle at top right,
            rgba(255,255,255,.16),
            transparent 25%
        );

}

.profile-header-content{

    position:relative;

    z-index:2;

    text-align:center;

}



/* AVATAR */
.avatar-wrapper{

    width:145px;
    height:145px;

    margin:auto auto 20px;

}

.profile-avatar,
.profile-avatar-placeholder{

    width:145px;
    height:145px;

    border-radius:50%;

    object-fit:cover;

    background:
        rgba(255,255,255,.14);

    border:
        5px solid rgba(255,255,255,.25);

    backdrop-filter:
        blur(10px);

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:55px;

    color:white;

    font-weight:700;

    box-shadow:
        0 15px 40px rgba(0,0,0,.15);

}



/* TEXT */
.profile-name{

    color:white;

    font-weight:800;

    margin-bottom:6px;

    font-size:42px;

}

.profile-email{

    color:rgba(255,255,255,.75);

    margin:0;

    font-size:18px;

}



/* BODY */
.profile-body{

    padding:45px;

}



/* LABEL */
.modern-label{

    font-weight:700;

    margin-bottom:12px;

    display:block;

    color:#111827;

}



/* INPUT */
.modern-input{

    height:60px;

    border-radius:18px;

    border:1px solid #e5e7eb;

    padding:0 18px;

    box-shadow:none!important;

    transition:.2s;

    font-size:15px;

}

.modern-input:focus{

    border-color:#2563eb;

    box-shadow:
        0 0 0 4px rgba(37,99,235,.08)!important;

}



/* UPLOAD */
.upload-box{

    border:2px dashed #dbe3f0;

    border-radius:24px;

    background:#f9fbff;

    padding:22px;

    transition:.25s;

}

.upload-box:hover{

    border-color:#2563eb;

    background:#f3f7ff;

}

.upload-content{

    display:flex;

    align-items:center;

    gap:18px;

    cursor:pointer;

}

.upload-icon{

    width:64px;
    height:64px;

    border-radius:18px;

    background:
        rgba(37,99,235,.1);

    display:flex;

    align-items:center;

    justify-content:center;

    color:#2563eb;

    font-size:24px;

}



/* BUTTON */
.save-btn{

    background:
        linear-gradient(
            135deg,
            #2563eb,
            #1e40af
        );

    border:none;

    color:white;

    font-weight:700;

    transition:.25s;

}

.save-btn:hover{

    transform:
        translateY(-2px);

    box-shadow:
        0 15px 30px rgba(37,99,235,.2);

}



/* MOBILE */
@media(max-width:991px){

    .profile-wrapper{

        padding:20px;

    }

    .profile-body{

        padding:25px;

    }

    .profile-name{

        font-size:32px;

    }

}

</style>

<div class="profile-wrapper">

    <div class="profile-container">

        <div class="profile-card">

            {{-- HEADER --}}
            <div class="profile-header">

                <div class="header-pattern"></div>

                <div class="profile-header-content">

                    {{-- AVATAR --}}
                    <div class="avatar-wrapper">

                        @if(auth()->user()->avatar)

                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}"
                                 id="preview-image"
                                 class="profile-avatar">

                        @else

                            <div id="preview-image-placeholder"
                                 class="profile-avatar-placeholder">

                                {{ strtoupper(substr(auth()->user()->name,0,1)) }}

                            </div>

                            <img id="preview-image"
                                 class="profile-avatar d-none">

                        @endif

                    </div>

                    {{-- USER --}}
                    <h2 class="profile-name">

                        {{ auth()->user()->name }}

                    </h2>

                    <p class="profile-email">

                        {{ auth()->user()->email }}

                    </p>

                </div>

            </div>

            {{-- BODY --}}
            <div class="profile-body">

                <form method="POST"
                      action="{{ route('user.profile.update') }}"
                      enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="row g-4">

                        {{-- NAME --}}
                        <div class="col-md-6">

                            <label class="modern-label">
                                Nama Lengkap
                            </label>

                            <input type="text"
                                   name="name"
                                   value="{{ old('name', auth()->user()->name) }}"
                                   class="form-control modern-input">

                        </div>

                        {{-- EMAIL --}}
                        <div class="col-md-6">

                            <label class="modern-label">
                                Email
                            </label>

                            <input type="email"
                                   name="email"
                                   value="{{ old('email', auth()->user()->email) }}"
                                   class="form-control modern-input">

                        </div>

                        {{-- PHONE --}}
                        <div class="col-md-6">

                            <label class="modern-label">
                                Nomor HP
                            </label>

                            <input type="text"
                                   name="phone"
                                   value="{{ old('phone', auth()->user()->phone) }}"
                                   class="form-control modern-input"
                                   placeholder="Masukkan nomor HP">

                        </div>

                        {{-- PHOTO --}}
                        <div class="col-12">

                            <label class="modern-label">
                                Foto Profile
                            </label>

                            <div class="upload-box">

                                <input type="file"
                                       name="avatar"
                                       id="avatar-input"
                                       accept="image/*"
                                       class="d-none">

                                <label for="avatar-input"
                                       class="upload-content">

                                    <div class="upload-icon">

                                        <i class="fas fa-camera"></i>

                                    </div>

                                    <div>

                                        <h6 class="fw-bold mb-1">
                                            Upload Foto Baru
                                        </h6>

                                        <small class="text-muted">
                                            PNG, JPG maksimal 2MB
                                        </small>

                                    </div>

                                </label>

                            </div>

                        </div>

                    </div>

                    {{-- BUTTON --}}
                    <div class="text-end mt-5">

                        <button type="submit"
                                class="btn save-btn rounded-4 px-5 py-3">

                            <i class="fas fa-save me-2"></i>
                            Simpan Perubahan

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<script>

document.getElementById('avatar-input')
.addEventListener('change', function(e){

    const file = e.target.files[0];

    if(file){

        const reader = new FileReader();

        reader.onload = function(event){

            const image =
                document.getElementById('preview-image');

            image.src = event.target.result;

            image.classList.remove('d-none');

            const placeholder =
                document.getElementById('preview-image-placeholder');

            if(placeholder){

                placeholder.style.display = 'none';

            }

        }

        reader.readAsDataURL(file);

    }

});

</script>

@endsection