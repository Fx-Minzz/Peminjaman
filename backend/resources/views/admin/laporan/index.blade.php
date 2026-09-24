@extends('layouts.app')

@section('title', 'Laporan - Sistem Peminjaman')
@section('header-title', 'Laporan Sistem')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Laporan Sistem
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Ringkasan aktivitas peminjaman, pengembalian, pengguna, dan alat.
            </p>
        </div>

        <a href="{{ route('admin.laporan.pdf', request()->query()) }}"
           target="_blank"
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5
                  bg-emerald-600 hover:bg-emerald-700 text-white
                  rounded-lg shadow-sm transition duration-200">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-5 h-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M6 9V3h12v6M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2M6 14h12v7H6v-7z"/>
            </svg>

            Cetak PDF
        </a>
    </div>


    {{-- Statistik --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

        {{-- Total Peminjaman --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5
                    hover:-translate-y-1 transition duration-200">

            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Peminjaman</p>
                    <h2 class="text-3xl font-bold text-gray-800 mt-1">
                        {{ $totalPeminjaman ?? 0 }}
                    </h2>
                </div>

                <div class="w-11 h-11 rounded-lg bg-blue-100 text-blue-600
                            flex items-center justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-6 h-6"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>


        {{-- Sedang Dipinjam --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5
                    hover:-translate-y-1 transition duration-200">

            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Sedang Dipinjam</p>
                    <h2 class="text-3xl font-bold text-orange-600 mt-1">
                        {{ $totalDipinjam ?? 0 }}
                    </h2>
                </div>

                <div class="w-11 h-11 rounded-lg bg-orange-100 text-orange-600
                            flex items-center justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-6 h-6"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>


        {{-- Selesai --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5
                    hover:-translate-y-1 transition duration-200">

            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Selesai</p>
                    <h2 class="text-3xl font-bold text-emerald-600 mt-1">
                        {{ $totalSelesai ?? 0 }}
                    </h2>
                </div>

                <div class="w-11 h-11 rounded-lg bg-emerald-100 text-emerald-600
                            flex items-center justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-6 h-6"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
        </div>


        {{-- Total Denda --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5
                    hover:-translate-y-1 transition duration-200">

            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Denda</p>
                    <h2 class="text-2xl font-bold text-red-600 mt-2">
                        Rp {{ number_format($totalDenda ?? 0, 0, ',', '.') }}
                    </h2>
                </div>

                <div class="w-11 h-11 rounded-lg bg-red-100 text-red-600
                            flex items-center justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-6 h-6"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3 1.343 3 3-1.343 3-3 3m0-12V5m0 14v-2m9-5a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

    </div>


    {{-- Filter --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">

        <div class="flex items-center gap-2 mb-5">
            <div class="w-9 h-9 rounded-lg bg-emerald-100 text-emerald-600
                        flex items-center justify-center">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-5 h-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L15 11.414V19l-6 3v-10.586L3.293 6.707A1 1 0 013 6V4z"/>
                </svg>
            </div>

            <div>
                <h2 class="font-semibold text-gray-800">
                    Filter Laporan
                </h2>
                <p class="text-xs text-gray-500">
                    Tentukan data yang ingin ditampilkan.
                </p>
            </div>
        </div>


        <form method="GET"
              action="{{ route('admin.laporan.index') }}"
              class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

            {{-- Tanggal Mulai --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Tanggal Mulai
                </label>

                <input type="date"
                       name="tanggal_mulai"
                       value="{{ request('tanggal_mulai') }}"
                       class="w-full rounded-lg border-gray-300
                              focus:border-emerald-500 focus:ring-emerald-500">
            </div>


            {{-- Tanggal Akhir --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Tanggal Akhir
                </label>

                <input type="date"
                       name="tanggal_akhir"
                       value="{{ request('tanggal_akhir') }}"
                       class="w-full rounded-lg border-gray-300
                              focus:border-emerald-500 focus:ring-emerald-500">
            </div>


            {{-- Status --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Status
                </label>

                <select name="status"
                        class="w-full rounded-lg border-gray-300
                               focus:border-emerald-500 focus:ring-emerald-500">

                    <option value="">Semua Status</option>

                    <option value="diajukan"
                        {{ request('status') == 'diajukan' ? 'selected' : '' }}>
                        Diajukan
                    </option>

                    <option value="dipinjam"
                        {{ request('status') == 'dipinjam' ? 'selected' : '' }}>
                        Dipinjam
                    </option>

                    <option value="selesai"
                        {{ request('status') == 'selesai' ? 'selected' : '' }}>
                        Selesai
                    </option>

                </select>
            </div>


            {{-- Kategori --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Kategori Alat
                </label>

                <select name="kategori_id"
                        class="w-full rounded-lg border-gray-300
                               focus:border-emerald-500 focus:ring-emerald-500">

                    <option value="">Semua Kategori</option>

                    @foreach($kategoris ?? [] as $kategori)

                        <option value="{{ $kategori->id }}"
                            {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>

                            {{ $kategori->nama_kategori }}

                        </option>

                    @endforeach

                </select>
            </div>


            {{-- Buttons --}}
            <div class="lg:col-span-4 flex flex-wrap gap-2 justify-end pt-2">

                <a href="{{ route('admin.laporan.index') }}"
                   class="px-4 py-2.5 rounded-lg border border-gray-300
                          text-gray-600 hover:bg-gray-50 transition">

                    Reset
                </a>

                <button type="submit"
                        class="px-5 py-2.5 rounded-lg bg-emerald-600
                               hover:bg-emerald-700 text-white
                               transition shadow-sm">

                    Terapkan Filter
                </button>

            </div>

        </form>
    </div>


    {{-- Tabel Laporan --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-6 py-5 border-b border-gray-100
                    flex flex-col sm:flex-row sm:items-center
                    sm:justify-between gap-2">

            <div>
                <h2 class="font-semibold text-gray-800 text-lg">
                    Data Peminjaman
                </h2>

                <p class="text-sm text-gray-500">
                    Daftar transaksi berdasarkan filter yang dipilih.
                </p>
            </div>

            <span class="text-sm text-gray-500">
                Total:
                <strong class="text-gray-800">
                    {{ isset($peminjaman) ? $peminjaman->count() : 0 }}
                </strong>
                data
            </span>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-gray-50 border-b border-gray-200">

                    <tr>
                        <th class="px-6 py-3 text-left font-semibold text-gray-600">
                            #
                        </th>

                        <th class="px-6 py-3 text-left font-semibold text-gray-600">
                            Peminjam
                        </th>

                        <th class="px-6 py-3 text-left font-semibold text-gray-600">
                            Tanggal Pinjam
                        </th>

                        <th class="px-6 py-3 text-left font-semibold text-gray-600">
                            Batas Kembali
                        </th>

                        <th class="px-6 py-3 text-left font-semibold text-gray-600">
                            Status
                        </th>

                        <th class="px-6 py-3 text-right font-semibold text-gray-600">
                            Detail
                        </th>
                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @forelse($peminjaman ?? [] as $index => $item)

                        <tr class="hover:bg-gray-50 transition">

                            <td class="px-6 py-4 text-gray-500">
                                {{ $index + 1 }}
                            </td>


                            <td class="px-6 py-4">

                                <div class="font-medium text-gray-800">
                                    {{ $item->user->name ?? '-' }}
                                </div>

                                <div class="text-xs text-gray-500">
                                    {{ $item->user->email ?? '' }}
                                </div>

                            </td>


                            <td class="px-6 py-4 text-gray-600">
                                {{ $item->tanggal_pinjam
                                    ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y')
                                    : '-' }}
                            </td>


                            <td class="px-6 py-4 text-gray-600">
                                {{ $item->tanggal_kembali
                                    ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d/m/Y')
                                    : '-' }}
                            </td>


                            <td class="px-6 py-4">

                                @php
                                    $status = strtolower($item->status ?? '');

                                    $statusClass = match ($status) {
                                        'diajukan' => 'bg-yellow-100 text-yellow-700',
                                        'dipinjam' => 'bg-blue-100 text-blue-700',
                                        'selesai' => 'bg-emerald-100 text-emerald-700',
                                        'ditolak' => 'bg-red-100 text-red-700',
                                        default => 'bg-gray-100 text-gray-600',
                                    };
                                @endphp

                                <span class="inline-flex items-center px-2.5 py-1
                                             rounded-full text-xs font-medium {{ $statusClass }}">

                                    {{ ucfirst($item->status ?? '-') }}

                                </span>

                            </td>


                            <td class="px-6 py-4 text-right">

                                <a href="{{ route('admin.peminjaman.show', $item->id) }}"
                                   class="inline-flex items-center gap-1
                                          text-emerald-600 hover:text-emerald-800
                                          font-medium transition">

                                    Detail

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="w-4 h-4"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M9 5l7 7-7 7"/>

                                    </svg>

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6"
                                class="px-6 py-12 text-center">

                                <div class="flex flex-col items-center">

                                    <div class="w-14 h-14 rounded-full
                                                bg-gray-100 text-gray-400
                                                flex items-center justify-center mb-3">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="w-7 h-7"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z"/>

                                        </svg>

                                    </div>

                                    <p class="font-medium text-gray-600">
                                        Tidak ada data laporan
                                    </p>

                                    <p class="text-sm text-gray-400 mt-1">
                                        Coba ubah filter laporan.
                                    </p>

                                </div>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if(isset($peminjaman) && method_exists($peminjaman, 'links'))

            <div class="px-6 py-4 border-t border-gray-100">
                {{ $peminjaman->withQueryString()->links() }}
            </div>

        @endif

    </div>


    {{-- Ringkasan Tambahan --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- User --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">

            <h2 class="font-semibold text-gray-800 mb-4">
                Ringkasan Pengguna
            </h2>

            <div class="grid grid-cols-2 gap-4">

                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm text-gray-500">
                        Total Pengguna
                    </p>

                    <p class="text-2xl font-bold text-gray-800 mt-1">
                        {{ $totalUser ?? 0 }}
                    </p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm text-gray-500">
                        Peminjam
                    </p>

                    <p class="text-2xl font-bold text-emerald-600 mt-1">
                        {{ $totalPeminjam ?? 0 }}
                    </p>
                </div>

            </div>

        </div>


        {{-- Alat --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">

            <h2 class="font-semibold text-gray-800 mb-4">
                Ringkasan Alat
            </h2>

            <div class="grid grid-cols-2 gap-4">

                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm text-gray-500">
                        Total Alat
                    </p>

                    <p class="text-2xl font-bold text-gray-800 mt-1">
                        {{ $totalAlat ?? 0 }}
                    </p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm text-gray-500">
                        Kategori
                    </p>

                    <p class="text-2xl font-bold text-blue-600 mt-1">
                        {{ $totalKategori ?? 0 }}
                    </p>
                </div>

            </div>

        </div>

    </div>

</div>

@endsection