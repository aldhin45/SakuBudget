@extends('layouts.app')

@section('content')


{{-- 🔔 NOTIFIKASI POPUP --}}
@if($status == "BAHAYA")
    <script>
        alert("🚨 Keuangan kamu dalam kondisi BAHAYA! Segera kurangi pengeluaran!");
    </script>
@endif

@if(count($warnings) > 0)
    <script>
        alert("⚠️ Ada kategori yang hampir melewati batas anggaran!");
    </script>
@endif

{{-- 🔔 NOTIFIKASI DI HALAMAN --}}
@if($status == "BAHAYA")
    <div style="background:red; color:white; padding:10px; margin-bottom:10px;">
        🚨 Status BAHAYA! Pengeluaran terlalu tinggi!
    </div>
@endif

@if(count($warnings) > 0)
    <div style="background:orange; padding:10px; margin-bottom:10px;">
        ⚠️ Beberapa kategori hampir habis!
    </div>
@endif

{{-- 💰 SALDO USER --}}
<h3>Saldo Saat Ini: Rp {{ number_format(Auth::user()->balance, 0, ',', '.') }}</h3>
<h3>Saldo Awal: Rp {{ number_format(Auth::user()->balance, 0, ',', '.') }}</h3>

{{-- 💸 TOTAL --}}
<h3>Total Pengeluaran: Rp {{ number_format($total, 0, ',', '.') }}</h3>

{{-- 💰 SISA SALDO --}}
<h3>
    Sisa Saldo: 
    Rp {{ number_format(Auth::user()->balance - $total, 0, ',', '.') }}
</h3>

<h3>Hari Ini: Rp {{ number_format($todayTotal, 0, ',', '.') }}</h3>
<h3>Bulan Ini: Rp {{ number_format($monthlyTotal, 0, ',', '.') }}</h3>

{{-- STATUS KEUANGAN --}}
<h2>Status Keuangan:</h2>
<h1 style="color: {{ $color }}">
    {{ $status }}
</h1>

<hr>

{{-- WARNING DETAIL --}}
<h3>Detail Peringatan Budget</h3>

@if(count($warnings) > 0)
    @foreach($warnings as $w)
        <p>
            ⚠️ {{ $w['category'] }} hampir habis 
            (Rp {{ number_format($w['total'], 0, ',', '.') }} 
            / Rp {{ number_format($w['limit'], 0, ',', '.') }})
        </p>
    @endforeach
@else
    <p>Aman semua </p>
@endif

<hr>

{{-- PROGRESS KATEGORI --}}
<h3>Progress Budget per Kategori</h3>

@foreach($categoryProgress as $c)
    <p>
        {{ $c['name'] }}: {{ round($c['percent']) }}%
    </p>
@endforeach

<hr>

<a href="{{ route('transactions.index') }}">Lihat Transaksi</a>
@endsection