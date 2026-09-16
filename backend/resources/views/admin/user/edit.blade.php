@extends('layouts.app')

@section('title', 'Edit User - Panel Admin')
@section('header-title', 'Edit Data Pengguna')

@section('content')

<div class="max-w-xl bg-white rounded-xl shadow-sm border border-gray-200 p-6">

    <form action="{{ route('admin.user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Nama --}}
        <div class="mb-5">
            <label class="block text-gray-700 text-sm font-semibold mb-2">
                Nama Lengkap
            </label>

            <input
                type="text"
                name="name"
                value="{{ old('name', $user->name) }}"
                required
                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            >

            @error('name')
                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        {{-- Email --}}
        <div class="mb-5">
            <label class="block text-gray-700 text-sm font-semibold mb-2">
                Email
            </label>

            <input
                type="email"
                name="email"
                value="{{ old('email', $user->email) }}"
                required
                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            >

            @error('email')
                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mb-5">
            <label class="block text-gray-700 text-sm font-semibold mb-2">
                Password Baru
                <span class="text-xs text-gray-400 font-normal">
                    (Kosongkan jika tidak ingin mengubah)
                </span>
            </label>

            <input
                type="password"
                name="password"
                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            >

            @error('password')
                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        {{-- Role --}}
        <div class="mb-5">
            <label class="block text-gray-700 text-sm font-semibold mb-2">
                Role / Hak Akses
            </label>

            <select
                name="role"
                required
                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            >
                <option value="peminjam" {{ old('role', $user->role) == 'peminjam' ? 'selected' : '' }}>
                    Peminjam
                </option>

                <option value="petugas" {{ old('role', $user->role) == 'petugas' ? 'selected' : '' }}>
                    Petugas
                </option>

                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                    Admin
                </option>
            </select>

            @error('role')
                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        {{-- No HP --}}
        <div class="mb-5">
            <label class="block text-gray-700 text-sm font-semibold mb-2">
                No. HP
            </label>

            <input
                type="text"
                name="no_hp"
                value="{{ old('no_hp', $user->no_hp) }}"
                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            >

            @error('no_hp')
                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        {{-- Foto Profil --}}
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-semibold mb-2">
                Foto Profil
            </label>

            <p class="text-xs text-gray-400 mb-3">
                Biarkan kosong jika tidak ingin mengubah foto.
            </p>

            @if($user->foto_profile)
                <div class="mb-4 flex items-center gap-4">
                    <img
                        src="{{ asset($user->foto_profile) }}"
                        alt="{{ $user->name }}"
                        class="w-20 h-20 object-cover rounded-full border border-gray-200 shadow-sm"
                    >

                    <div>
                        <p class="text-sm font-medium text-gray-700">
                            Foto saat ini
                        </p>
                        <p class="text-xs text-gray-400">
                            Pilih foto baru untuk menggantinya.
                        </p>
                    </div>
                </div>
            @endif

            <input
                type="file"
                name="foto_profile"
                accept="image/jpeg,image/png,image/jpg"
                class="w-full text-sm text-gray-500
                       file:mr-4 file:py-2 file:px-4
                       file:rounded-lg file:border-0
                       file:text-sm file:font-semibold
                       file:bg-blue-50 file:text-blue-700
                       hover:file:bg-blue-100"
            >

            @error('foto_profile')
                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end gap-2 pt-4 border-t border-gray-100">

            <a
                href="{{ route('admin.user.index') }}"
                class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2.5 rounded-lg text-sm font-semibold transition"
            >
                Batal
            </a>

            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg text-sm font-semibold transition"
            >
                Perbarui
            </button>

        </div>

    </form>

</div>

@endsection