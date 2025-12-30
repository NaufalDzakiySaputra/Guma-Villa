@extends('layouts.admin')

@section('page-title', 'Kelola User')
@section('page-subtitle', 'Manajemen user dan akses admin')
@section('page-actions')
    <a href="{{ route('admin.users.create') }}" class="btn btn-success">
        <i class="fas fa-plus"></i> Tambah User
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="60">ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Tanggal Daftar</th>
                        <th width="150" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="text-muted">#{{ $user->id }}</td>
                        <td>
                            <div class="fw-bold">{{ $user->name }}</div>
                            @if($user->id === auth()->id())
                                <small class="text-primary">
                                    <i class="fas fa-user-circle me-1"></i> Anda
                                </small>
                            @endif
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @php
                                $badgeColors = [
                                    'admin' => 'badge-success',
                                    'user' => 'badge-info'
                                ];
                            @endphp
                            <span class="badge {{ $badgeColors[$user->role] ?? 'badge-secondary' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="text-muted">
                            {{ $user->created_at->format('d/m/Y') }}
                        </td>
                        <td class="text-end">
                            <div class="d-flex gap-1 justify-content-end">
                                <a href="{{ route('admin.users.edit', $user->id) }}" 
                                   class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Hapus user {{ addslashes($user->name) }}?\\n\\nUser #{{ $user->id }} akan dihapus permanen!')">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-outline-danger"
                                            {{ $user->id === auth()->id() ? 'disabled' : '' }}
                                            title="{{ $user->id === auth()->id() ? 'Tidak dapat menghapus akun sendiri' : 'Hapus user' }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="card-footer text-muted small">
        Total: {{ $users->count() }} user
    </div>
</div>
@endsection