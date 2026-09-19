@extends('layouts.app')

@section('title', 'Kelola Peminjaman - Panel Admin')
@section('header-title', 'Manajemen Transaksi Peminjaman')

@section('content')

    @if(session('success'))
        <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-lg shadow-sm text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 bg-red-50 border border-red-200 text-red-800 p-4 rounded-lg shadow-sm text-sm">
            {{ session('error') }}
        </div>
    @endif

    <!-- Header -->
    <div class="mb-4 flex flex-col md:flex-row gap-3">

        <!-- Search -->
        <form
            action="{{ route('admin.peminjaman.index') }}"
            method="GET"
            class="flex flex-1"
        >
            <input
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Cari peminjam, email, alat, atau status..."
                class="flex-1 px-4 py-2 text-sm border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            >

            <button
                type="submit"
                class="bg-gray-800 hover:bg-gray-900 text-white px-5 py-2 text-sm font-semibold rounded-r-lg transition"
            >
                Cari
            </button>
        </form>

        <!-- Tambah -->
        <a
            href="{{ route('admin.peminjaman.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition text-center"
        >
            + Tambah Peminjaman
        </a>

    </div>


    <!-- Filter -->
    <div class="bg-gray-50 border border-gray-200 rounded-lg p-5 mb-6">

        <div class="flex items-center justify-between mb-4">

            <div>
                <h3 class="text-sm font-bold text-gray-800">
                    Filter Peminjaman
                </h3>

                <p class="text-xs text-gray-500 mt-1">
                    Gunakan filter untuk menemukan transaksi dengan lebih cepat.
                </p>
            </div>

            @if(request()->hasAny(['search', 'status', 'sort']))
                <a
                    href="{{ route('admin.peminjaman.index') }}"
                    class="text-sm text-blue-600 hover:text-blue-800 font-semibold"
                >
                    Reset semua
                </a>
            @endif

        </div>

        <form
            action="{{ route('admin.peminjaman.index') }}"
            method="GET"
        >

            <input
                type="hidden"
                name="search"
                value="{{ $search }}"
            >

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- Status -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Status
                    </label>

                    <select
                        name="status"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="">Semua Status</option>

                        <option value="diajukan" {{ $status === 'diajukan' ? 'selected' : '' }}>
                            Diajukan
                        </option>

                        <option value="dipinjam" {{ $status === 'dipinjam' ? 'selected' : '' }}>
                            Dipinjam
                        </option>

                        <option value="dikembalikan" {{ $status === 'dikembalikan' ? 'selected' : '' }}>
                            Dikembalikan
                        </option>

                        <option value="telat" {{ $status === 'telat' ? 'selected' : '' }}>
                            Telat
                        </option>
                    </select>
                </div>

                <!-- Sort -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Urutkan
                    </label>

                    <select
                        name="sort"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>
                            Terbaru
                        </option>

                        <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>
                            Terlama
                        </option>

                        <option value="name_asc" {{ $sort === 'name_asc' ? 'selected' : '' }}>
                            Nama Peminjam A-Z
                        </option>

                        <option value="name_desc" {{ $sort === 'name_desc' ? 'selected' : '' }}>
                            Nama Peminjam Z-A
                        </option>
                    </select>
                </div>

            </div>

            <div class="mt-4 flex justify-between items-center">

                <p class="text-xs text-gray-500">
                    Menampilkan {{ $peminjamans->total() }} transaksi.
                </p>

                <button
                    type="submit"
                    class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-semibold transition"
                >
                    Terapkan Filter
                </button>

            </div>

        </form>

    </div>


    <!-- Tabel -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">

        <div class="overflow-x-auto">

            <table class="w-full text-left border-collapse">

                <thead>
                    <tr class="bg-gray-100 text-gray-600 text-sm uppercase tracking-wider">

                        <th class="py-3 px-4 border-b">
                            Peminjam
                        </th>

                        <th class="py-3 px-4 border-b">
                            Alat yang Dipinjam
                        </th>

                        <th class="py-3 px-4 border-b">
                            Tanggal
                        </th>

                        <th class="py-3 px-4 border-b text-center">
                            Status
                        </th>

                        <th class="py-3 px-4 border-b text-center">
                            Aksi
                        </th>

                    </tr>
                </thead>

                <tbody class="text-gray-700 text-sm">

                    @forelse($peminjamans as $peminjaman)

                        <tr class="hover:bg-gray-50 transition align-top">

                            <!-- Peminjam -->
                            <td class="py-3 px-4 border-b">

                                <p class="font-semibold text-gray-900">
                                    {{ $peminjaman->user->name ?? 'User Dihapus' }}
                                </p>

                                @if($peminjaman->user)
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $peminjaman->user->email }}
                                    </p>
                                @endif

                            </td>


                            <!-- Alat -->
                            <td class="py-3 px-4 border-b">

                                <ul class="space-y-1">

                                    @foreach($peminjaman->detailPinjams as $detail)

                                        <li>
                                            <span class="font-semibold text-gray-800">
                                                {{ $detail->alat->nama_alat ?? 'Alat Dihapus' }}
                                            </span>

                                            <span class="text-xs bg-gray-200 text-gray-700 px-1.5 py-0.5 rounded">
                                                {{ $detail->jumlah }} pcs
                                            </span>
                                        </li>

                                    @endforeach

                                </ul>

                            </td>


                            <!-- Tanggal -->
                            <td class="py-3 px-4 border-b text-xs">

                                <p class="text-gray-600">
                                    <span class="font-semibold">
                                        Pinjam:
                                    </span>
                                    {{ $peminjaman->tgl_pinjam }}
                                </p>

                                <p class="text-gray-600 mt-1">
                                    <span class="font-semibold">
                                        Rencana:
                                    </span>
                                    {{ $peminjaman->tgl_kembali_plan }}
                                </p>

                            </td>


                            <!-- Status -->
                            <td class="py-3 px-4 border-b text-center">

                                <span
                                    class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full
                                    @if($peminjaman->status === 'diajukan')
                                        bg-yellow-100 text-yellow-800
                                    @elseif($peminjaman->status === 'dipinjam')
                                        bg-blue-100 text-blue-800
                                    @elseif($peminjaman->status === 'dikembalikan')
                                        bg-emerald-100 text-emerald-800
                                    @elseif($peminjaman->status === 'telat')
                                        bg-red-100 text-red-800
                                    @else
                                        bg-gray-100 text-gray-700
                                    @endif"
                                >
                                    {{ ucfirst($peminjaman->status) }}
                                </span>

                            </td>


                            <!-- Aksi -->
                            <td class="py-3 px-4 border-b">

                                <div class="flex flex-col gap-2">

                                <a
                                    href="{{ route('admin.peminjaman.show', $peminjaman->id) }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs font-semibold transition text-center"
                                >
                                    Detail
                                </a>

                                    <!-- Ubah Status -->
                                    <form
                                        action="{{ route('admin.peminjaman.updateStatus', $peminjaman->id) }}"
                                        method="POST"
                                    >

                                        @csrf
                                        @method('PUT')

                                        <select
                                            name="status"
                                            onchange="this.form.submit()"
                                            class="w-full text-xs border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-500"
                                        >

                                            <option value="diajukan"
                                                {{ $peminjaman->status === 'diajukan' ? 'selected' : '' }}>
                                                Diajukan
                                            </option>

                                            <option value="dipinjam"
                                                {{ $peminjaman->status === 'dipinjam' ? 'selected' : '' }}>
                                                Dipinjam
                                            </option>

                                            <option value="dikembalikan"
                                                {{ $peminjaman->status === 'dikembalikan' ? 'selected' : '' }}>
                                                Dikembalikan
                                            </option>

                                            <option value="telat"
                                                {{ $peminjaman->status === 'telat' ? 'selected' : '' }}>
                                                Telat
                                            </option>

                                        </select>

                                    </form>


                                    <!-- Hapus -->
                                    <form
                                        action="{{ route('admin.peminjaman.destroy', $peminjaman->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data peminjaman ini?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-semibold transition w-full"
                                        >
                                            Hapus
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="py-8 text-center text-gray-500"
                            >
                                Belum ada data peminjaman.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        <!-- Pagination -->
        @if($peminjamans->hasPages())

            <div class="p-4 border-t border-gray-200 bg-gray-50">
                {{ $peminjamans->links() }}
            </div>

        @endif

    </div>

@endsection