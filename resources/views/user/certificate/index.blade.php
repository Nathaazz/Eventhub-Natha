@extends('layouts.user-app')

@section('title', 'Sertifikat Saya')

@section('content')

<div class="certificate-page">

    <div class="certificate-container">

        {{-- HEADER --}}
        <div class="certificate-header">

            <h1 class="page-title">
                Sertifikat Saya
            </h1>

            <p class="page-subtitle">
                Semua sertifikat event yang telah kamu dapatkan
            </p>

        </div>

        {{-- ALERT --}}
        @if(session('success'))

            <div class="alert alert-success border-0 rounded-4 shadow-sm mb-4">

                <i class="fas fa-check-circle me-2"></i>

                {{ session('success') }}

            </div>

        @endif

        @if(session('error'))

            <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4">

                <i class="fas fa-exclamation-circle me-2"></i>

                {{ session('error') }}

            </div>

        @endif

        {{-- STATS --}}
        <div class="row g-4 mb-4">

            <div class="col-xl-4 col-md-6">

                <div class="stats-card">

                    <div class="stats-icon blue">

                        <i class="fas fa-file-alt"></i>

                    </div>

                    <div>

                        <h2>
                            {{ $certificates->total() }}
                        </h2>

                        <p>
                            Total Sertifikat
                        </p>

                    </div>

                </div>

            </div>

            <div class="col-xl-4 col-md-6">

                <div class="stats-card">

                    <div class="stats-icon purple">

                        <i class="fas fa-calendar"></i>

                    </div>

                    <div>

                        <h2>
                            {{ $certificates->pluck('event_id')->unique()->count() }}
                        </h2>

                        <p>
                            Total Event
                        </p>

                    </div>

                </div>

            </div>

            <div class="col-xl-4 col-md-12">

                <div class="stats-card">

                    <div class="stats-icon green">

                        <i class="fas fa-award"></i>

                    </div>

                    <div>

                        <h2>
                            {{ $certificates->count() }}
                        </h2>

                        <p>
                            Sertifikat Tersedia
                        </p>

                    </div>

                </div>

            </div>

        </div>

        {{-- TABLE --}}
        <div class="certificate-card">

            <div class="certificate-top">

                <h4 class="fw-bold mb-0">
                    Daftar Sertifikat
                </h4>

                <form method="GET">

                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           class="form-control search-input"
                           placeholder="Cari nama event...">

                </form>

            </div>

            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <thead>

                        <tr>

                            <th class="px-4 py-4">
                                Nama Event
                            </th>

                            <th>
                                Nomor Sertifikat
                            </th>

                            <th>
                                Tanggal
                            </th>

                            <th class="text-center">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($certificates as $certificate)

                            <tr>

                                <td class="px-4 py-4">

                                    <div class="fw-bold text-dark">

                                        {{ $certificate->event->title ?? '-' }}

                                    </div>

                                </td>

                                <td>

                                    {{ $certificate->certificate_number }}

                                </td>

                                <td>

                                    {{ $certificate->created_at->format('d M Y') }}

                                </td>

                                <td class="text-center">

                                    <a href="{{ route('user.certificate.download', $certificate->certificate_number) }}"
                                       class="download-btn">

                                        <i class="fas fa-download me-2"></i>

                                        Download

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4"
                                    class="text-center py-5">

                                    <div class="empty-text">

                                        Belum ada sertifikat tersedia

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="pagination-wrapper">

                {{ $certificates->links() }}

            </div>

        </div>

    </div>

</div>

<style>

body{

    background:#f4f7fb;

}

/* PAGE */
.certificate-page{

    width:100%;

    min-height:100vh;

    padding-top:0;

    margin-top:-70px;

    padding-bottom:40px;

}

/* CONTAINER */
.certificate-container{

    width:100%;

    max-width:1350px;

    margin:0 auto;

    padding:0 35px;

}

/* HEADER */
.certificate-header{

    margin-bottom:35px;

}

.page-title{

    font-size:58px;

    font-weight:800;

    color:#0f172a;

    margin-bottom:10px;

    line-height:1.1;

}

.page-subtitle{

    font-size:18px;

    color:#64748b;

}

/* STATS */
.stats-card{

    background:white;

    border-radius:32px;

    padding:32px;

    display:flex;

    align-items:center;

    gap:20px;

    height:100%;

    box-shadow:
        0 10px 30px rgba(0,0,0,.05);

}

.stats-card h2{

    font-size:44px;

    font-weight:800;

    margin-bottom:4px;

}

.stats-card p{

    margin:0;

    color:#64748b;

    font-size:16px;

}

/* ICON */
.stats-icon{

    width:80px;

    height:80px;

    border-radius:26px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:30px;

}

.stats-icon.blue{

    background:#dbeafe;

    color:#2563eb;

}

.stats-icon.purple{

    background:#f3e8ff;

    color:#9333ea;

}

.stats-icon.green{

    background:#dcfce7;

    color:#16a34a;

}

/* CARD */
.certificate-card{

    background:white;

    border-radius:34px;

    overflow:hidden;

    box-shadow:
        0 10px 30px rgba(0,0,0,.05);

}

/* TOP */
.certificate-top{

    padding:28px 32px;

    border-bottom:
        1px solid #eef2f7;

    display:flex;

    align-items:center;

    justify-content:space-between;

    gap:20px;

    flex-wrap:wrap;

}

/* SEARCH */
.search-input{

    width:280px;

    height:54px;

    border:none;

    border-radius:18px;

    background:#f8fafc;

    padding:0 20px;

    box-shadow:none;

}

/* TABLE */
.table{

    margin:0;

}

.table thead th{

    border:none;

    background:#f8fafc;

    color:#64748b;

    font-size:14px;

    font-weight:700;

}

.table tbody td{

    border:none;

    vertical-align:middle;

    padding-top:24px;

    padding-bottom:24px;

}

.table tbody tr{

    border-bottom:
        1px solid #f1f5f9;

}

/* BUTTON */
.download-btn{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    padding:12px 24px;

    border-radius:18px;

    background:#2563eb;

    color:white;

    text-decoration:none;

    font-weight:600;

    transition:.3s;

}

.download-btn:hover{

    background:#1d4ed8;

    transform:
        translateY(-2px);

    color:white;

}

/* EMPTY */
.empty-text{

    color:#94a3b8;

    font-size:16px;

}

/* PAGINATION */
.pagination-wrapper{

    padding:24px 32px;

    border-top:
        1px solid #eef2f7;

}

/* RESPONSIVE */
@media(max-width:992px){

    .certificate-container{

        padding:0 20px;

    }

}

@media(max-width:768px){

    .certificate-page{

        margin-top:0;

    }

    .page-title{

        font-size:42px;

    }

    .search-input{

        width:100%;

    }

}

</style>

@endsection