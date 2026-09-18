@extends('layouts.app')

@section('title', 'Detail User')
@section('header-title', 'Detail User')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

        {{-- Header --}}
        <div class="px-6 py-5 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">
                Detail User
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Informasi lengkap akun user
            </p>
        </div>

        {{-- Profile --}}
        <div class="p-6">

            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 mb-8">

                {{-- Foto --}}
                <div>
                    @if($user->foto_profile)
                        <img
                            src="{{ asset($user->foto_profile) }}"
                            alt="Foto {{ $user->name }}"
                            class="w-28 h-28 rounded-full object-cover border-4 border-gray-100"
                        >
                    @else
                        <div class="w-28 h-28 rounded-full bg-gray-100 flex items-center justify-center text-gray-400">
                            <span class="text-sm">No Foto</span>
                        </div>
                    @endif
                </div>

                {{-- Nama --}}
                <div class="text-center sm:text-left">
                    <h3 class="text-2xl font-bold text-gray-800">
                        {{ $user->name }}
                    </h3>

                    <p class="text-gray-500 mt-1">
                        {{ $user->email }}
                    </p>

                    <span class="inline-block mt-3 px-3 py-1 text-xs font-semibold rounded-full
                        @if($user->role === 'admin')
                            bg-red-100 text-red-800
                        @elseif($user->role === 'petugas')
                            bg-yellow-100 text-yellow-800
                        @else
                            bg-green-100 text-green-800
                        @endif">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>

            </div>

            {{-- Informasi --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div class="border border-gray-200 rounded-lg p-4">
                    <p class="text-sm text-gray-500">Nama Lengkap</p>
                    <p class="font-semibold text-gray-800 mt-1">
                        {{ $user->name }}
                    </p>
                </div>

                <div class="border border-gray-200 rounded-lg p-4">
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="font-semibold text-gray-800 mt-1">
                        {{ $user->email }}
                    </p>
                </div>

                <div class="border border-gray-200 rounded-lg p-4">
                    <p class="text-sm text-gray-500">Jenis Kelamin</p>
                    <p class="font-semibold text-gray-800 mt-1">
                        @if($user->jenis_kelamin === 'L')
                            Laki-laki
                        @elseif($user->jenis_kelamin === 'P')
                            Perempuan
                        @else
                            -
                        @endif
                    </p>
                </div>

                <div class="border border-gray-200 rounded-lg p-4">
                    <p class="text-sm text-gray-500">No. HP</p>
                    <p class="font-semibold text-gray-800 mt-1">
                        {{ $user->no_hp ?: '-' }}
                    </p>
                </div>

                <div class="border border-gray-200 rounded-lg p-4">
                    <p class="text-sm text-gray-500">Role</p>
                    <p class="font-semibold text-gray-800 mt-1">
                        {{ ucfirst($user->role) }}
                    </p>
                </div>

                <div class="border border-gray-200 rounded-lg p-4">
                    <p class="text-sm text-gray-500">ID User</p>
                    <p class="font-semibold text-gray-800 mt-1">
                        #{{ $user->id }}
                    </p>
                </div>

                <div class="border border-gray-200 rounded-lg p-4">
                    <p class="text-sm text-gray-500">Tanggal Dibuat</p>
                    <p class="font-semibold text-gray-800 mt-1">
                        {{ $user->created_at ? $user->created_at->format('d M Y, H:i') : '-' }}
                    </p>
                </div>

                <div class="border border-gray-200 rounded-lg p-4">
                    <p class="text-sm text-gray-500">Terakhir Diubah</p>
                    <p class="font-semibold text-gray-800 mt-1">
                        {{ $user->updated_at ? $user->updated_at->format('d M Y, H:i') : '-' }}
                    </p>
                </div>
            </div>

            <div class="mt-8 border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-bold text-gray-800">
                        Riwayat Aktivitas
                    </h3>

                    <p class="text-sm text-gray-500 mt-1 mb-4">
                        Aktivitas yang dilakukan oleh user ini.
                    </p>

                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        @forelse($aktivitas as $log)
                            <div class="p-4 border-b border-gray-200 last:border-b-0">
                                <div class="flex flex-col sm:flex-row sm:justify-between gap-2">
                                    <p class="text-sm text-gray-800 font-medium">
                                        {{ $log->aktivitas }}
                                    </p>

                                    <p class="text-xs text-gray-500">
                                        {{ $log->created_at ? $log->created_at->format('d M Y, H:i') : '-' }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 text-center text-sm text-gray-500">
                                Belum ada aktivitas.
                            </div>
                        @endforelse
                    </div>
                    <div class="mt-4">
                            {{ $aktivitas->links() }}
                        </div>
                </div>

            {{-- Tombol --}}
            <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-200">

                <a href="{{ route('admin.user.index') }}"
                   class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                    Kembali
                </a>

                <a href="{{ route('admin.user.edit', $user->id) }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Edit User
                </a>

            </div>

        </div>
    </div>

</div>

@endsection