@extends('layouts.app')
@section('title', 'Kelola User - Panel Admin')
@section('header-title', 'Manajemen Pengguna Sistem')

@section('content')

    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-lg shadow-sm text-sm">
            {{ session('success') }}
        </div>
    @endif


    <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">

        {{-- Header --}}
        <div class="p-5 border-b border-gray-200 bg-gray-50">

            <h3 class="text-lg font-bold text-gray-800">
                Daftar Pengguna Sistem
            </h3>

            {{-- Statistik --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-5">

                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Total User</p>

                    <h3 class="text-2xl font-bold text-gray-800 mt-1">
                        {{ $totalUser }}
                    </h3>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Admin</p>

                    <h3 class="text-2xl font-bold text-gray-800 mt-1">
                        {{ $totalAdmin }}
                    </h3>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Petugas</p>

                    <h3 class="text-2xl font-bold text-gray-800 mt-1">
                        {{ $totalPetugas }}
                    </h3>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Peminjam</p>

                    <h3 class="text-2xl font-bold text-gray-800 mt-1">
                        {{ $totalPeminjam }}
                    </h3>
                </div>
            </div>

            {{-- Search + Filter --}}
            <form action="{{ route('admin.user.index') }}" method="GET" class="mt-6">

                {{-- Search + Tambah User --}}
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
                                placeholder="Cari nama atau email..."
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


                    {{-- Tambah User --}}
                    <a
                        href="{{ route('admin.user.create') }}"
                        class="inline-flex items-center justify-center px-5 py-3
                               bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold
                               rounded-xl transition shadow-sm whitespace-nowrap">

                        + Tambah User

                    </a>

                </div>


                {{-- Filter Panel --}}
                <div class="w-full mt-4">

                    <div class="w-full p-4 bg-gray-50 border border-gray-200 rounded-xl">

                        {{-- Filter Header --}}
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">

                            <div>

                                <h4 class="text-sm font-bold text-gray-800">
                                    Filter Pengguna
                                </h4>

                                <p class="text-xs text-gray-500 mt-0.5">
                                    Gunakan filter untuk mempersempit hasil pencarian.
                                </p>

                            </div>


                            @if(request()->hasAny(['search', 'role', 'jenis_kelamin', 'status', 'sort']))

                                <a
                                    href="{{ route('admin.user.index') }}"
                                    class="text-xs font-semibold text-red-600 hover:text-red-700 transition">

                                    Reset semua

                                </a>

                            @endif

                        </div>


                        {{-- Filter Fields --}}
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">

                            {{-- Role --}}
                            <div>

                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                                    Role
                                </label>

                                <select
                                    name="role"
                                    class="w-full px-3 py-2.5 text-sm bg-white border border-gray-300 rounded-lg
                                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                                    <option value="">
                                        Semua Role
                                    </option>

                                    <option
                                        value="admin"
                                        {{ request('role') == 'admin' ? 'selected' : '' }}>
                                        Admin
                                    </option>

                                    <option
                                        value="petugas"
                                        {{ request('role') == 'petugas' ? 'selected' : '' }}>
                                        Petugas
                                    </option>

                                    <option
                                        value="peminjam"
                                        {{ request('role') == 'peminjam' ? 'selected' : '' }}>
                                        Peminjam
                                    </option>

                                </select>

                            </div>


                            {{-- Jenis Kelamin --}}
                            <div>

                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                                    Jenis Kelamin
                                </label>

                                <select
                                    name="jenis_kelamin"
                                    class="w-full px-3 py-2.5 text-sm bg-white border border-gray-300 rounded-lg
                                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                                    <option value="">
                                        Semua Jenis Kelamin
                                    </option>

                                    <option
                                        value="L"
                                        {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>
                                        Laki-laki
                                    </option>

                                    <option
                                        value="P"
                                        {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>
                                        Perempuan
                                    </option>

                                </select>

                            </div>


                            {{-- Status --}}
                            <div>

                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                                    Status
                                </label>

                                <select
                                    name="status"
                                    class="w-full px-3 py-2.5 text-sm bg-white border border-gray-300 rounded-lg
                                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                                    <option value="">
                                        Semua Status
                                    </option>

                                    <option
                                        value="aktif"
                                        {{ request('status') == 'aktif' ? 'selected' : '' }}>
                                        Aktif
                                    </option>

                                    <option
                                        value="nonaktif"
                                        {{ request('status') == 'nonaktif' ? 'selected' : '' }}>
                                        Nonaktif
                                    </option>

                                </select>

                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Urutan User
                                </label>

                                <select name="sort"
                                    class="w-full px-3 py-2.5 text-sm bg-white border border-gray-300 rounded-lg
                                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>
                                        Terbaru → Terlama
                                    </option>
                                    <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>
                                        Terlama → Terbaru
                                    </option>
                                    <option value="name_asc" {{ $sort === 'name_asc' ? 'selected' : '' }}>
                                        Nama (A-Z)
                                    </option>
                                    <option value="name_desc" {{ $sort === 'name_desc' ? 'selected' : '' }}>
                                        Nama (Z-A)
                                    </option>
                                </select>
                            </div>

                        </div>


                        {{-- Filter Footer --}}
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mt-4 pt-4 border-t border-gray-200">

                            <p class="text-xs text-gray-500">

                                Menampilkan

                                <span class="font-semibold text-gray-700">
                                    {{ $users->total() }}
                                </span>

                                pengguna

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
                            Foto
                        </th>

                        <th class="py-3 px-4 border-b">
                            Nama
                        </th>

                        <th class="py-3 px-4 border-b">
                            Jenis Kelamin
                        </th>

                        <th class="py-3 px-4 border-b">
                            Email
                        </th>

                        <th class="py-3 px-4 border-b">
                            Role / Hak Akses
                        </th>

                        <th class="py-3 px-4 border-b">
                            Status
                        </th>

                        <th class="py-3 px-4 border-b">
                            No. HP
                        </th>

                        <th class="py-3 px-4 border-b">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="text-gray-700 text-sm">

                    @forelse($users as $user)

                        <tr class="hover:bg-gray-50 transition">

                            {{-- Foto --}}
                            <td class="py-3 px-4 border-b">

                                @if($user->foto_profile)

                                    <img
                                        src="{{ asset($user->foto_profile) }}"
                                        alt="{{ $user->name }}"
                                        class="w-12 h-12 object-cover rounded-full border">

                                @else

                                    <span class="text-xs text-gray-400 italic">
                                        Tidak ada
                                    </span>

                                @endif

                            </td>


                            {{-- Nama --}}
                            <td class="py-3 px-4 border-b font-medium text-gray-900">
                                {{ $user->name }}
                            </td>


                            {{-- Jenis Kelamin --}}
                            <td class="py-3 px-4 border-b">

                                @if($user->jenis_kelamin == 'L')

                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Laki-laki
                                    </span>

                                @elseif($user->jenis_kelamin == 'P')

                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-pink-100 text-pink-800">
                                        Perempuan
                                    </span>

                                @else

                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                        -
                                    </span>

                                @endif

                            </td>


                            {{-- Email --}}
                            <td class="py-3 px-4 border-b">
                                {{ $user->email }}
                            </td>


                            {{-- Role --}}
                            <td class="py-3 px-4 border-b">

                                <span
                                    class="px-2.5 py-1 text-xs font-semibold rounded-full
                                    @if($user->role == 'admin')
                                        bg-purple-100 text-purple-800
                                    @elseif($user->role == 'petugas')
                                        bg-blue-100 text-blue-800
                                    @else
                                        bg-green-100 text-green-800
                                    @endif">

                                    {{ ucfirst($user->role) }}

                                </span>

                            </td>


                            {{-- Status --}}
                            <td class="py-3 px-4 border-b">

                                @if($user->status == 'aktif')

                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Aktif
                                    </span>

                                @else

                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        Nonaktif
                                    </span>

                                @endif

                            </td>


                            {{-- No HP --}}
                            <td class="py-3 px-4 border-b">
                                {{ $user->no_hp ?? '-' }}
                            </td>


                            {{-- Aksi --}}
                            <td class="py-3 px-4 border-b">

                                <div class="flex items-center space-x-2">

                                    <a
                                        href="{{ route('admin.user.show', $user->id) }}"
                                        class="text-blue-600 hover:text-blue-800 font-medium">

                                        Detail

                                    </a>


                                    <a
                                        href="{{ route('admin.user.edit', $user->id) }}"
                                        class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-1.5 rounded text-xs font-semibold transition">

                                        Edit

                                    </a>


                                    <form
                                        action="{{ route('admin.user.destroy', $user->id) }}"
                                        method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="button"
                                            onclick="openDeleteModal({{ $user->id }}, '{{ addslashes($user->name) }}')"
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
                                colspan="8"
                                class="py-8 text-center text-gray-500">

                                Tidak ada pengguna yang sesuai dengan pencarian atau filter.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        <div class="p-4 border-t border-gray-200 bg-gray-50">
            {{ $users->links() }}
        </div>

    </div>


    {{-- Delete Modal --}}
    <div
        id="deleteModal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">

        <div class="bg-white rounded-xl shadow-xl w-full max-w-md">

            <div class="p-6">

                <h3 class="text-lg font-bold text-gray-800">
                    Konfirmasi Hapus User
                </h3>


                <p class="text-sm text-gray-600 mt-2">

                    Yakin ingin menghapus user

                    <span
                        id="deleteUserName"
                        class="font-semibold text-gray-800">
                    </span>?

                </p>


                <p class="text-xs text-red-500 mt-2">
                    Data user yang dihapus tidak dapat dikembalikan.
                </p>


                <div class="flex justify-end gap-3 mt-6">

                    <button
                        type="button"
                        onclick="closeDeleteModal()"
                        class="px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg">

                        Batal

                    </button>


                    <form
                        id="deleteUserForm"
                        method="POST">

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="px-4 py-2 text-sm font-semibold text-white bg-red-500 hover:bg-red-600 rounded-lg">

                            Hapus

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>


    {{-- Delete Modal Script --}}
    <script>

        function openDeleteModal(id, name) {

            document.getElementById('deleteUserName').textContent = name;

            document.getElementById('deleteUserForm').action =
                `/admin/users/${id}`;

            document.getElementById('deleteModal').classList.remove('hidden');

        }


        function closeDeleteModal() {

            document.getElementById('deleteModal').classList.add('hidden');

        }

    </script>

@endsection