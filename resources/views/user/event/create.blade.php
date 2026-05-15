@extends('layouts.app')

@section('title', 'Tambah Event')

@section('content')

<div class="container-fluid py-4 px-4 bg-light min-vh-100">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold text-dark mb-1">
                Tambah Event
            </h2>

            <p class="text-muted mb-0">
                Buat event baru untuk organisasi Anda
            </p>
        </div>

        <a href="/events"
           class="btn btn-light border rounded-4 px-4 py-2 shadow-sm">

            <i class="fas fa-arrow-left me-2"></i>
            Kembali

        </a>

    </div>



    {{-- CARD --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

        <div class="card-body p-4 p-lg-5">

            <form method="POST"
                  action="/events"
                  enctype="multipart/form-data">

                @csrf

                {{-- INFORMASI DASAR --}}
                <div class="mb-5">

                    <h5 class="fw-bold text-dark mb-4">
                        Informasi Dasar
                    </h5>

                    <div class="row g-4">

                        {{-- TITLE --}}
                        <div class="col-lg-6">

                            <label class="form-label fw-semibold">

                                Nama Event
                                <span class="text-danger">*</span>

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



                        {{-- CATEGORY --}}
                        <div class="col-lg-6">

                            <label class="form-label fw-semibold">
                                Kategori Event
                            </label>

                            <select name="category"
                                    class="form-select modern-input">

                                <option value="">
                                    Pilih kategori event
                                </option>

                                <option value="Seminar">
                                    Seminar
                                </option>

                                <option value="Workshop">
                                    Workshop
                                </option>

                                <option value="Webinar">
                                    Webinar
                                </option>

                                <option value="Kompetisi">
                                    Kompetisi
                                </option>

                                <option value="Pelatihan">
                                    Pelatihan
                                </option>

                            </select>

                        </div>



                        {{-- DESCRIPTION --}}
                        <div class="col-lg-6">

                            <label class="form-label fw-semibold">

                                Deskripsi Event
                                <span class="text-danger">*</span>

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

                            <div class="upload-box">

                                <input type="file"
                                       name="poster"
                                       id="poster-input"
                                       class="d-none"
                                       accept="image/*">

                                <label for="poster-input"
                                       class="upload-label">

                                    {{-- CONTENT --}}
                                    <div id="upload-content" class="upload-content">

                                        <div class="upload-icon">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                        </div>

                                        <h5 class="fw-bold text-dark mb-2">
                                            Klik untuk upload gambar
                                        </h5>

                                        <p class="text-muted mb-0">
                                            JPG, PNG maksimal 2MB
                                        </p>

                                    </div>

                                    {{-- PREVIEW --}}
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

                        {{-- DATE --}}
                        <div class="col-lg-3">

                            <label class="form-label fw-semibold">
                                Tanggal
                            </label>

                            <input type="date"
                                   name="date"
                                   value="{{ old('date') }}"
                                   class="form-control modern-input">

                        </div>



                        {{-- START --}}
                        <div class="col-lg-3">

                            <label class="form-label fw-semibold">
                                Waktu Mulai
                            </label>

                            <input type="time"
                                   name="start_time"
                                   value="{{ old('start_time') }}"
                                   class="form-control modern-input">

                        </div>



                        {{-- END --}}
                        <div class="col-lg-3">

                            <label class="form-label fw-semibold">
                                Waktu Selesai
                            </label>

                            <input type="time"
                                   name="end_time"
                                   value="{{ old('end_time') }}"
                                   class="form-control modern-input">

                        </div>



                        {{-- QUOTA --}}
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



                        {{-- VENUE --}}
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



                        {{-- ADDRESS --}}
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
                <div class="d-flex justify-content-end gap-3 pt-4 border-top">

                    <button type="reset"
                            class="btn btn-light border rounded-4 px-4 py-2">

                        Reset

                    </button>

                    <button type="submit"
                            class="btn btn-primary rounded-4 px-5 py-2 shadow-sm">

                        <i class="fas fa-save me-2"></i>
                        Simpan Event

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>



<style>

body{
    background: #f5f7fb;
}

.card{
    background: #ffffff;
}

.modern-input{
    height: 52px;
    border-radius: 14px;
    border: 1px solid #e5e7eb;
    padding-left: 16px;
    box-shadow: none !important;
    transition: .2s;
}

.modern-textarea{
    border-radius: 14px;
    border: 1px solid #e5e7eb;
    padding: 14px 16px;
    resize: none;
    box-shadow: none !important;
}

.modern-input:focus,
.modern-textarea:focus{
    border-color: #2563eb;
    box-shadow: 0 0 0 4px rgba(37,99,235,.08) !important;
}



/* =========================
   UPLOAD BOX FIXED
========================= */

.upload-box{
    width: 100%;
    min-height: 280px;
    border: 2px dashed #dbe3f0;
    border-radius: 24px;
    background: #fafcff;
    overflow: hidden;
    transition: .3s ease;
    position: relative;
}

.upload-box:hover{
    border-color: #2563eb;
    background: #f4f8ff;
}

.upload-label{
    width: 100%;
    min-height: 280px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    position: relative;
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

.upload-icon{
    width: 85px;
    height: 85px;
    border-radius: 50%;
    background: rgba(37,99,235,.10);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    flex-shrink: 0;
}

.upload-icon i{
    font-size: 38px;
    color: #2563eb;
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



/* MOBILE */

@media(max-width: 768px){

    .upload-box{
        min-height: 240px;
    }

    .upload-label{
        min-height: 240px;
    }

    .preview-image{
        height: 240px;
    }

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

            alert('Ukuran maksimal 2MB');
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