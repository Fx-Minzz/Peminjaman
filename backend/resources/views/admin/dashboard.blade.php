@extends('layouts.app')

@section('title', 'Dashboard Admin - Sistem Peminjaman')
@section('header-title', 'Dashboard Admin')

@section('content')

    <!-- Welcome -->
    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-lg shadow-sm">
        Selamat datang, <strong class="font-semibold">{{ auth()->user()->name }}</strong>!
        Anda login sebagai hak akses
        <span class="uppercase font-bold text-emerald-900">
            {{ auth()->user()->role }}
        </span>.
    </div>

    <!-- Statistik Utama -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">

        <!-- Total User -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <p class="text-sm text-gray-500">Total User</p>
            <h2 class="text-3xl font-bold text-gray-800 mt-2">
                {{ $totalUser }}
            </h2>
            <p class="text-sm text-gray-400 mt-1">Pengguna terdaftar</p>
        </div>

        <!-- Total Alat -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <p class="text-sm text-gray-500">Total Alat</p>
            <h2 class="text-3xl font-bold text-gray-800 mt-2">
                {{ $totalAlat }}
            </h2>
            <p class="text-sm text-gray-400 mt-1">Jenis alat tersedia</p>
        </div>

        <!-- Total Peminjaman -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <p class="text-sm text-gray-500">Total Peminjaman</p>
            <h2 class="text-3xl font-bold text-gray-800 mt-2">
                {{ $totalPeminjaman }}
            </h2>
            <p class="text-sm text-gray-400 mt-1">Seluruh data peminjaman</p>
        </div>

        <!-- Menunggu Persetujuan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <p class="text-sm text-gray-500">Menunggu Persetujuan</p>
            <h2 class="text-3xl font-bold text-yellow-600 mt-2">
                {{ $menungguPersetujuan }}
            </h2>
            <p class="text-sm text-gray-400 mt-1">Peminjaman diajukan</p>
        </div>

    </div>

    <!-- Statistik Status -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">

        <!-- Sedang Dipinjam -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <p class="text-sm text-gray-500">Sedang Dipinjam</p>
            <h2 class="text-2xl font-bold text-blue-600 mt-2">
                {{ $sedangDipinjam }}
            </h2>
            <p class="text-sm text-gray-400 mt-1">
                Peminjaman yang masih aktif
            </p>
        </div>

        <!-- Selesai -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <p class="text-sm text-gray-500">Peminjaman Selesai</p>
            <h2 class="text-2xl font-bold text-emerald-600 mt-2">
                {{ $peminjamanSelesai }}
            </h2>
            <p class="text-sm text-gray-400 mt-1">
                Barang telah dikembalikan
            </p>
        </div>

        <!-- Total Aktivitas -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <p class="text-sm text-gray-500">Aktivitas Terbaru</p>
            <h2 class="text-2xl font-bold text-gray-800 mt-2">
                {{ $logsTerbaru->count() }}
            </h2>
            <p class="text-sm text-gray-400 mt-1">
                Aktivitas terakhir tercatat
            </p>
        </div>

    </div>

    <!-- Log Aktivitas Terbaru -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

        <div class="px-5 py-4 border-b border-gray-200 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-800">
                    Aktivitas Terbaru
                </h3>
                <p class="text-sm text-gray-500 mt-1">
                    5 aktivitas terakhir dalam sistem
                </p>
            </div>

            <a href="{{ route('admin.log.index') }}"
               class="text-sm font-semibold text-emerald-600 hover:text-emerald-700">
                Lihat Semua →
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">

                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-sm">
                        <th class="py-3 px-5 border-b">Waktu</th>
                        <th class="py-3 px-5 border-b">User</th>
                        <th class="py-3 px-5 border-b">Aktivitas</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700 text-sm">

                    @forelse($logsTerbaru as $log)

                        <tr class="hover:bg-gray-50 transition">

                            <td class="py-3 px-5 border-b text-gray-500 whitespace-nowrap">
                                {{ $log->created_at->format('d M Y H:i') }}
                            </td>

                            <td class="py-3 px-5 border-b font-medium text-gray-900">
                                {{ $log->user->name ?? 'Sistem' }}
                            </td>

                            <td class="py-3 px-5 border-b">
                                {{ $log->aktivitas }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="3"
                                class="py-8 text-center text-gray-500">
                                Belum ada aktivitas.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

    </div>

@endsection