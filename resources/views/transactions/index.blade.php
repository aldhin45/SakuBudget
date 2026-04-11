@extends('layouts.app')

@section('content')

<h1>Riwayat Transaksi</h1>

<a href="{{ route('transactions.create') }}">+ Tambah</a>

<br><br>

<a href="{{ route('transactions.export') }}">
    <button>Export CSV</button>
</a>

<a href="{{ route('transactions.pdf') }}">
    <button>Export PDF</button>
</a>

<br><br>

@if(session('success'))
    <p style="color:green;">{{ session('success') }}</p>
@endif

<h3>Filter Transaksi</h3>

<form method="GET" action="{{ route('transactions.index') }}">

    <input type="text" name="search" placeholder="Cari..." value="{{ request('search') }}">

    <select name="category_id">
        <option value="">Semua Kategori</option>
        @foreach($categories as $c)
            <option value="{{ $c->id }}" 
                {{ request('category_id') == $c->id ? 'selected' : '' }}>
                {{ $c->name }}
            </option>
        @endforeach
    </select>

    <input type="date" name="date" value="{{ request('date') }}">

    <button type="submit">Filter</button>
</form>

<br>

<table border="1" cellpadding="10" width="100%">
    <tr>
        <th>Harga (Rp)</th>
        <th>Jumlah</th>
        <th>Total</th>
        <th>Kategori</th>
        <th>Tanggal</th>
        <th>Aksi</th>
    </tr>

    @forelse($transactions as $t)
    <tr>
        <td>Rp {{ number_format($t->amount, 0, ',', '.') }}</td>

        <td>{{ $t->quantity }}</td>

        <td>
            Rp {{ number_format($t->amount * $t->quantity, 0, ',', '.') }}
        </td>

        <td>{{ $t->category->name ?? '-' }}</td>

        <td>
            {{ $t->date ? $t->date->format('d-m-Y H:i') : '-' }}
        </td>

        <td>
            <a href="{{ route('transactions.edit', $t->id) }}">Edit</a>

            <form action="{{ route('transactions.destroy', $t->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('Yakin hapus?')">Hapus</button>
            </form>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="6" style="text-align:center;">
            Belum ada transaksi
        </td>
    </tr>
    @endforelse

</table>
@endsection