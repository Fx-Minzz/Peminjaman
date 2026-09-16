<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Kategori;
use App\Models\LogAktivitas;
use App\Models\User;
use App\Models\Pengembalian;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\DetailPinjam;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // Menampilkan Dashboard Admin & Log Aktivitas
    public function index()
    {
        $totalUser = User::count();
        $totalAlat = Alat::count();
        $totalPeminjaman = Peminjaman::count();
        $menungguPersetujuan = Peminjaman::where('status', 'diajukan')->count();
        $sedangDipinjam = Peminjaman::where('status', 'dipinjam')->count();
        $peminjamanSelesai = Peminjaman::where('status', 'dikembalikan')->count();
        $logsTerbaru = LogAktivitas::with('user')
            ->latest()
            ->take(5)
            ->get();
        return view('admin.dashboard', compact(
            'totalUser',
            'totalAlat',
            'totalPeminjaman',
            'menungguPersetujuan',
            'sedangDipinjam',
            'peminjamanSelesai',
            'logsTerbaru'
        ));
    }

    // CRUD Alat: Menampilkan daftar alat
public function indexAlat(Request $request)
{
    $search = $request->input('search');

    $alats = Alat::with('kategori')
        ->when($search, function ($query, $search) {
            return $query->where('nama_alat', 'like', "%{$search}%")
                ->orWhere('status_kondisi', 'like', "%{$search}%")
                ->orWhereHas('kategori', function ($q) use ($search) {
                    $q->where('nama_kategori', 'like', "%{$search}%");
                });
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view('admin.alat.index', compact('alats', 'search'));
}

// 2. Menampilkan form tambah alat
public function createAlat()
{
    $kategoris = Kategori::all();

    return view('admin.alat.create', compact('kategoris'));
}

    // 3. Menyimpan alat baru
public function storeAlat(Request $request)
{
    $request->validate([
        'nama_alat' => 'required|string|max:255',
        'kategori_id' => 'required|exists:kategori,id',
        'stok' => 'required|integer|min:0',
        'status_kondisi' => 'required|string|max:100',
        'deskripsi' => 'nullable|string',
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $data = $request->all();

    // Handle Upload Gambar jika ada
    if ($request->hasFile('gambar')) {
        $file = $request->file('gambar');
        $filename = time() . '_' . $file->getClientOriginalName();

        $file->move(public_path('storage/alat'), $filename);

        $data['gambar'] = 'storage/alat/' . $filename;
    }

    Alat::create($data);

    return redirect()
        ->route('admin.alat.index')
        ->with('success', 'Data alat berhasil ditambahkan.');
}

// 4. Menampilkan form edit alat
public function editAlat($id)
{
    $alat = Alat::findOrFail($id);
    $kategoris = Kategori::all();

    return view('admin.alat.edit', compact('alat', 'kategoris'));
}

// 5. Memperbarui data alat
public function updateAlat(Request $request, $id)
{
    $alat = Alat::findOrFail($id);

    $request->validate([
        'nama_alat' => 'required|string|max:255',
        'kategori_id' => 'required|exists:kategori,id',
        'stok' => 'required|integer|min:0',
        'status_kondisi' => 'required|string|max:100',
        'deskripsi' => 'nullable|string',
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $data = $request->all();

    // Handle Upload Gambar jika ada file baru
    if ($request->hasFile('gambar')) {

        // Hapus gambar lama jika ada
        if ($alat->gambar && file_exists(public_path($alat->gambar))) {
            unlink(public_path($alat->gambar));
        }

        $file = $request->file('gambar');
        $filename = time() . '_' . $file->getClientOriginalName();

        $file->move(public_path('storage/alat'), $filename);

        $data['gambar'] = 'storage/alat/' . $filename;
    }

    $alat->update($data);

    return redirect()
        ->route('admin.alat.index')
        ->with('success', 'Data alat berhasil diperbarui.');
}

// 6. Menghapus data alat
public function destroyAlat($id)
{
    $alat = Alat::findOrFail($id);

    // Hapus file gambar fisik jika ada
    if ($alat->gambar && file_exists(public_path($alat->gambar))) {
        unlink(public_path($alat->gambar));
    }

    $alat->delete();

    return redirect()
        ->route('admin.alat.index')
        ->with('success', 'Data alat berhasil dihapus.');
}

// PENGEMBALIAN

// 1. Menampilkan daftar pengembalian
public function indexPengembalian(Request $request)
{
    $search = $request->input('search');

    $pengembalians = \App\Models\Pengembalian::with([
        'peminjaman.user',
        'peminjaman.detailPinjams.alat',
        'petugas'
    ])
    ->when($search, function ($query, $search) {
        $query->whereHas('peminjaman.user', function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%");
        });
    })
    ->latest()
    ->paginate(10)
    ->withQueryString();

    return view('admin.pengembalian.index', compact(
        'pengembalians',
        'search'
    ));
}

// 2. Menampilkan form pengembalian
public function createPengembalian()
{
    $peminjamans = Peminjaman::with([
        'user',
        'detailPinjams.alat'
    ])
        ->whereIn('status', ['dipinjam', 'telat', 'dikembalikan'])
        ->whereDoesntHave('pengembalian')
        ->latest()
        ->get();

    return view(
        'admin.pengembalian.create',
        compact('peminjamans')
    );
}

// 3. Menyimpan data pengembalian
public function storePengembalian(Request $request)
{
    $request->validate([
        'peminjaman_id' => 'required|exists:peminjaman,id',
        'tgl_kembali' => 'required|date',
        'kondisi_kembali' => 'required|string|max:100',
        'denda_kerusakan' => 'nullable|integer|min:0',
    ]);

    DB::beginTransaction();

    try {

        $peminjaman = Peminjaman::with('detailPinjams.alat')
            ->findOrFail($request->peminjaman_id);

        // Pastikan hanya peminjaman aktif yang dapat dikembalikan
        if (!in_array($peminjaman->status, ['dipinjam', 'telat'])) {
            throw new \Exception(
                'Peminjaman ini tidak dapat diproses sebagai pengembalian.'
            );
        }

        // Pastikan belum pernah memiliki data pengembalian
        if ($peminjaman->pengembalian()->exists()) {
            throw new \Exception(
                'Peminjaman ini sudah memiliki data pengembalian.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Hitung keterlambatan
        |--------------------------------------------------------------------------
        */

        $tglRencana = \Carbon\Carbon::parse(
            $peminjaman->tgl_kembali_plan
        );

        $tglKembali = \Carbon\Carbon::parse(
            $request->tgl_kembali
        );

        $hariTerlambat = 0;

        if ($tglKembali->greaterThan($tglRencana)) {
            $hariTerlambat = $tglRencana->diffInDays($tglKembali);
        }

        // Rp1.000 per hari
        $dendaKeterlambatan = $hariTerlambat * 1000;

        // Denda kerusakan ditentukan admin/petugas
        $dendaKerusakan = $request->denda_kerusakan ?? 0;

        // Total denda
        $totalDenda = $dendaKeterlambatan + $dendaKerusakan;

        /*
        |--------------------------------------------------------------------------
        | Simpan pengembalian
        |--------------------------------------------------------------------------
        */

        \App\Models\Pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'tgl_kembali' => $request->tgl_kembali,
            'kondisi_kembali' => $request->kondisi_kembali,
            'denda' => $totalDenda,
            'petugas_id' => auth()->id(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Kembalikan stok alat
        |--------------------------------------------------------------------------
        */

        foreach ($peminjaman->detailPinjams as $detail) {
            $detail->alat->increment('stok', $detail->jumlah);
        }

        /*
        |--------------------------------------------------------------------------
        | Ubah status peminjaman
        |--------------------------------------------------------------------------
        */

        $peminjaman->update([
            'status' => 'dikembalikan',
        ]);

        DB::commit();

        return redirect()
            ->route('admin.pengembalian.index')
            ->with('success', 'Pengembalian berhasil dicatat.');

    } catch (\Exception $e) {

        DB::rollBack();

        return back()
            ->withInput()
            ->with('error', $e->getMessage());
    }
}

// 4. Menghapus data pengembalian
public function destroyPengembalian($id)
{
    DB::beginTransaction();

    try {

        $pengembalian = Pengembalian::with([
            'peminjaman.detailPinjams.alat'
        ])->findOrFail($id);

        $peminjaman = $pengembalian->peminjaman;

        // Karena pengembalian dibatalkan,
        // stok harus dikurangi kembali.
        foreach ($peminjaman->detailPinjams as $detail) {

            $alat = $detail->alat;

            if ($alat->stok < $detail->jumlah) {
                throw new \Exception(
                    "Stok alat '{$alat->nama_alat}' tidak mencukupi untuk membatalkan pengembalian."
                );
            }

            $alat->decrement('stok', $detail->jumlah);
        }

        // Kembalikan status peminjaman
        $peminjaman->update([
            'status' => 'dipinjam'
        ]);

        // Hapus data pengembalian
        $pengembalian->delete();

        DB::commit();

        return redirect()
            ->route('admin.pengembalian.index')
            ->with(
                'success',
                'Data pengembalian berhasil dihapus dan status peminjaman dikembalikan menjadi dipinjam.'
            );

    } catch (\Exception $e) {

        DB::rollBack();

        return back()->with(
            'error',
            $e->getMessage()
        );
    }
}

public function updatePengembalian(Request $request, $id)
{
    $request->validate([
        'tgl_kembali' => 'required|date',
        'kondisi_kembali' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
        'denda_kerusakan' => 'nullable|integer|min:0',
    ]);

    DB::beginTransaction();

    try {

        $pengembalian = Pengembalian::with('peminjaman')
            ->findOrFail($id);

        $peminjaman = $pengembalian->peminjaman;

        $tglKembali = Carbon::parse($request->tgl_kembali);
        $tglRencana = Carbon::parse($peminjaman->tgl_kembali_plan);

        $hariTerlambat = 0;

        if ($tglKembali->greaterThan($tglRencana)) {
            $hariTerlambat = $tglRencana->diffInDays($tglKembali);
        }

        // Rp1.000 per hari
        $dendaKeterlambatan = $hariTerlambat * 1000;

        // Denda kerusakan manual
        $dendaKerusakan = (int) ($request->denda_kerusakan ?? 0);

        // Total
        $totalDenda = $dendaKeterlambatan + $dendaKerusakan;

        $pengembalian->update([
            'tgl_kembali' => $request->tgl_kembali,
            'kondisi_kembali' => $request->kondisi_kembali,
            'denda_kerusakan' => $dendaKerusakan,
            'denda' => $totalDenda,
        ]);

        DB::commit();

        return redirect()
            ->route('admin.pengembalian.index')
            ->with('success', 'Data pengembalian berhasil diperbarui.');

    } catch (\Exception $e) {

        DB::rollBack();

        return back()
            ->withInput()
            ->with('error', $e->getMessage());
    }
}

public function editPengembalian($id)
{
    $pengembalian = Pengembalian::with([
        'peminjaman.user',
        'peminjaman.detailPinjams.alat'
    ])->findOrFail($id);

    return view(
        'admin.pengembalian.edit',
        compact('pengembalian')
    );
}

// 7. Memproses pengembalian
public function prosesPengembalian($id)
{
    $peminjaman = Peminjaman::with('detailPinjams.alat')
        ->findOrFail($id);

    // Pastikan hanya peminjaman yang sedang dipinjam atau telat
    // yang bisa diproses pengembaliannya
    if (!in_array($peminjaman->status, ['dipinjam', 'telat'])) {
        return back()->with(
            'error',
            'Peminjaman ini tidak dapat diproses sebagai pengembalian.'
        );
    }

    DB::beginTransaction();

    try {
        // Kembalikan stok semua alat
        foreach ($peminjaman->detailPinjams as $detail) {
            $detail->alat->increment('stok', $detail->jumlah);
        }

        // Ubah status menjadi dikembalikan
        $peminjaman->update([
            'status' => 'dikembalikan'
        ]);

        DB::commit();

        return redirect()
            ->route('admin.pengembalian.index')
            ->with('success', 'Pengembalian berhasil diproses.');

    } catch (\Exception $e) {
        DB::rollBack();

        return back()->with(
            'error',
            'Pengembalian gagal diproses: ' . $e->getMessage()
        );
    }
}

    // CRUD User (Manajemen User Admin, Petugas, Peminjam)
public function indexUser(Request $request)
{
    $search = $request->input('search');

    $users = User::when($search, function ($query, $search) {
        return $query->where('name', 'like', "%{$search}%")
                     ->orWhere('email', 'like', "%{$search}%")
                     ->orWhere('role', 'like', "%{$search}%");
    })
      ->latest()
        ->paginate(10) // Tampilkan 10 data per halaman
            ->withQueryString(); // memastikan parameter search tetap ada saat pindah halaman

    return view('admin.user.index', compact('users', 'search'));
}

// Menampilkan Form Tambah User
public function createUser()
{
    return view('admin.user.create');
}

// Menyimpan User Baru
public function storeUser(Request $request)
{
    $request->validate([
        'name'         => 'required|string|max:255',
        'email'        => 'required|string|email|max:255|unique:users',
        'password'     => 'required|string|min:6',
        'role'         => 'required|in:admin,petugas,peminjam',
        'no_hp'        => 'nullable|string|max:20',
        'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $data = [
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
        'role'     => $request->role,
        'no_hp'    => $request->no_hp,
    ];

    // Upload foto profil jika ada
    if ($request->hasFile('foto_profile')) {

        $file = $request->file('foto_profile');

        $filename = time() . '_' . $file->getClientOriginalName();

        $file->move(
            public_path('storage/profile'),
            $filename
        );

        $data['foto_profile'] = 'storage/profile/' . $filename;
    }

    User::create($data);

    return redirect()
        ->route('admin.user.index')
        ->with('success', 'User berhasil ditambahkan.');
}

// Menampilkan Form Edit User
public function editUser($id)
{
    $user = User::findOrFail($id);

    return view('admin.user.edit', compact('user'));
}

// Memperbarui Data User
public function updateUser(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name'         => 'required|string|max:255',
        'email'        => 'required|string|email|max:255|unique:users,email,' . $id,
        'role'         => 'required|in:admin,petugas,peminjam',
        'no_hp'        => 'nullable|string|max:20',
        'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $data = [
        'name'  => $request->name,
        'email' => $request->email,
        'role'  => $request->role,
        'no_hp' => $request->no_hp,
    ];

    // Update password jika diisi
    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    // Upload foto baru jika ada
    if ($request->hasFile('foto_profile')) {

        // Hapus foto lama
        if (
            $user->foto_profile &&
            file_exists(public_path($user->foto_profile))
        ) {
            unlink(public_path($user->foto_profile));
        }

        $file = $request->file('foto_profile');

        $filename = time() . '_' . $file->getClientOriginalName();

        $file->move(
            public_path('storage/profile'),
            $filename
        );

        $data['foto_profile'] = 'storage/profile/' . $filename;
    }

    $user->update($data);

    return redirect()
        ->route('admin.user.index')
        ->with('success', 'Data user berhasil diperbarui.');
}

// Menghapus User
public function destroyUser($id)
{
    $user = User::findOrFail($id);

    // Hapus file foto profil jika ada
    if (
        $user->foto_profile &&
        file_exists(public_path($user->foto_profile))
    ) {
        unlink(public_path($user->foto_profile));
    }

    $user->delete();

    return redirect()
        ->route('admin.user.index')
        ->with('success', 'User berhasil dihapus.');
}
//KATEGORI

public function indexKategori(Request $request)
{
    $search = $request->input('search');

    $kategoris = Kategori::when($search, function ($query, $search) {
        return $query->where('nama_kategori', 'like', "%{$search}%");
    })
        ->latest()
        ->paginate(5)
        ->withQueryString();

    return view('admin.kategori.index', compact('kategoris', 'search'));
}

public function createKategori()
{
    return view('admin.kategori.create');
}

public function storeKategori(Request $request)
{
    $request->validate([
        'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori',
    ]);

    Kategori::create([
        'nama_kategori' => $request->nama_kategori,
    ]);

    return redirect()
        ->route('admin.kategori.index')
        ->with('success', 'Kategori berhasil ditambahkan.');
}

public function editKategori($id)
{
    $kategori = Kategori::findOrFail($id);

    return view('admin.kategori.edit', compact('kategori'));
}

public function updateKategori(Request $request, $id)
{
    $kategori = Kategori::findOrFail($id);

    $request->validate([
        'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori,' . $id,
    ]);

    $kategori->update([
        'nama_kategori' => $request->nama_kategori,
    ]);

    return redirect()
        ->route('admin.kategori.index')
        ->with('success', 'Kategori berhasil diperbarui.');
}

public function destroyKategori($id)
{
    $kategori = Kategori::findOrFail($id);

    $kategori->delete();

    return redirect()
        ->route('admin.kategori.index')
        ->with('success', 'Kategori berhasil dihapus.');
}

// 1. Menampilkan daftar peminjaman
public function indexPeminjaman(Request $request)
{
    $search = $request->input('search');

    $peminjamans = Peminjaman::with(['user', 'detailPinjams.alat'])
        ->when($search, function ($query, $search) {
            return $query->where('status', 'like', "%{$search}%")
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view('admin.peminjaman.index', compact('peminjamans', 'search'));
}

// 2. Menampilkan form tambah peminjaman
public function createPeminjaman()
{
    $users = User::where('role', 'peminjam')->get(); // Atau ambil semua user jika bebas
    $alats = Alat::where('stok', '>', 0)->get();

    return view('admin.peminjaman.create', compact('users', 'alats'));
}

// 3. Menyimpan data peminjaman baru
public function storePeminjaman(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'tgl_pinjam' => 'required|date',
        'tgl_kembali_plan' => 'required|date|after_or_equal:tgl_pinjam',
        'alat_id' => 'required|array',
        'alat_id.*' => 'exists:alat,id',
        'jumlah' => 'required|array',
        'jumlah.*' => 'integer|min:1',
    ]);

    DB::beginTransaction();

    try {
        // Buat transaksi utama peminjaman
        $peminjaman = Peminjaman::create([
            'user_id' => $request->user_id,
            'tgl_pinjam' => $request->tgl_pinjam,
            'tgl_kembali_plan' => $request->tgl_kembali_plan,
            'status' => 'diajukan', // Status awal
        ]);

        // Simpan detail alat yang dipinjam
        foreach ($request->alat_id as $index => $alatId) {
            $jumlahPinjam = $request->jumlah[$index];

            $alat = Alat::findOrFail($alatId);

            // Validasi stok
            if ($alat->stok < $jumlahPinjam) {
                throw new \Exception("Stok alat '{$alat->nama_alat}' tidak mencukupi.");
            }

            DetailPinjam::create([
                'peminjaman_id' => $peminjaman->id,
                'alat_id' => $alatId,
                'jumlah' => $jumlahPinjam,
            ]);
        }

        // Kurangi stok alat jika status langsung disetujui/dipinjam
        // (Opsional, atau dikurangi saat status berubah jadi 'dipinjam')

        DB::commit();

        return redirect()
            ->route('admin.peminjaman.index')
            ->with('success', 'Data peminjaman berhasil diajukan.');

    } catch (\Exception $e) {
        DB::rollBack();

        return back()
            ->withInput()
            ->with('error', $e->getMessage());
    }
}

public function updateStatusPeminjaman(Request $request, $id)
{
    $peminjaman = Peminjaman::with('detailPinjams.alat')
        ->findOrFail($id);

    $request->validate([
        'status' => 'required|in:diajukan,dipinjam,telat,dikembalikan',
    ]);

    DB::beginTransaction();

    try {

        $statusLama = $peminjaman->status;
        $statusBaru = $request->status;

        /*
        |--------------------------------------------------------------------------
        | Diajukan → Dipinjam
        |--------------------------------------------------------------------------
        */

        if (
            $statusLama !== 'dipinjam' &&
            $statusBaru === 'dipinjam'
        ) {

            foreach ($peminjaman->detailPinjams as $detail) {

                $alat = $detail->alat;

                if ($alat->stok < $detail->jumlah) {
                    throw new \Exception(
                        "Stok alat '{$alat->nama_alat}' tidak mencukupi untuk dipinjam."
                    );
                }

                $alat->decrement('stok', $detail->jumlah);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Dipinjam / Telat → Dikembalikan
        |--------------------------------------------------------------------------
        */

        if (
            in_array($statusLama, ['dipinjam', 'telat']) &&
            $statusBaru === 'dikembalikan'
        ) {

            // Kembalikan stok
            foreach ($peminjaman->detailPinjams as $detail) {
                $detail->alat->increment('stok', $detail->jumlah);
            }

            /*
            |--------------------------------------------------------------
            | Buat data pengembalian otomatis
            |--------------------------------------------------------------
            */

            if (!$peminjaman->pengembalian()->exists()) {

                $tglKembali = now()->toDateString();

                $tglRencana = \Carbon\Carbon::parse(
                    $peminjaman->tgl_kembali_plan
                );

                $tanggalKembali = \Carbon\Carbon::parse(
                    $tglKembali
                );

                $hariTerlambat = 0;

                if ($tanggalKembali->greaterThan($tglRencana)) {
                    $hariTerlambat = $tglRencana->diffInDays(
                        $tanggalKembali
                    );
                }

                $dendaKeterlambatan = $hariTerlambat * 1000;

                \App\Models\Pengembalian::create([
                    'peminjaman_id' => $peminjaman->id,
                    'tgl_kembali' => $tglKembali,
                    'kondisi_kembali' => 'Baik',
                    'denda' => $dendaKeterlambatan,
                    'petugas_id' => auth()->id(),
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Update status
        |--------------------------------------------------------------------------
        */

        $peminjaman->update([
            'status' => $statusBaru
        ]);

        DB::commit();

        return redirect()
            ->route('admin.peminjaman.index')
            ->with(
                'success',
                'Status peminjaman berhasil diperbarui.'
            );

    } catch (\Exception $e) {

        DB::rollBack();

        return back()->with(
            'error',
            $e->getMessage()
        );
    }
}

// 5. Menghapus data peminjaman
public function destroyPeminjaman($id)
{
    $peminjaman = Peminjaman::with('detailPinjams')->findOrFail($id);

    // Jika statusnya sedang dipinjam, kembalikan stok terlebih dahulu sebelum dihapus
    if ($peminjaman->status == 'dipinjam') {
        foreach ($peminjaman->detailPinjams as $detail) {
            $detail->alat->increment('stok', $detail->jumlah);
        }
    }

    $peminjaman->delete();

    return redirect()
        ->route('admin.peminjaman.index')
        ->with('success', 'Data peminjaman berhasil dihapus.');
}

public function searchUser(Request $request)
{
    $keyword = $request->input('search');

    if (strlen($keyword) < 3) {
        return response()->json([]);
    }

    $users = User::where('role', 'peminjam')
        ->where(function ($query) use ($keyword) {
            $query->where('name', 'like', "%{$keyword}%")
                ->orWhere('email', 'like', "%{$keyword}%");
        })
        ->limit(10)
        ->get(['id', 'name', 'email']);

    return response()->json($users);
}

public function searchAlat(Request $request)
{
    $keyword = $request->input('search');

    if (strlen($keyword) < 3) {
        return response()->json([]);
    }

    $alats = Alat::where('stok', '>', 0)
        ->where('nama_alat', 'like', "%{$keyword}%")
        ->limit(10)
        ->get(['id', 'nama_alat', 'stok']);

    return response()->json($alats);
}

public function logAktivitas() {
    $logs = LogAktivitas::with('user')
        ->latest()
        ->paginate(15);

    return view('admin.log.index', compact('logs'));
}

}