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
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">

        <div class="p-5 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-bold text-gray-800">
                Daftar Alat
            </h3>
        </div>

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

                        <th class="py-3 px-4 border-b text-center">
                            Kondisi
                        </th>

                    </tr>
                </thead>

                <tbody class="text-gray-700 text-sm">

                    @forelse($alats as $index => $alat)

                        <tr class="hover:bg-gray-50 transition">

                            <td class="py-3 px-4 border-b text-center">
                                {{ $alats->firstItem() + $index }}
                            </td>

                            <td class="py-3 px-4 border-b font-medium text-gray-900">
                                {{ $alat->nama_alat }}
                            </td>

                            <td class="py-3 px-4 border-b text-center">
                                {{ $alat->stok }}
                            </td>

                            <td class="py-3 px-4 border-b text-center">
                                {{ $alat->status_kondisi }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" class="py-6 text-center text-gray-500">
                                Belum ada alat dalam kategori ini.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <!-- Pagination -->
        @if($alats->hasPages())
            <div class="p-4 border-t border-gray-200 bg-gray-50">
                {{ $alats->links() }}
            </div>
        @endif

    </div>

@endsection