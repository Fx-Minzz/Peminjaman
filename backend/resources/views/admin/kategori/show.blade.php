@extends('layouts.app')

@section('title', 'Detail Kategori - Panel Admin')
@section('header-title', 'Detail Kategori')

@section('content')

    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">

        <div>
            <h2 class="text-xl font-bold text-gray-800">
                {{ $kategori->nama_kategori }}
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Daftar alat dalam kategori ini
            </p>
        </div>

        <a
            href="{{ route('admin.kategori.index') }}"
            class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold transition">
            ← Kembali
        </a>

    </div>

    <!-- Informasi Kategori -->
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-5 mb-6">

        <div class="flex items-center justify-between">

            <div>
                <p class="text-sm text-gray-500">
                    Nama Kategori
                </p>

                <p class="text-lg font-bold text-gray-800 mt-1">
                    {{ $kategori->nama_kategori }}
                </p>
            </div>

            <div class="text-right">

                <p class="text-sm text-gray-500">
                    Jumlah Alat
                </p>

                <p class="text-2xl font-bold text-blue-600 mt-1">
                    {{ $alats->total() }}
                </p>

            </div>

        </div>

    </div>
    
    <!-- Daftar Alat -->
<div class="space-y-6">

    @php
        $kelompokKondisi = $alats->groupBy(function ($alat) {
            return $alat->status_kondisi ?: 'Tidak Diketahui';
        });
    @endphp

    @forelse($kelompokKondisi as $kondisi => $daftarAlat)

        @php
            $kondisiLower = strtolower(trim($kondisi));
        @endphp

        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">

            <!-- Header Kondisi -->
            <div class="p-5 border-b border-gray-200 bg-gray-50 flex items-center justify-between">

                <div>
                    <h3 class="text-lg font-bold text-gray-800">
                        {{ $kondisi }}
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        {{ $daftarAlat->count() }} alat
                    </p>
                </div>

                <!-- Badge Kondisi -->
                <span
                    class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full
                    @if($kondisiLower === 'baik')
                        bg-emerald-100 text-emerald-800
                    @elseif($kondisiLower === 'rusak ringan')
                        bg-amber-100 text-amber-800
                    @elseif($kondisiLower === 'rusak berat')
                        bg-red-100 text-red-800
                    @else
                        bg-gray-100 text-gray-700
                    @endif
                    "
                >
                    {{ $kondisi }}
                </span>

            </div>

            <!-- Tabel -->
            <div class="overflow-x-auto">

                <table class="w-full text-left border-collapse">

                    <thead>
                        <tr class="bg-gray-100 text-gray-600 text-sm uppercase tracking-wider">

                            <th class="py-3 px-4 border-b w-16 text-center">
                                No
                            </th>

                            <th class="py-3 px-4 border-b">
                                Nama Alat
                            </th>

                            <th class="py-3 px-4 border-b text-center">
                                Stok
                            </th>

                        </tr>
                    </thead>

                    <tbody class="text-gray-700 text-sm">

                        @foreach($daftarAlat as $index => $alat)

                            <tr class="hover:bg-gray-50 transition">

                                <td class="py-3 px-4 border-b text-center">
                                    {{ $index + 1 }}
                                </td>

                                <td class="py-3 px-4 border-b font-medium text-gray-900">
                                    {{ $alat->nama_alat }}
                                </td>

                                <td class="py-3 px-4 border-b text-center">

                                    @if($alat->stok > 0)

                                        <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                            {{ $alat->stok }} unit
                                        </span>

                                    @else

                                        <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            Habis
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    @empty

        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-8 text-center text-gray-500">
            Belum ada alat dalam kategori ini.
        </div>

    @endforelse

</div>

<!-- Pagination -->
@if($alats->hasPages())
    <div class="mt-6 p-4 border border-gray-200 rounded-lg bg-gray-50">
        {{ $alats->links() }}
    </div>
@endif

</div>

@endsection