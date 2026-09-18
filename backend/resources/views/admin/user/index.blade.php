@extends('layouts.app')

@section('title', 'Kelola User - Panel Admin')
@section('header-title', 'Manajemen Pengguna Sistem')

@section('content')

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-lg shadow-sm text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">

        <div class="p-5 border-b border-gray-200 bg-gray-50">
    <h3 class="text-lg font-bold text-gray-800">
        Daftar Pengguna Sistem
    </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

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

        <div class="flex items-center gap-3 w-full md:w-auto mt-4">

        <!-- Form Search -->
        <form action="{{ route('admin.user.index') }}" method="GET" class="flex w-full md:w-80">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama, email, role..."
                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

            <button
                type="submit"
                class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 text-sm font-semibold rounded-r-lg transition">
                Cari
            </button>

        </form>

        @if(request('search'))
            <a href="{{ route('admin.user.index') }}"
                class="ml-2 bg-gray-300 hover:bg-gray-400 text-gray-700 px-3 py-2 text-sm rounded-lg flex items-center transition"
                title="Reset Pencarian">
                Reset
            </a>
        @endif

        <!-- Tombol Tambah User -->
        <a href="{{ route('admin.user.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition whitespace-nowrap">
            + Tambah User
        </a>

    </div>
</div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 text-sm uppercase tracking-wider">
                        <th class="py-3 px-4 border-b">Foto</th>
                        <th class="py-3 px-4 border-b">Nama</th>
                        <th class="py-3 px-4 border-b">Jenis Kelamin</th>
                        <th class="py-3 px-4 border-b">Email</th>
                        <th class="py-3 px-4 border-b">Role / Hak Akses</th>
                        <th class="py-3 px-4 border-b">Status</th>
                        <th class="py-3 px-4 border-b">No. HP</th>
                        <th class="py-3 px-4 border-b">Aksi</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700 text-sm">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                             <td class="py-3 px-4 border-b">
                            @if($user->foto_profile)
                                <img
                                    src="{{ asset($user->foto_profile) }}"
                                    alt="{{ $user->name }}"
                                    class="w-12 h-12 object-cover rounded-full border"
                                >
                            @else
                                <span class="text-xs text-gray-400 italic">
                                    Tidak ada
                                </span>
                            @endif
                        </td>
                            <td class="py-3 px-4 border-b font-medium text-gray-900">
                                {{ $user->name }}
                            </td>

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

                            <td class="py-3 px-4 border-b">
                                {{ $user->email }}
                            </td>

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

                            <td class="py-3 px-4 border-b">
                                {{ $user->no_hp ?? '-' }}
                            </td>
                                <div class="flex items-center space-x-2">

                                    <td class="py-3 px-4 border-b">
                                        <div class="flex items-center space-x-2">

                                            <!-- Tombol Detail -->
                                            <a href="{{ route('admin.user.show', $user->id) }}"
                                                class="text-blue-600 hover:text-blue-800 font-medium">
                                                Detail
                                            </a>

                                            <!-- Tombol Edit -->
                                            <a href="{{ route('admin.user.edit', $user->id) }}"
                                                class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-1.5 rounded text-xs font-semibold transition">
                                                Edit
                                            </a>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('admin.user.destroy', $user->id) }}"
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

                                </div>

                            </td>

                        </tr>
                    @empty

                        <tr>
                            <td colspan="8" class="py-4 text-center text-gray-500">
                                Belum ada data pengguna.
                            </td>
                        </tr>

                    @endforelse
                </tbody>

            </table>
        </div>

        <div class="p-4 border-t border-gray-200 bg-gray-50">
    {{ $users->links() }}
</div>

    </div>

<div id="deleteModal"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">

    <div class="bg-white rounded-xl shadow-xl w-full max-w-md">
        <div class="p-6">
            <h3 class="text-lg font-bold text-gray-800">
                Konfirmasi Hapus User
            </h3>

            <p class="text-sm text-gray-600 mt-2">
                Yakin ingin menghapus user
                <span id="deleteUserName" class="font-semibold text-gray-800"></span>?
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

                <form id="deleteUserForm" method="POST">
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