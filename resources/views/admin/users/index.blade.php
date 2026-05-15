@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-5">
    <h1 class="h2 fw-bold">
        <i class="fas fa-users-cog me-3 text-primary"></i>Kelola Pengguna
    </h1>
    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
        <i class="fas fa-user-plus me-2"></i>Tambah Admin
    </a>
</div>

<!-- Users Table -->
<div class="card shadow-lg border-0">
    <div class="card-header bg-transparent pb-0">
        <h5 class="fw-bold mb-3">
            <i class="fas fa-list me-2 text-primary"></i>Daftar Pengguna
        </h5>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Terdaftar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dynamic data will be populated here -->
                    @for($i = 1; $i <= 10; $i++)
                        <tr>
                            <td>
                                <div class="fw-bold">Admin User {{ $i }}</div>
                                <small class="text-muted">0812-3456-{{ str_pad($i, 4, '0', STR_PAD_LEFT) }}</small>
                            </td>
                            <td>admin{{ $i }}@eventhub.com</td>
                            <td>
                                <span class="badge bg-danger px-3 py-2">Admin</span>
                            </td>
                            <td>2 hari lalu</td>
                            <td>
                                <span class="badge bg-success">Aktif</span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-primary"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-outline-warning"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection