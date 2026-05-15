@extends('layouts.app')

@section('title', 'Buat Sertifikat')

@section('content')

<div class="container-fluid py-4 px-4">

    <div class="card border-0 shadow-lg rounded-5 overflow-hidden">

        <div class="card-body p-5">

            {{-- HEADER --}}
            <div class="mb-5">

                <h1 class="fw-bold text-dark mb-2">
                    Buat Template Sertifikat
                </h1>

                <p class="text-muted mb-0">

                    {{ $event->title }}

                </p>

            </div>



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
            <form action="{{ route('organizer.certificates.store', $event->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf



                {{-- TITLE --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">

                        Judul Sertifikat

                    </label>

                    <input type="text"
                           name="certificate_title"
                           class="form-control rounded-4 p-3"
                           placeholder="Certificate of Participation"
                           value="{{ old('certificate_title', $event->certificate_title) }}"
                           required>

                </div>



                {{-- DESCRIPTION --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">

                        Deskripsi

                    </label>

                    <textarea name="certificate_description"
                              class="form-control rounded-4 p-3"
                              rows="5"
                              placeholder="Diberikan kepada peserta karena telah mengikuti event"
                              required>{{ old('certificate_description', $event->certificate_description) }}</textarea>

                </div>



                {{-- SIGNATURE --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">

                        Nama Penanda Tangan

                    </label>

                    <input type="text"
                           name="certificate_signature"
                           class="form-control rounded-4 p-3"
                           placeholder="Nama Organizer"
                           value="{{ old('certificate_signature', $event->certificate_signature) }}"
                           required>

                </div>



                {{-- BACKGROUND --}}
                <div class="mb-5">

                    <label class="form-label fw-semibold">

                        Background Sertifikat

                    </label>

                    <input type="file"
                           name="certificate_background"
                           class="form-control rounded-4 p-3">

                    {{-- PREVIEW --}}
                    @if($event->certificate_background)

                        <div class="mt-3">

                            <img src="{{ asset('storage/' . $event->certificate_background) }}"
                                 class="img-fluid rounded-4 shadow-sm"
                                 style="max-height:220px;">

                        </div>

                    @endif

                </div>



                {{-- BUTTON --}}
                <div class="d-flex gap-3 flex-wrap">

                    <button type="submit"
                            class="btn btn-primary rounded-4 px-5 py-3 fw-semibold">

                        <i class="fas fa-save me-2"></i>

                        Simpan Template

                    </button>



                    <a href="{{ route('organizer.certificates.index') }}"
                       class="btn btn-light border rounded-4 px-5 py-3 fw-semibold">

                        Kembali

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection