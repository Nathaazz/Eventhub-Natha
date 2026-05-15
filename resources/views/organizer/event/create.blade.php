@extends('layouts.app')

@section('title', 'Tambah Event')

@section('content')

<div class="container-fluid py-4 px-4 bg-light min-vh-100">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Tambah Event</h2>
            <p class="text-muted mb-0">Buat event baru untuk organisasi Anda</p>
        </div>

        <a href="{{ route('organizer.events.index') }}"
           class="btn btn-white border rounded-4 px-4 py-2 shadow-sm">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

        <div class="card-body p-4 p-lg-5">

            <form method="POST"
                  action="{{ route('organizer.events.store') }}"
                  enctype="multipart/form-data">

                @csrf

                {{-- INFORMASI DASAR --}}
                <div class="mb-5">

                    <h5 class="fw-bold text-dark mb-4">
                        Informasi Dasar
                    </h5>

                    <div class="row g-4">

                        {{-- NAMA EVENT --}}
                        <div class="col-lg-6">

                            <label class="form-label fw-semibold">
                                Nama Event <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   name="title"
                                   value="{{ old('title') }}"
                                   class="form-control modern-input @error('title') is-invalid @enderror"
                                   placeholder="Contoh: Seminar Digital Marketing 2025">

                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- KATEGORI --}}
                        <div class="col-lg-6">

                            <label class="form-label fw-semibold">
                                Kategori Event
                            </label>

                            <select name="category"
                                    class="form-select modern-input">

                                <option selected disabled>
                                    Pilih kategori event
                                </option>

                                <option value="Seminar">Seminar</option>
                                <option value="Workshop">Workshop</option>
                                <option value="Pelatihan">Pelatihan</option>
                                <option value="Webinar">Webinar</option>
                                <option value="Kompetisi">Kompetisi</option>

                            </select>

                        </div>

                        {{-- DESKRIPSI --}}
                        <div class="col-lg-6">

                            <label class="form-label fw-semibold">
                                Deskripsi Event <span class="text-danger">*</span>
                            </label>

                            <textarea name="description"
                                      rows="7"
                                      class="form-control modern-textarea @error('description') is-invalid @enderror"
                                      placeholder="Tuliskan deskripsi lengkap tentang event Anda...">{{ old('description') }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- POSTER --}}
                        <div class="col-lg-6">

                            <label class="form-label fw-semibold mb-3">
                                Poster / Banner Event
                            </label>

                            <div class="upload-area">

                                <input type="file"
                                       name="poster"
                                       id="poster-input"
                                       accept="image/*"
                                       hidden>

                                <label for="poster-input"
                                       class="upload-label">

                                    <div id="upload-content"
                                         class="upload-content">

                                        <h5 class="fw-bold text-dark mb-2">
                                            Klik untuk upload gambar
                                        </h5>

                                        <p class="text-muted mb-0">
                                            JPG, PNG maksimal 2MB
                                        </p>

                                    </div>

                                    <img id="preview-image"
                                         class="preview-image d-none">

                                </label>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- DETAIL EVENT --}}
                <div class="mb-5">

                    <h5 class="fw-bold text-dark mb-4">
                        Detail Event
                    </h5>

                    <div class="row g-4">

                        {{-- TANGGAL --}}
                        <div class="col-lg-3">

                            <label class="form-label fw-semibold">
                                Tanggal Mulai
                            </label>

                            <input type="date"
                                   name="date"
                                   value="{{ old('date') }}"
                                   class="form-control modern-input">

                        </div>

                        {{-- WAKTU MULAI --}}
                        <div class="col-lg-3">

                            <label class="form-label fw-semibold">
                                Waktu Mulai
                            </label>

                            <input type="time"
                                   name="start_time"
                                   value="{{ old('start_time') }}"
                                   class="form-control modern-input">

                        </div>

                        {{-- WAKTU SELESAI --}}
                        <div class="col-lg-3">

                            <label class="form-label fw-semibold">
                                Waktu Selesai
                            </label>

                            <input type="time"
                                   name="end_time"
                                   value="{{ old('end_time') }}"
                                   class="form-control modern-input">

                        </div>

                        {{-- KUOTA --}}
                        <div class="col-lg-3">

                            <label class="form-label fw-semibold">
                                Kuota Peserta
                            </label>

                            <input type="number"
                                   name="max_participants"
                                   value="{{ old('max_participants') }}"
                                   class="form-control modern-input"
                                   placeholder="100">

                        </div>

                        {{-- LOKASI --}}
                        <div class="col-lg-6">

                            <label class="form-label fw-semibold">
                                Lokasi Event
                            </label>

                            <input type="text"
                                   name="venue"
                                   value="{{ old('venue') }}"
                                   class="form-control modern-input"
                                   placeholder="Masukkan lokasi event">

                        </div>

                        {{-- ALAMAT --}}
                        <div class="col-lg-6">

                            <label class="form-label fw-semibold">
                                Alamat Lengkap
                            </label>

                            <input type="text"
                                   name="address"
                                   value="{{ old('address') }}"
                                   class="form-control modern-input"
                                   placeholder="Masukkan alamat lengkap">

                        </div>

                    </div>

                </div>

                {{-- BUTTON --}}
                <div class="d-flex justify-content-end gap-3 border-top pt-4">

                    <button type="reset"
                            class="btn btn-light border rounded-4 px-4 py-2">
                        Reset
                    </button>

                    <button type="submit"
                            class="btn btn-primary rounded-4 px-5 py-2 shadow-sm">
                        Simpan Event
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<style>

