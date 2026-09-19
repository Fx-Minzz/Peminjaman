@extends('layouts.app')

@section('title', 'Detail Alat - Panel Admin')
@section('header-title', 'Detail Alat')

@section('content')

    <div class="mb-5 flex items-center justify-between">

        <div>
            <h3 class="text-xl font-bold text-gray-800">
                Detail Alat
            </h3>

            <p class="text-sm text-gray-500 mt-1">
                Informasi lengkap mengenai alat laboratorium.
            </p>
        </div>

        <a
            href="{{ route('admin.alat.index') }}"
            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700
                   text-sm font-semibold rounded-lg transition">

            ← Kembali

        </a>

    </div>


    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

        <div class="p-6">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Gambar --}}
                <div>

                    <div class="w-full aspect-square bg-gray-100 rounded-xl
                                border border-gray-200 overflow-hidden flex items-center justify-center">

                        @if($alat->gambar)

                            <img
                                src="{{ asset($alat->gambar) }}"
                                alt="{{ $alat->nama_alat }}"
                                class="w-full h-full object-cover">

                        @else

                            <div class="text-center">

                                <svg
                                    class="w-16 h-16 mx-auto text-gray-300"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />

                                </svg>

                                <p class="text-sm text-gray-400 mt-2">
                                    Tidak ada gambar
                                </p>

                            </div>

                        @endif

                    </div>

                </div>


                {{-- Informasi --}}
                <div class="lg:col-span-2">

                    <div class="mb-6">

                        <p class="text-sm text-gray-500 mb-1">
                            Nama Alat
                        </p>

                        <h1 class="text-2xl font-bold text-gray-900">
                            {{ $alat->nama_alat }}
                        </h1>

                    </div>


                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                        {{-- Kategori --}}
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">

                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                Kategori
                            </p>

                            <p class="mt-1 text-sm font-semibold text-gray-800">
                                {{ $alat->kategori->nama_kategori ?? '-' }}
                            </p>

                        </div>


                        {{-- Stok --}}
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">

                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                Stok
                            </p>

                            <p class="mt-1 text-lg font-bold text-gray-800">
                                {{ $alat->stok }}
                            </p>

                        </div>


                        {{-- Kondisi --}}
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">

                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                Kondisi
                            </p>

                            <div class="mt-2">

                                <span
                                    class="px-3 py-1 text-xs font-semibold rounded-full
                                    @if(strtolower($alat->status_kondisi) === 'baik')
                                        bg-emerald-100 text-emerald-800
                                    @elseif(strtolower($alat->status_kondisi) === 'rusak ringan')
                                        bg-amber-100 text-amber-800
                                    @else
                                        bg-red-100 text-red-800
                                    @endif">

                                    {{ $alat->status_kondisi }}

                                </span>

                            </div>

                        </div>


                        {{-- ID --}}
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">

                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                ID Alat
                            </p>

                            <p class="mt-1 text-sm font-semibold text-gray-800">
                                #{{ $alat->id }}
                            </p>

                        </div>

                        {{-- Dibuat --}}
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">

                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                Ditambahkan
                            </p>

                            <p class="mt-1 text-sm font-semibold text-gray-800">
                                {{ $alat->created_at?->format('d M Y, H:i') ?? '-' }}
                            </p>

                        </div>

                        {{-- Terakhir Diubah --}}
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">

                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                Terakhir Diubah
                            </p>

                            <p class="mt-1 text-sm font-semibold text-gray-800">
                                {{ $alat->updated_at?->format('d M Y, H:i') ?? '-' }}
                            </p>

                        </div>

                    </div>


                    {{-- Deskripsi --}}
                    <div class="mt-6">

                        <p class="text-sm font-bold text-gray-800 mb-2">
                            Deskripsi
                        </p>

                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">

                            @if($alat->deskripsi)

                                <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">
                                    {{ $alat->deskripsi }}
                                </p>

                            @else

                                <p class="text-sm text-gray-400 italic">
                                    Tidak ada deskripsi.
                                </p>

                            @endif

                        </div>

                    </div>

                    {{-- Action --}}
                    <div class="flex flex-wrap gap-3 mt-6">

                        <a
                            href="{{ route('admin.alat.edit', $alat->id) }}"
                            class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700
                                   text-white text-sm font-semibold rounded-lg transition">

                            Edit Alat

                        </a>

                        <form
                            action="{{ route('admin.alat.destroy', $alat->id) }}"
                            method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus alat ini?')">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="px-5 py-2.5 bg-red-500 hover:bg-red-600
                                       text-white text-sm font-semibold rounded-lg transition">

                                Hapus Alat

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- Riwayat Peminjaman --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mt-6">

        <div class="p-5 border-b border-gray-200 bg-gray-50">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">

                <div>
                    <h3 class="text-lg font-bold text-gray-800">
                        Riwayat Peminjaman
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Riwayat penggunaan alat ini dalam peminjaman.
                    </p>
                </div>

                <div class="px-4 py-2 bg-blue-50 border border-blue-100 rounded-lg">

                    <p class="text-xs text-blue-600 font-semibold">
                        Total Dipinjam
                    </p>

                    <p class="text-lg font-bold text-blue-700">
                        {{ $totalDipinjam }} unit
                    </p>

                </div>

            </div>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full text-left border-collapse">

                <thead>

                    <tr class="bg-gray-100 text-gray-600 text-xs uppercase tracking-wider">

                        <th class="py-3 px-4 border-b">
                            Peminjam
                        </th>

                        <th class="py-3 px-4 border-b">
                            Jumlah
                        </th>

                        <th class="py-3 px-4 border-b">
                            Tanggal Pinjam
                        </th>

                        <th class="py-3 px-4 border-b">
                            Rencana Kembali
                        </th>

                        <th class="py-3 px-4 border-b">
                            Status
                        </th>

                    </tr>

                </thead>


                <tbody class="text-sm">

                    @forelse($riwayatPeminjaman as $detail)

                        <tr class="hover:bg-gray-50 transition">

                            {{-- Peminjam --}}
                            <td class="py-3 px-4 border-b">

                                <p class="font-semibold text-gray-800">
                                    {{ $detail->peminjaman->user->name ?? '-' }}
                                </p>

                                <p class="text-xs text-gray-500">
                                    {{ $detail->peminjaman->user->email ?? '-' }}
                                </p>

                            </td>


                            {{-- Jumlah --}}
                            <td class="py-3 px-4 border-b">

                                <span class="font-semibold text-gray-800">
                                    {{ $detail->jumlah }} unit
                                </span>

                            </td>


                            {{-- Tanggal Pinjam --}}
                            <td class="py-3 px-4 border-b text-gray-600">

                                {{ $detail->peminjaman->tgl_pinjam?->format('d M Y') ?? '-' }}

                            </td>


                            {{-- Rencana Kembali --}}
                            <td class="py-3 px-4 border-b text-gray-600">

                                {{ $detail->peminjaman->tgl_kembali_plan?->format('d M Y') ?? '-' }}

                            </td>


                            {{-- Status --}}
                            <td class="py-3 px-4 border-b">

                                <span
                                    class="px-2.5 py-1 text-xs font-semibold rounded-full
                                    @if($detail->peminjaman->status === 'diajukan')
                                        bg-amber-100 text-amber-800
                                    @elseif($detail->peminjaman->status === 'dipinjam')
                                        bg-blue-100 text-blue-800
                                    @elseif($detail->peminjaman->status === 'selesai')
                                        bg-emerald-100 text-emerald-800
                                    @else
                                        bg-gray-100 text-gray-700
                                    @endif">

                                    {{ ucfirst($detail->peminjaman->status) }}

                                </span>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="py-8 text-center text-gray-500">

                                Belum ada riwayat peminjaman alat ini.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if($riwayatPeminjaman->hasPages())

            <div class="p-4 border-t border-gray-200 bg-gray-50">

                {{ $riwayatPeminjaman->links() }}

            </div>

        @endif

    </div>

@endsection