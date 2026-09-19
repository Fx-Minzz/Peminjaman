@extends('layouts.app')

@section('title', 'Kelola Kategori - Panel Admin')
@section('header-title', 'Manajemen Kategori Alat')

@section('content')

    <!-- Notifikasi -->
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

    <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">

        <div class="p-5 border-b border-gray-200 bg-gray-50 flex flex-col md:flex-row justify-between items-center gap-4">

            <h3 class="text-lg font-bold text-gray-800">
                Daftar Kategori Alat
            </h3>

            <div class="flex items-center gap-3 w-full md:w-auto">

                <!-- Form Search + Sort -->
                <form action="{{ route('admin.kategori.index') }}" method="GET"
                    class="flex flex-col sm:flex-row w-full md:w-auto gap-2">

                    <div class="flex w-full md:w-80">

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nama kategori..."
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-l-lg
                                focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >

                        <button
                            type="submit"
                            class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2
                                text-sm font-semibold rounded-r-lg transition">
                            Cari
                        </button>

                    </div>

                    <select
                        name="sort"
                        onchange="this.form.submit()"
                        class="px-3 py-2 text-sm border border-gray-300 rounded-lg
                            focus:outline-none focus:ring-2 focus:ring-blue-500">

                        <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>
                            Terbaru → Terlama
                        </option>

                        <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>
                            Terlama → Terbaru
                        </option>

                        <option value="name_asc" {{ $sort === 'name_asc' ? 'selected' : '' }}>
                            Nama A → Z
                        </option>

                        <option value="name_desc" {{ $sort === 'name_desc' ? 'selected' : '' }}>
                            Nama Z → A
                        </option>

                    </select>

                    @if(request('search') || request('sort') && request('sort') !== 'latest')
                        <a
                            href="{{ route('admin.kategori.index') }}"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-3 py-2
                                text-sm rounded-lg flex items-center justify-center transition">
                            Reset
                        </a>
                    @endif

                </form>

                <!-- Tombol Tambah -->
                <a
                    href="{{ route('admin.kategori.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition whitespace-nowrap">
                    + Tambah Kategori
                </a>

            </div>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-left border-collapse">

                <thead>
                    <tr class="bg-gray-100 text-gray-600 text-sm uppercase tracking-wider">
                        <th class="py-3 px-4 border-b w-16 text-center">No</th>
                        <th class="py-3 px-4 border-b">Nama Kategori</th>
                        <th class="py-3 px-4 border-b w-32 text-center">Jumlah Alat</th>
                        <th class="py-3 px-4 border-b w-48">Aksi</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700 text-sm">

                    @forelse($kategoris as $index => $kategori)

                        <tr class="hover:bg-gray-50 transition">

                            <td class="py-3 px-4 border-b text-center">
                                {{ $kategoris->firstItem() + $index }}
                            </td>

                            <td class="py-3 px-4 border-b font-medium">
                                <a href="{{ route('admin.kategori.show', $kategori->id) }}" class="text-blue-600 hover:text-blue-800 hover:underline transition">
                                    {{ $kategori->nama_kategori }}
                                </a>
                            </td>

                            <td class="py-3 px-4 border-b text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                    {{ $kategori->alat_count }} alat
                                </span>
                            </td>

                            <td class="py-3 px-4 border-b">

                                <div class="flex items-center space-x-2">

                                    <a
                                        href="{{ route('admin.kategori.edit', $kategori->id) }}"
                                        class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-1.5 rounded text-xs font-semibold transition">
                                        Edit
                                    </a>

                                    <button
                                        type="button"
                                        onclick="openDeleteModal(
                                            '{{ $kategori->id }}',
                                            '{{ addslashes($kategori->nama_kategori) }}'
                                        )"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded text-xs font-semibold transition">
                                        Hapus
                                    </button>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" class="py-4 text-center text-gray-500">
                                Belum ada data kategori.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <!-- Pagination -->
        <div class="p-4 border-t border-gray-200 bg-gray-50">
            {{ $kategoris->links() }}
        </div>

    </div>

<!-- Modal Konfirmasi Hapus -->
<div
    id="deleteModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4">

    <div class="bg-white rounded-xl shadow-xl w-full max-w-md">

        <div class="p-6">

            <div class="flex items-center justify-center w-12 h-12 mx-auto mb-4 rounded-full bg-red-100">
                <svg
                    class="w-6 h-6 text-red-600"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 9v4m0 4h.01M10.29 3.86l-7.82 14a2 2 0 001.74 3h15.58a2 2 0 001.74-3l-7.82-14a2 2 0 00-3.42 0z" />

                </svg>
            </div>

            <h3 class="text-lg font-bold text-gray-800 text-center">
                Hapus Kategori?
            </h3>

            <p class="text-sm text-gray-500 text-center mt-2">
                Yakin ingin menghapus kategori
                <span
                    id="deleteCategoryName"
                    class="font-semibold text-gray-800">
                </span>?
            </p>

            <p class="text-xs text-red-500 text-center mt-2">
                Tindakan ini tidak dapat dibatalkan.
            </p>

        </div>

        <div class="flex justify-end gap-3 px-6 py-4 bg-gray-50 rounded-b-xl">

            <button
                type="button"
                onclick="closeDeleteModal()"
                class="px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg transition">
                Batal
            </button>

            <form id="deleteCategoryForm" method="POST">

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="px-4 py-2 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg transition">
                    Ya, Hapus
                </button>

            </form>

        </div>

    </div>

</div>

<script>
    function openDeleteModal(id, nama) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteCategoryForm');
        const name = document.getElementById('deleteCategoryName');

        form.action = `/admin/kategori/${id}`;
        name.textContent = nama;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');

        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }

    document.getElementById('deleteModal').addEventListener('click', function (event) {
        if (event.target === this) {
            closeDeleteModal();
        }
    });
</script>

@endsection