body{
    background: #f4f7fb;
}

.card{
    background: #ffffff;
}

/* INPUT */

.modern-input{
    height: 54px;
    border-radius: 16px;
    border: 1px solid #e4e7ec;
    padding-left: 16px;
    box-shadow: none !important;
    transition: all .2s ease;
    background: #fff;
}

.modern-textarea{
    border-radius: 16px;
    border: 1px solid #e4e7ec;
    padding: 16px;
    resize: none;
    box-shadow: none !important;
    transition: all .2s ease;
}

.modern-input:focus,
.modern-textarea:focus{
    border-color: #2563eb;
    box-shadow: 0 0 0 4px rgba(37,99,235,.08) !important;
}

/* UPLOAD */

.upload-area{
    width: 100%;
    min-height: 280px;
    border: 2px dashed #d7dfeb;
    border-radius: 24px;
    background: #fafcff;
    overflow: hidden;
    transition: .3s ease;
    position: relative;
}

.upload-area:hover{
    border-color: #2563eb;
    background: #f5f9ff;
}

.upload-label{
    width: 100%;
    min-height: 280px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    padding: 30px;
}

.upload-content{
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
}

.preview-image{
    width: 100%;
    height: 280px;
    object-fit: cover;
    border-radius: 20px;
}

/* BUTTON */

.btn-primary{
    background: #2563eb;
    border: none;
}

.btn-primary:hover{
    background: #1d4ed8;
}

.btn-white{
    background: #ffffff;
}

</style>

@push('scripts')

<script>

const posterInput = document.getElementById('poster-input');
const previewImage = document.getElementById('preview-image');
const uploadContent = document.getElementById('upload-content');

posterInput.addEventListener('change', function(e){

    const file = e.target.files[0];

    if(file){

        if(file.size > 2 * 1024 * 1024){

            alert('Ukuran file maksimal 2MB');

            posterInput.value = '';

            return;
        }

        const reader = new FileReader();

        reader.onload = function(event){

            previewImage.src = event.target.result;

            previewImage.classList.remove('d-none');

            uploadContent.classList.add('d-none');

        }

        reader.readAsDataURL(file);

    }

});

</script>

@endpush

@endsection