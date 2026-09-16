@extends('layouts.peminjam')

@section('title', 'Dashboard Peminjam')
@section('header-title', 'Dashboard')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-800">
            Selamat datang, {{ auth()->user()->name }} 👋
        </h1>

        <p class="text-gray-500 mt-1">
            Kelola peminjaman alat kamu dengan mudah.
        </p>
    </div>


    {{-- STATISTIK --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        {{-- Total Peminjaman --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <p class="text-sm text-gray-500">
                Total Peminjaman
            </p>

            <h2 class="text-3xl font-bold text-gray-800 mt-2">
                {{ $totalPeminjaman ?? 0 }}
            </h2>
        </div>


        {{-- Sedang Dipinjam --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <p class="text-sm text-gray-500">
                Sedang Dipinjam
            </p>

            <h2 class="text-3xl font-bold text-blue-600 mt-2">
                {{ $sedangDipinjam ?? 0 }}
            </h2>
        </div>


        {{-- Menunggu Persetujuan --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <p class="text-sm text-gray-500">
                Menunggu Persetujuan
            </p>

            <h2 class="text-3xl font-bold text-yellow-500 mt-2">
                {{ $menungguPersetujuan ?? 0 }}
            </h2>
        </div>

    </div>


    {{-- KATALOG --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>
                <h2 class="text-lg font-bold text-gray-800">
                    Cari Alat yang Kamu Butuhkan
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Lihat alat yang tersedia dan ajukan peminjaman.
                </p>
            </div>

            <a
                href="{{ route('peminjam.katalog') }}"
                class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition"
            >
                Lihat Katalog
            </a>

        </div>

    </div>


    {{-- PEMINJAMAN TERBARU --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">

        <div class="p-5 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-800">
                Peminjaman Terbaru
            </h2>
        </div>

        <div class="p-5">

            @if(isset($peminjamanTerbaru) && $peminjamanTerbaru->count())

                <div class="overflow-x-auto">

                    <table class="w-full text-sm">

                        <thead>
                            <tr class="text-left text-gray-500 border-b">
                                <th class="pb-3">Kode</th>
                                <th class="pb-3">Tanggal</th>
                                <th class="pb-3">Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($peminjamanTerbaru as $peminjaman)
                                <tr class="border-b last:border-0">

                                    <td class="py-3 font-medium text-gray-700">
                                        #{{ $peminjaman->id }}
                                    </td>

                                    <td class="py-3 text-gray-500">
                                        {{ $peminjaman->tgl_pinjam?->format('d M Y') ?? '-' }}
                                    </td>

                                    <td class="py-3">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            @if($peminjaman->status === 'diajukan')
                                                bg-yellow-100 text-yellow-700
                                            @elseif($peminjaman->status === 'dipinjam')
                                                bg-blue-100 text-blue-700
                                            @elseif($peminjaman->status === 'selesai')
                                                bg-green-100 text-green-700
                                            @else
                                                bg-gray-100 text-gray-600
                                            @endif
                                        ">
                                            {{ ucfirst($peminjaman->status ?? '-') }}
                                        </span>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>

                    </table>

                </div>

            @else

                <div class="text-center py-8">

                    <p class="text-gray-500 text-sm">
                        Belum ada riwayat peminjaman.
                    </p>

                    <a
                        href="{{ route('peminjam.katalog') }}"
                        class="inline-block mt-3 text-blue-600 hover:text-blue-700 text-sm font-semibold"
                    >
                        Mulai mencari alat →
                    </a>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection