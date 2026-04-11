<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
    <style>
        body { 
            font-family: sans-serif; 
            font-size: 14px; 
        }
        h2 {
            text-align: center;
            margin-bottom: 10px;
        }
        .header-info {
            margin-bottom: 20px;
        }
        .header-info p {
            margin: 3px 0;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
        }
        table, th, td { 
            border: 1px solid #000; 
        }
        th, td { 
            padding: 8px 10px; 
            text-align: left; 
        }
        th { 
            background-color: #f2f2f2; 
        }
        .text-right { 
            text-align: right; 
        }
    </style>
</head>
<body>

    <h2>Laporan Riwayat Transaksi</h2>

    {{-- INFORMASI USER & TANGGAL --}}
    <div class="header-info">
        <p><strong>Nama Pengguna:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Catatan</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $index => $t)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $t->date ? \Carbon\Carbon::parse($t->date)->format('d-m-Y H:i') : '-' }}</td>
                <td>{{ $t->category->name ?? '-' }}</td>
                <td>{{ $t->note }}</td>
                <td>{{ $t->quantity }}</td>
                <td class="text-right">Rp {{ number_format($t->amount * $t->quantity, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Belum ada data transaksi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>