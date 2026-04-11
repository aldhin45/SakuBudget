@extends('layouts.app')

@section('content')
<h1>Edit Transaksi</h1>

<form method="POST" action="{{ route('transactions.update', $transaction->id) }}">
    @csrf
    @method('PUT')

    <input type="number" name="amount" value="{{ $transaction->amount }}"><br><br>
    <input type="number" name="quantity" value="{{ $transaction->quantity }}"><br><br>

    <select name="category_id">
        @foreach($categories as $c)
            <option value="{{ $c->id }}" 
                {{ $transaction->category_id == $c->id ? 'selected' : '' }}>
                {{ $c->name }}
            </option>
        @endforeach
    </select><br><br>

    <input type="datetime-local" name="date" value="{{ \Carbon\Carbon::parse($transaction->date)->format('Y-m-d\TH:i') }}"><br><br>
    <textarea name="note">{{ $transaction->note }}</textarea><br><br>

    <button type="submit">Update</button>
</form>
@endsection