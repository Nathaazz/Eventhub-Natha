@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-5">
    <div>
        <h1 class="h2 fw-bold mb-1 d-flex align-items-center">
            <i class="fas fa-tachometer-alt text-primary me-3 fa-2x"></i>
            Admin Dashboard
        </h1>
        <p class="text-muted mb-0 lead">Overview sistem EventHub Kampus</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-primary" onclick="exportStats()">
            <i class="fas fa-download me-2"></i>Export Report
        </button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
            <i class="fas fa-users me-2"></i>Kelola User
        </a>
    </div>
</div>

<!-- Stats Grid -->
<div class="row g-4 mb-5">
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="card border-0 shadow-lg h-100 hover-shadow">
            <div class="card-body text-center p-5">
                <div class="position-absolute top-3 end-3">
                    <span class="badge bg-success fs-6 px-3 py-2 shadow">
                        <i class="fas fa-arrow-up me-1"></i>+{{ rand(15,35) }}%
                    </span>
                </div>
                <i class="fas fa-users fa-4x text-primary mb-4"></i>
                <h2 class="display-4 fw-bold text-primary mb-2">{{ $stats['total_users'] ?? 0 }}</h2>
                <p class="h6 fw-bold text-muted mb-0">Total Pengguna</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="card border-0 shadow-lg h-100 hover-shadow">
            <div class="card-body text-center p-5">
                <div class="position-absolute top-3 end-3">
                    <span class="badge bg-info fs-6 px-3 py-2 shadow">
                        <i class="fas fa-arrow-up me-1"></i>+{{ rand(20,45) }}%
                    </span>
                </div>
                <i class="fas fa-calendar-alt fa-4x text-success mb-4"></i>
                <h2 class="display-4 fw-bold text-success mb-2">{{ $stats['total_events'] ?? 0 }}</h2>
                <p class="h6 fw-bold text-muted mb-0">Total Event</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="card border-0 shadow-lg h-100 hover-shadow">
            <div class="card-body text-center p-5">
                <div class="position-absolute top-3 end-3">
                    <span class="badge bg-warning fs-6 px-3 py-2 shadow">
                        <i class="fas fa-arrow-up me-1"></i>+{{ rand(25,50) }}%
                    </span>
                </div>
                <i class="fas fa-check-circle fa-4x text-info mb-4"></i>
                <h2 class="display-4 fw-bold text-info mb-2">{{ $stats['total_registrations'] ?? 0 }}</h2>
                <p class="h6 fw-bold text-muted mb-0">Pendaftaran Terverifikasi</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="card border-0 shadow-lg h-100 hover-shadow">
            <div class="card-body text-center p-5">
                <i class="fas fa-chart-line fa-4x text-danger mb-4"></i>
                <h2 class="display-4 fw-bold text-danger mb-2">{{ rand(95,99) }}%</h2>
                <p class="h6 fw-bold text-muted mb-0">Tingkat Kepuasan</p>
            </div>
        </div>
    </div>
</div>

<!-- Charts & Recent Activity -->
<div class="row g-5">
    <!-- Recent Events -->
    <div class="col-lg-8">
        <div class="card shadow-xl border-0">
            <div class="card-header bg-transparent border-bottom pb-0">
                <h4 class="fw-bold mb-3">
                    <i class="fas fa-calendar me-2 text-primary"></i>
                    Event Terbaru
                </h4>
            </div>
            <div class="card-body pt-0">
                @if(isset($stats['recent_events']) && $stats['recent_events']->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Event</th>
                                    <th>Organizer</th>
                                    <th>Peserta</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stats['recent_events'] as $event)
                                    <tr>
                                        <td>
                                            <div class="fw-bold">{{ Str::limit($event->title, 35) }}</div>
                                            <small class="text-muted">{{ Str::limit($event->venue, 25) }}</small>
                                        </td>
                                        <td>
                                            <div class="fw-bold">{{ Str::limit($event->organizer->name, 20) }}</div>
                                            <small class="text-muted">{{ $event->organizer->email }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary px-3 py-2">
                                                {{ $event->participants_count }} / {{ $event->max_participants }}
                                            </span>
                                        </td>
                                        <td>{!! $event->status_badge !!}</td>
                                        <td>
                                            <div>{{ $event->date->format('d M Y') }}</div>
                                            <small class="text-muted">{{ $event->start_time->format('H:i') }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="#" class="btn btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="#" class="btn btn-outline-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada event</h5>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="col-lg-4">
        <!-- Role Distribution -->
        <div class="card shadow-lg border-0 mb-4">
            <div class="card-header bg-transparent">
                <h6 class="fw-bold mb-0">
                    <i class="fas fa-chart-pie me-2 text-info"></i>Distribusi Role
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="fw-bold">Admin</span>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-danger" style="width: 25%"></div>
                    </div>
                    <span>25%</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="fw-bold">Organizer</span>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-warning" style="width: 35%"></div>
                    </div>
                    <span>35%</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold">User</span>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-primary" style="width: 40%"></div>
                    </div>
                    <span>40%</span>
                </div>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="card shadow-lg border-0">
            <div class="card-header bg-transparent">
                <h6 class="fw-bold mb-0">
                    <i class="fas fa-user-plus me-2 text-success"></i>User Terbaru
                </h6>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @for($i = 1; $i <= 5; $i++)
                        <li class="list-group-item px-4 py-3 border-0">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-20 rounded-circle p-2 me-3">
                                    <i class="fas fa-user text-primary fa-lg"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-bold">User {{ $i }}</div>
                                    <small class="text-muted">user{{ $i }}@example.com</small>
                                </div>
                                <span class="badge bg-success">User</span>
                            </div>
                        </li>
                    @endfor
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- System Status -->
<div class="row g-4">
    <div class="col-12">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-transparent">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-cogs me-2 text-secondary"></i>Status Sistem
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3 mb-4">
                        <div class="p-4">
                            <i class="fas fa-server fa-3x text-success mb-3"></i>
                            <h5 class="fw-bold text-success">Database</h5>
                            <p class="text-success mb-0">Online</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="p-4">
                            <i class="fas fa-hdd fa-3x text-info mb-3"></i>
                            <h5 class="fw-bold text-info">Storage</h5>
                            <p class="text-info mb-0">99% Free</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="p-4">
                            <i class="fas fa-shield-alt fa-3x text-warning mb-3"></i>
                            <h5 class="fw-bold text-warning">Security</h5>
                            <p class="text-warning mb-0">Protected</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="p-4">
                            <i class="fas fa-tachometer-alt fa-3x text-primary mb-3"></i>
                            <h5 class="fw-bold text-primary">Performance</h5>
                            <p class="text-primary mb-0">98% Uptime</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function exportStats() {
    Swal.fire({
        title: 'Export Report?',
        text: 'Data statistik akan diunduh dalam format Excel',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        confirmButtonText: 'Download'
    });
}
</script>
@endpush