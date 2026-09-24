<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Sistem Peminjaman</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #1f2937;
            margin: 25px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #10b981;
            padding-bottom: 12px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
            color: #111827;
        }

        .header p {
            margin: 5px 0 0;
            color: #6b7280;
            font-size: 10px;
        }

        .periode {
            margin-bottom: 15px;
            padding: 8px 10px;
            background: #f3f4f6;
            border-left: 4px solid #10b981;
        }

        .stats {
            width: 100%;
            margin-bottom: 18px;
        }

        .stats td {
            width: 25%;
            padding: 5px;
            vertical-align: top;
        }

        .card {
            border: 1px solid #d1d5db;
            padding: 10px;
            text-align: center;
        }

        .card-title {
            font-size: 9px;
            color: #6b7280;
            margin-bottom: 5px;
        }

        .card-value {
            font-size: 16px;
            font-weight: bold;
            color: #111827;
        }

        .section-title {
            font-size: 13px;
            font-weight: bold;
            margin: 15px 0 8px;
            color: #111827;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
        }

        table.data th {
            background: #10b981;
            color: white;
            padding: 7px 5px;
            border: 1px solid #059669;
            font-size: 9px;
        }

        table.data td {
            padding: 6px 5px;
            border: 1px solid #d1d5db;
            vertical-align: middle;
        }

        table.data tr:nth-child(even) {
            background: #f9fafb;
        }

        .center {
            text-align: center;
        }

        .status {
            font-weight: bold;
            text-transform: capitalize;
        }

        .footer {
            margin-top: 20px;
            padding-top: 8px;
            border-top: 1px solid #d1d5db;
            text-align: right;
            color: #6b7280;
            font-size: 8px;
        }

        .empty {
            text-align: center;
            padding: 20px;
            color: #6b7280;
        }
    </style>
</head>

<body>

    {{-- HEADER --}}
    <div class="header">
        <h1>LAPORAN SISTEM PEMINJAMAN</h1>
        <p>Laporan Data Peminjaman Alat</p>
    </div>

    {{-- PERIODE --}}
    <div class="periode">
        <strong>Periode Laporan:</strong>

        @if ($tanggalMulai || $tanggalAkhir)
            {{ $tanggalMulai ? date('d/m/Y', strtotime($tanggalMulai)) : 'Awal' }}
            -
            {{ $tanggalAkhir ? date('d/m/Y', strtotime($tanggalAkhir)) : 'Sekarang' }}
        @else
            Semua Data
        @endif
    </div>

    {{-- STATISTIK --}}
    <table class="stats">
        <tr>
            <td>
                <div class="card">
                    <div class="card-title">TOTAL PEMINJAMAN</div>
                    <div class="card-value">
                        {{ $totalPeminjaman }}
                    </div>
                </div>
            </td>

            <td>
                <div class="card">
                    <div class="card-title">SEDANG DIPINJAM</div>
                    <div class="card-value">
                        {{ $totalDipinjam }}
                    </div>
                </div>
            </td>

            <td>
                <div class="card">
                    <div class="card-title">SELESAI</div>
                    <div class="card-value">
                        {{ $totalSelesai }}
                    </div>
                </div>
            </td>

            <td>
                <div class="card">
                    <div class="card-title">TOTAL DENDA</div>
                    <div class="card-value">
                        Rp {{ number_format($totalDenda, 0, ',', '.') }}
                    </div>
                </div>
            </td>
        </tr>
    </table>

    {{-- DATA PEMINJAMAN --}}
    <div class="section-title">
        Data Peminjaman
    </div>

    <table class="data">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="18%">Peminjam</th>
                <th width="22%">Alat</th>
                <th width="15%">Tanggal Dibuat</th>
                <th width="15%">Status</th>
                <th width="25%">Detail</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($peminjaman as $index => $item)

                <tr>
                    <td class="center">
                        {{ $index + 1 }}
                    </td>

                    <td>
                        <strong>
                            {{ $item->user->name ?? '-' }}
                        </strong>
                        <br>
                        {{ $item->user->email ?? '-' }}
                    </td>

                    <td>
                        @forelse ($item->detailPinjam ?? [] as $detail)
                            {{ $detail->alat->nama_alat ?? '-' }}

                            @if (!$loop->last)
                                <br>
                            @endif
                        @empty
                            -
                        @endforelse
                    </td>

                    <td class="center">
                        {{ $item->created_at
                            ? $item->created_at->format('d/m/Y H:i')
                            : '-' }}
                    </td>

                    <td class="center status">
                        {{ $item->status ?? '-' }}
                    </td>

                    <td>
                        @forelse ($item->detailPinjam ?? [] as $detail)
                            Jumlah:
                            {{ $detail->jumlah ?? 0 }}

                            @if (!$loop->last)
                                <br>
                            @endif
                        @empty
                            Tidak ada detail
                        @endforelse
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="6" class="empty">
                        Tidak ada data peminjaman.
                    </td>
                </tr>

            @endforelse
        </tbody>
    </table>

    {{-- FOOTER --}}
    <div class="footer">
        Dicetak pada:
        {{ now()->format('d/m/Y H:i') }}
    </div>

</body>

</html>