@extends('layouts.app')

@section('title', 'Kelola Alat - Panel Admin')
@section('header-title', 'Manajemen Data Alat')

@section('content')

    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-lg shadow-sm text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Error Message --}}
    @if(session('error'))
        <div class="mb-4 bg-red-50 border border-red-200 text-red-800 p-4 rounded-lg shadow-sm text-sm">
            {{ session('error') }}
        </div>
    @endif


    <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">

        {{-- Header --}}
        <div class="p-5 border-b border-gray-200 bg-gray-50">

            <h3 class="text-lg font-bold text-gray-800">
                Daftar Alat Laboratorium
            </h3>


            {{-- Search + Filter --}}
            <form action="{{ route('admin.alat.index') }}" method="GET" class="mt-5">

                {{-- Search + Tambah Alat --}}
                <div class="flex flex-col md:flex-row items-stretch md:items-center gap-3">

                    {{-- Search --}}
                    <div class="flex flex-1">

                        <div class="relative flex-1">

                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">

                                <svg
                                    class="w-5 h-5 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />

                                </svg>

                            </div>

                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Cari nama alat, kategori, atau kondisi..."
                                class="w-full pl-11 pr-4 py-3 text-sm bg-white border border-gray-300 rounded-l-xl
                                       focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                       transition shadow-sm">

                        </div>

                        <button
                            type="submit"
                            class="px-6 py-3 bg-gray-800 hover:bg-gray-900 text-white text-sm font-semibold
                                   rounded-r-xl transition shadow-sm">

                            Cari

                        </button>

                    </div>


                    {{-- Tambah Alat --}}
                    <a
                        href="{{ route('admin.alat.create') }}"
                        class="inline-flex items-center justify-center px-5 py-3
                               bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold
                               rounded-xl transition shadow-sm whitespace-nowrap">

                        + Tambah Alat

                    </a>

                </div>


                {{-- Filter Panel --}}
                <div class="w-full mt-4">

                    <div class="w-full p-4 bg-gray-50 border border-gray-200 rounded-xl">

                        {{-- Filter Header --}}
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">

                            <div>

                                <h4 class="text-sm font-bold text-gray-800">
                                    Filter Alat
                                </h4>

                                <p class="text-xs text-gray-500 mt-0.5">
                                    Gunakan filter untuk mempersempit hasil pencarian.
                                </p>

                            </div>


                            @if(request()->hasAny(['search', 'kategori', 'kondisi', 'stok', 'sort']))

                                <a
                                    href="{{ route('admin.alat.index') }}"
                                    class="text-xs font-semibold text-red-600 hover:text-red-700 transition">

                                    Reset semua

                                </a>

                            @endif

                        </div>


                        {{-- Filter Fields --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">

                            {{-- Kategori --}}
                            <div>

                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                                    Kategori
                                </label>

                                <select
                                    name="kategori"
                                    class="w-full px-3 py-2.5 text-sm bg-white border border-gray-300 rounded-lg
                                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                                    <option value="">
                                        Semua Kategori
                                    </option>

                                    @foreach($kategoris as $item)

                                        <option
                                            value="{{ $item->id }}"
                                            {{ request('kategori') == $item->id ? 'selected' : '' }}>

                                            {{ $item->nama_kategori }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            {{-- Kondisi --}}
                            <div>

                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                                    Kondisi
                                </label>

                                <select
                                    name="kondisi"
                                    class="w-full px-3 py-2.5 text-sm bg-white border border-gray-300 rounded-lg
                                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                                    <option value="">
                                        Semua Kondisi
                                    </option>

                                    <option
                                        value="Baik"
                                        {{ request('kondisi') == 'Baik' ? 'selected' : '' }}>

                                        Baik

                                    </option>

                                    <option
                                        value="Rusak Ringan"
                                        {{ request('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>

                                        Rusak Ringan

                                    </option>

                                    <option
                                        value="Rusak Berat"
                                        {{ request('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>

                                        Rusak Berat

                                    </option>

                                </select>

                            </div>


                            {{-- Stok --}}
                            <div>

                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                                    Stok
                                </label>

                                <select
                                    name="stok"
                                    class="w-full px-3 py-2.5 text-sm bg-white border border-gray-300 rounded-lg
                                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                                    <option value="">
                                        Semua Stok
                                    </option>

                                    <option
                                        value="tersedia"
                                        {{ request('stok') == 'tersedia' ? 'selected' : '' }}>

                                        Tersedia

                                    </option>

                                    <option
                                        value="habis"
                                        {{ request('stok') == 'habis' ? 'selected' : '' }}>

                                        Stok Habis

                                    </option>

                                </select>

                            </div>


                            {{-- Sort --}}
                            <div>

                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                                    Urutan Alat
                                </label>

                                <select
                                    name="sort"
                                    class="w-full px-3 py-2.5 text-sm bg-white border border-gray-300 rounded-lg
                                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                                    <option
                                        value="latest"
                                        {{ $sort === 'latest' ? 'selected' : '' }}>

                                        Terbaru → Terlama

                                    </option>

                                    <option
                                        value="oldest"
                                        {{ $sort === 'oldest' ? 'selected' : '' }}>

                                        Terlama → Terbaru

                                    </option>

                                    <option
                                        value="name_asc"
                                        {{ $sort === 'name_asc' ? 'selected' : '' }}>

                                        Nama (A-Z)

                                    </option>

                                    <option
                                        value="name_desc"
                                        {{ $sort === 'name_desc' ? 'selected' : '' }}>

                                        Nama (Z-A)

                                    </option>

                                    <option
                                        value="stok_desc"
                                        {{ $sort === 'stok_desc' ? 'selected' : '' }}>

                                        Stok Terbanyak

                                    </option>

                                    <option
                                        value="stok_asc"
                                        {{ $sort === 'stok_asc' ? 'selected' : '' }}>

                                        Stok Tersedikit

                                    </option>

                                </select>

                            </div>

                        </div>


                        {{-- Filter Footer --}}
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mt-4 pt-4 border-t border-gray-200">

                            <p class="text-xs text-gray-500">

                                Menampilkan

                                <span class="font-semibold text-gray-700">
                                    {{ $alats->total() }}
                                </span>

                                alat

                            </p>


                            <button
                                type="submit"
                                class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm
                                       font-semibold rounded-lg transition shadow-sm">

                                Terapkan Filter

                            </button>

                        </div>

                    </div>

                </div>

            </form>

        </div>


        {{-- Table --}}
        <div class="overflow-x-auto">

            <table class="w-full text-left border-collapse">

                <thead>

                    <tr class="bg-gray-100 text-gray-600 text-sm uppercase tracking-wider">

                        <th class="py-3 px-4 border-b">
                            Gambar
                        </th>

                        <th class="py-3 px-4 border-b">
                            Nama Alat
                        </th>

                        <th class="py-3 px-4 border-b">
                            Kategori
                        </th>

                        <th class="py-3 px-4 border-b">
                            Stok
                        </th>

                        <th class="py-3 px-4 border-b">
                            Kondisi
                        </th>

                        <th class="py-3 px-4 border-b">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="text-sm">

                    @forelse($alats as $alat)

                        <tr class="hover:bg-gray-50 transition">

                            {{-- Gambar --}}
                            <td class="py-3 px-4 border-b">

                                @if($alat->gambar)

                                    <img
                                        src="{{ asset($alat->gambar) }}"
                                        alt="{{ $alat->nama_alat }}"
                                        class="w-12 h-12 object-cover rounded-lg border">

                                @else

                                    <span class="text-xs text-gray-400 italic">
                                        Tidak ada
                                    </span>

                                @endif

                            </td>


                            {{-- Nama --}}
                            <td class="py-3 px-4 border-b font-medium text-gray-900">

                                {{ $alat->nama_alat }}

                            </td>


                            {{-- Kategori --}}
                            <td class="py-3 px-4 border-b">

                                {{ $alat->kategori->nama_kategori ?? '-' }}

                            </td>


                            {{-- Stok --}}
                            <td class="py-3 px-4 border-b">

                                @if($alat->stok > 0)

                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">

                                        {{ $alat->stok }}

                                    </span>

                                @else

                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">

                                        0

                                    </span>

                                @endif

                            </td>


                            {{-- Kondisi --}}
                            <td class="py-3 px-4 border-b">

                                <span
                                    class="px-2.5 py-1 text-xs font-semibold rounded-full
                                    @if(strtolower($alat->status_kondisi) === 'baik')
                                        bg-emerald-100 text-emerald-800
                                    @elseif(strtolower($alat->status_kondisi) === 'rusak ringan')
                                        bg-amber-100 text-amber-800
                                    @else
                                        bg-red-100 text-red-800
                                    @endif">

                                    {{ $alat->status_kondisi }}

                                </span>

                            </td>


                            {{-- Aksi --}}
                            <td class="py-3 px-4 border-b">

                                <div class="flex items-center space-x-2">

                                    <a
                                        href="{{ route('admin.alat.show', $alat->id) }}"
                                        class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1.5 rounded text-xs font-semibold transition"
                                    >
                                        Detail
                                    </a>

                                    <a
                                        href="{{ route('admin.alat.edit', $alat->id) }}"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs font-semibold transition">

                                        Edit

                                    </a>


                                    <form
                                        action="{{ route('admin.alat.destroy', $alat->id) }}"
                                        method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="button"
                                            onclick="openDeleteModal('{{ $alat->id }}', '{{ addslashes($alat->nama_alat) }}')"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded text-xs font-semibold transition">

                                            Hapus

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="py-8 text-center text-gray-500">

                                Tidak ada alat yang sesuai dengan pencarian atau filter.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        <div class="p-4 border-t border-gray-200 bg-gray-50">
            {{ $alats->links() }}
        </div>

    </div>

{{-- Modal Konfirmasi Hapus --}}
<div
    id="deleteModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4">

    <div class="w-full max-w-md bg-white rounded-xl shadow-xl">

        <div class="p-6">

            <div class="flex items-center gap-3 mb-4">

                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">

                    <svg
                        class="w-5 h-5 text-red-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 9v4m0 4h.01M10.29 3.86l-7.82 14a2 2 0 001.71 3h15.64a2 2 0 001.71-3l-7.82-14a2 2 0 00-3.42 0z" />

                    </svg>

                </div>

                <h3 class="text-lg font-bold text-gray-800">
                    Konfirmasi Hapus
                </h3>

            </div>

            <p class="text-sm text-gray-600">
                Apakah kamu yakin ingin menghapus alat
                <span id="deleteAlatName" class="font-semibold text-gray-800"></span>?
            </p>

            <p class="text-xs text-red-500 mt-2">
                Data yang sudah dihapus tidak dapat dikembalikan.
            </p>

        </div>


        <div class="flex justify-end gap-3 px-6 py-4 bg-gray-50 border-t">

            <button
                type="button"
                onclick="closeDeleteModal()"
                class="px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg transition">

                Batal

            </button>

            <form
                id="deleteAlatForm"
                method="POST">

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="px-4 py-2 text-sm font-semibold text-white bg-red-500 hover:bg-red-600 rounded-lg transition">

                    Ya, Hapus

                </button>

            </form>

        </div>

    </div>

</div>


<script>
    function openDeleteModal(id, nama) {

        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteAlatForm');
        const name = document.getElementById('deleteAlatName');

        name.textContent = nama;

        form.action = `/admin/alat/${id}`;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDeleteModal() {

        const modal = document.getElementById('deleteModal');

        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.getElementById('deleteModal').addEventListener('click', function (event) {

        if (event.target === this) {
            closeDeleteModal();
        }

    });
</script>

@endsection