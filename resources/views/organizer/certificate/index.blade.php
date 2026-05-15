@extends('layouts.app')

@section('title', 'Sertifikat')

@section('content')

<div class="container-fluid py-4 px-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h1 class="fw-bold text-dark mb-1">
                Sertifikat
            </h1>

            <p class="text-muted mb-0">
                Kelola sertifikat event peserta
            </p>

        </div>

    </div>

    {{-- STATS --}}
    <div class="row g-4 mb-4">

        {{-- TOTAL --}}
        <div class="col-xl-3 col-md-6">

            <div class="stats-card">

                <div class="stats-icon blue">

                    <i class="fas fa-file-alt"></i>

                </div>

                <div>

                    <h2>

                        {{ $events->sum(fn($event) => $event->certificates->count()) }}

                    </h2>

                    <p>
                        Total Sertifikat
                    </p>

                </div>

            </div>

        </div>

        {{-- PESERTA --}}
        <div class="col-xl-3 col-md-6">

            <div class="stats-card">

                <div class="stats-icon green">

                    <i class="fas fa-users"></i>

                </div>

                <div>

                    <h2>

                        {{ $events->sum(fn($event) => $event->registrations->count()) }}

                    </h2>

                    <p>
                        Total Peserta
                    </p>

                </div>

            </div>

        </div>

        {{-- EVENT --}}
        <div class="col-xl-3 col-md-6">

            <div class="stats-card">

                <div class="stats-icon purple">

                    <i class="fas fa-calendar"></i>

                </div>

                <div>

                    <h2>

                        {{ $events->count() }}

                    </h2>

                    <p>
                        Total Event
                    </p>

                </div>

            </div>

        </div>

        {{-- READY --}}
        <div class="col-xl-3 col-md-6">

            <div class="stats-card">

                <div class="stats-icon orange">

                    <i class="fas fa-award"></i>

                </div>

                <div>

                    <h2>

                        {{ $events->where('status', 'selesai')->count() }}

                    </h2>

                    <p>
                        Siap Generate
                    </p>

                </div>

            </div>

        </div>

    </div>

    {{-- TABLE --}}
    <div class="card border-0 shadow-lg rounded-5 overflow-hidden">

        {{-- HEADER --}}
        <div class="p-4 border-bottom bg-white">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <h4 class="fw-bold mb-0">
                    Daftar Sertifikat
                </h4>

                {{-- SEARCH --}}
                <form method="GET">

                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           class="form-control search-input"
                           placeholder="Cari nama event...">

                </form>

            </div>

        </div>

        {{-- TABLE --}}
        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th class="px-4 py-4">
                            Event
                        </th>

                        <th>
                            Tanggal
                        </th>

                        <th>
                            Sertifikat
                        </th>

                        <th>
                            Peserta
                        </th>

                        <th>
                            Status
                        </th>

                        <th class="text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($events as $event)

                        <tr>

                            {{-- EVENT --}}
                            <td class="px-4 py-4">

                                <div class="fw-bold">

                                    {{ $event->title }}

                                </div>

                            </td>

                            {{-- DATE --}}
                            <td>

                                {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}

                            </td>

                            {{-- CERTIFICATE --}}
                            <td>

                                {{ $event->certificates->count() }}

                            </td>

                            {{-- PARTICIPANT --}}
                            <td>

                                {{ $event->registrations->count() }}

                            </td>

                            {{-- STATUS --}}
                            <td>

                                @if($event->certificates->count() > 0)

                                    <span class="badge-status success">

                                        Diterbitkan

                                    </span>

                                @else

                                    <span class="badge-status warning">

                                        Draft

                                    </span>

                                @endif

                            </td>

                            {{-- ACTION --}}
<td class="text-center">

    <div class="d-flex justify-content-center gap-2">

        {{-- BUAT TEMPLATE --}}
        <a href="{{ route('organizer.certificates.create', $event->id) }}"
           class="btn btn-primary rounded-4 px-4">

            <i class="fas fa-pen-nib me-2"></i>

            Buat Sertifikat

        </a>

        {{-- GENERATE --}}
        @if($event->certificate_title)

            <form action="{{ route('organizer.certificates.generate', $event->id) }}"
                  method="POST">

                @csrf

                <button type="submit"
                        class="btn btn-success rounded-4 px-4">

                    <i class="fas fa-award me-2"></i>

                    Generate

                </button>

            </form>

        @endif

    </div>

</td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="text-center py-5">

                                Belum ada event

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        <div class="p-4">

            {{ $events->links() }}

        </div>

    </div>

</div>

<style>

body{
    background:#f4f7fb;
}

.stats-card{
    background:white;
    border-radius:28px;
    padding:28px;
    display:flex;
    align-items:center;
    gap:18px;
    box-shadow:0 10px 30px rgba(0,0,0,.05);
}

.stats-card h2{
    font-size:38px;
    font-weight:800;
    margin-bottom:4px;
}

.stats-card p{
    color:#64748b;
    margin:0;
}

.stats-icon{
    width:72px;
    height:72px;
    border-radius:24px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:28px;
}

.stats-icon.blue{
    background:#dbeafe;
    color:#2563eb;
}

.stats-icon.green{
    background:#dcfce7;
    color:#16a34a;
}

.stats-icon.purple{
    background:#f3e8ff;
    color:#9333ea;
}

.stats-icon.orange{
    background:#ffedd5;
    color:#ea580c;
}

.search-input{
    width:260px;
    border-radius:16px;
    border:none;
    background:#f8fafc;
    height:50px;
    padding:0 20px;
}

.badge-status{
    padding:10px 16px;
    border-radius:999px;
    font-size:13px;
    font-weight:700;
}

.badge-status.success{
    background:#dcfce7;
    color:#16a34a;
}

.badge-status.warning{
    background:#fef3c7;
    color:#d97706;
}

</style>

@endsection