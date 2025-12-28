@extends('layouts.admin')

@section('page-title', 'Edit User: ' . $user->name)
@section('page-subtitle', 'Perbarui informasi user')
@section('page-actions')
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf @method('PUT')
            
            <div class="row g-3">
                <!-- Kolom Kiri -->
                <div class="col-lg-8">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap *</label>
                        <input type="text" 
                               name="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $user->name) }}"
                               required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" 
                               name="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email', $user->email) }}"
                               required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Password Baru</label>
                            <div class="position-relative">
                                <input type="password" 
                                       name="password" 
                                       id="password"
                                       class="form-control @error('password') is-invalid @enderror pe-5">
                                <!-- UBAH BUTTON: tambah data-toggle-password -->
                                <button type="button" 
                                        class="btn btn-link position-absolute top-50 end-0 translate-middle-y text-muted"
                                        data-toggle-password="password"
                                        style="padding: 0.375rem 0.75rem;">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-text small">Kosongkan jika tidak ingin mengubah</div>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Konfirmasi Password</label>
                            <div class="position-relative">
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="password_confirmation"
                                       class="form-control pe-5">
                                <!-- UBAH BUTTON: tambah data-toggle-password -->
                                <button type="button" 
                                        class="btn btn-link position-absolute top-50 end-0 translate-middle-y text-muted"
                                        data-toggle-password="password_confirmation"
                                        style="padding: 0.375rem 0.75rem;">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Kolom Kanan -->
                <div class="col-lg-4">
                    <div class="mb-4">
                        <label class="form-label">Role *</label>
                        <select name="role" 
                                class="form-select @error('role') is-invalid @enderror" 
                                required>
                            <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User Biasa</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrator</option>
                        </select>
                        @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="card bg-light border-0">
                        <div class="card-body">
                            <h6 class="card-title small"><i class="fas fa-info-circle me-1"></i> Informasi User</h6>
                            <ul class="small text-muted mb-0">
                                <li>ID: {{ $user->id }}</li>
                                <li>Dibuat: {{ $user->created_at->format('d/m/Y H:i') }}</li>
                                <li>Diupdate: {{ $user->updated_at->format('d/m/Y H:i') }}</li>
                                @if($user->id === auth()->id())
                                    <li class="text-primary">
                                        <i class="fas fa-user-circle me-1"></i> Ini adalah akun Anda
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Update User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

<!-- HAPUS SECTION SCRIPTS - SUDAH ADA DI LAYOUT -->