@extends('layouts.app')

@section('content')
<h1>Tambah Transaksi</h1>

<form method="POST" action="{{ route('transactions.store') }}">
    @csrf

    <input type="number" name="amount" placeholder="Jumlah"><br><br>
    <input type="number" name="quantity" placeholder="Jumlah Barang" value="1"><br><br>

    <select name="category_id">
        @foreach($categories as $c)
            <option value="{{ $c->id }}">{{ $c->name }}</option>
        @endforeach
    </select><br><br>

    <input type="datetime-local" name="date"><br><br>

    <textarea name="note" placeholder="Catatan"></textarea><br><br>

    <button type="submit">Simpan</button>
</form>
@endsection