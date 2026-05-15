@extends('layouts.app')

@section('title', 'Edit Event')

@section('content')

<div class="container-fluid py-4 px-4 bg-light min-vh-100">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold text-dark mb-1">
                Edit Event
            </h2>

            <p class="text-muted mb-0">
                Perbarui informasi event Anda
            </p>

        </div>

        <a href="{{ route('organizer.events.index') }}"
           class="btn btn-light border rounded-4 px-4 py-2 shadow-sm">

            <i class="fas fa-arrow-left me-2"></i>
            Kembali

        </a>

    </div>

    {{-- ERROR --}}
    @if ($errors->any())

        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">

            <ul class="mb-0">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    {{-- CARD --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

        <div class="card-body p-4 p-lg-5">

            {{-- FINAL FIX --}}
            <form action="{{ url('/organizer/events/' . $event->id . '/update') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                {{-- BASIC INFO --}}
                <div class="mb-5">

                    <h5 class="fw-bold text-dark mb-4">
                        Informasi Dasar
                    </h5>

                    <div class="row g-4">

                        {{-- TITLE --}}
                        <div class="col-lg-6">

                            <label class="form-label fw-semibold">
                                Nama Event
                            </label>

                            <input type="text"
                                   name="title"
                                   value="{{ old('title', $event->title) }}"
                                   class="form-control modern-input"
                                   required>

                        </div>

                        {{-- CATEGORY --}}
                        <div class="col-lg-6">

                            <label class="form-label fw-semibold">
                                Kategori Event
                            </label>

                            <select name="category"
                                    class="form-select modern-input">

                                <option value="">
                                    Pilih Kategori
                                </option>

                                <option value="Seminar"
                                    {{ old('category', $event->category) == 'Seminar' ? 'selected' : '' }}>
                                    Seminar
                                </option>

                                <option value="Workshop"
                                    {{ old('category', $event->category) == 'Workshop' ? 'selected' : '' }}>
                                    Workshop
                                </option>

                                <option value="Webinar"
                                    {{ old('category', $event->category) == 'Webinar' ? 'selected' : '' }}>
                                    Webinar
                                </option>

                                <option value="Kompetisi"
                                    {{ old('category', $event->category) == 'Kompetisi' ? 'selected' : '' }}>
                                    Kompetisi
                                </option>

                                <option value="Pelatihan"
                                    {{ old('category', $event->category) == 'Pelatihan' ? 'selected' : '' }}>
                                    Pelatihan
                                </option>

                            </select>

                        </div>

                        {{-- DESCRIPTION --}}
                        <div class="col-lg-6">

                            <label class="form-label fw-semibold">
                                Deskripsi Event
                            </label>

                            <textarea name="description"
                                      rows="7"
                                      class="form-control modern-textarea"
                                      required>{{ old('description', $event->description) }}</textarea>

                        </div>

                        {{-- POSTER --}}
                        <div class="col-lg-6">

                            <label class="form-label fw-semibold">
                                Poster Event
                            </label>

                            <div class="upload-box rounded-4 text-center p-4">

                                <input type="file"
                                       name="poster"
                                       id="poster-input"
                                       class="d-none"
                                       accept="image/*">

                                <label for="poster-input"
                                       class="cursor-pointer w-100">

                                    @if($event->poster_path)

                                        <img src="{{ asset('storage/' . $event->poster_path) }}"
                                             id="preview-image"
                                             class="img-fluid rounded-4 shadow-sm preview-image">

                                    @else

                                        <div id="upload-content">

                                            <div class="upload-icon mb-3">

                                                <i class="fas fa-cloud-upload-alt"></i>

                                            </div>

                                            <h6 class="fw-semibold text-dark">
                                                Klik untuk upload gambar
                                            </h6>

                                            <p class="text-muted small mb-0">
                                                JPG, PNG maksimal 2MB
                                            </p>

                                        </div>

                                    @endif

                                </label>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- DETAIL --}}
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
                                   value="{{ old('date', \Carbon\Carbon::parse($event->date)->format('Y-m-d')) }}"
                                   class="form-control modern-input"
                                   required>

                        </div>

                        {{-- START --}}
                        <div class="col-lg-3">

                            <label class="form-label fw-semibold">
                                Waktu Mulai
                            </label>

                            <input type="time"
                                   name="start_time"
                                   value="{{ old('start_time', $event->start_time) }}"
                                   class="form-control modern-input"
                                   required>

                        </div>

                        {{-- END --}}
                        <div class="col-lg-3">

                            <label class="form-label fw-semibold">
                                Waktu Selesai
                            </label>

                            <input type="time"
                                   name="end_time"
                                   value="{{ old('end_time', $event->end_time) }}"
                                   class="form-control modern-input"
                                   required>

                        </div>

                        {{-- QUOTA --}}
                        <div class="col-lg-3">

                            <label class="form-label fw-semibold">
                                Kuota Peserta
                            </label>

                            <input type="number"
                                   name="max_participants"
                                   value="{{ old('max_participants', $event->max_participants) }}"
                                   class="form-control modern-input">

                        </div>

                        {{-- VENUE --}}
                        <div class="col-lg-6">

                            <label class="form-label fw-semibold">
                                Lokasi Event
                            </label>

                            <input type="text"
                                   name="venue"
                                   value="{{ old('venue', $event->venue) }}"
                                   class="form-control modern-input"
                                   required>

                        </div>

                        {{-- ADDRESS --}}
                        <div class="col-lg-6">

                            <label class="form-label fw-semibold">
                                Alamat Lengkap
                            </label>

                            <input type="text"
                                   name="address"
                                   value="{{ old('address', $event->address) }}"
                                   class="form-control modern-input">

                        </div>

                    </div>

                </div>

                {{-- BUTTON --}}
                <div class="d-flex justify-content-end gap-3 pt-4 border-top">

                    <a href="{{ route('organizer.events.index') }}"
                       class="btn btn-light border rounded-4 px-4 py-2">

                        Batal

                    </a>

                    <button type="submit"
                            class="btn btn-primary rounded-4 px-5 py-2 shadow-sm">

                        <i class="fas fa-save me-2"></i>
                        Update Event

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection