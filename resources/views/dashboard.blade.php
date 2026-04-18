@extends('layouts.app')

@section('content')

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">
        Halo, {{ Auth::user()->name ?? 'User' }}
    </h1>
    <p class="text-sm text-gray-500 mt-1">
        Ringkasan keuangan Anda hari ini
    </p>
</div>


{{-- ALERT --}}
@if($status == "BAHAYA")
    <div class="bg-red-500 text-white p-4 rounded-xl mb-6 shadow-sm">
        Status BAHAYA! Pengeluaran terlalu tinggi!
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

    {{-- SALDO --}}
    <div class="col-span-2 bg-[#2b95b1] rounded-2xl p-8 text-white shadow-md">
        <p class="text-sm text-white/80 mb-2">Saldo Saat Ini</p>

        <h2 class="text-4xl font-bold mb-4">
            Rp {{ number_format($saldoSekarang, 0, ',', '.') }}
        </h2>

        <p class="text-sm text-white/80">
            Total Pengeluaran: Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
        </p>
    </div>

    {{-- STATUS --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm flex flex-col items-center justify-center text-center">

        <p class="text-sm text-gray-500 mb-4">Status Keuangan</p>

        <div class="relative w-32 h-32 mb-4">
            <svg class="w-full h-full transform -rotate-90">
                <circle cx="50%" cy="50%" r="45"
                    stroke="#e5e7eb"
                    stroke-width="10"
                    fill="none"/>
                
                <circle cx="50%" cy="50%" r="45"
                    stroke="{{ $color }}"
                    stroke-width="10"
                    fill="none"
                    stroke-dasharray="282.6"
                    stroke-dashoffset="{{ 282.6 - (282.6 * $percentage / 100) }}"
                    stroke-linecap="round"/>
            </svg>

            <div class="absolute inset-0 flex flex-col items-center justify-center">
                <span class="text-2xl font-bold text-gray-800">
                    {{ $percentage }}%
                </span>
                <span class="text-xs font-bold" style="color: {{ $color }}">
                    {{ $status }}
                </span>
            </div>
        </div>

        <p class="text-xs text-gray-400">
            Berdasarkan sisa saldo Anda
        </p>
    </div>

</div>

{{-- PENGELUARAN TERBESAR --}}
@if($maxTransaction)
<div class="bg-white rounded-2xl p-6 shadow-sm mb-6">
    <p class="text-sm text-gray-500">Pengeluaran Terbesar</p>

    <h2 class="text-2xl font-bold text-red-500">
        Rp {{ number_format($maxTransaction->amount * $maxTransaction->quantity, 0, ',', '.') }}
    </h2>

    <p class="text-sm text-gray-500">
        {{ $maxTransaction->category->name }}
    </p>
</div>
@endif

{{-- TRANSAKSI TERBARU --}}
<div class="bg-white rounded-2xl p-6 shadow-sm mb-6">
    
    <div class="flex justify-between mb-4">
        <h3 class="font-bold text-gray-800">Transaksi Terbaru</h3>
        <a href="{{ route('transactions.index') }}" class="text-[#2b95b1] text-sm">
            Lihat Semua
        </a>
    </div>

    @forelse($latestTransactions as $t)
        <div class="flex justify-between border-b py-3">
            <div>
                <p class="font-medium">
                    {{ $t->note ?? $t->category->name }}
                </p>

                <p class="text-xs text-gray-400">
                    {{ $t->date->format('d M Y') }}
                </p>
            </div>

            <p class="font-bold text-red-500">
                - Rp {{ number_format($t->amount * $t->quantity, 0, ',', '.') }}
            </p>
        </div>
    @empty
        <p class="text-gray-400">Belum ada transaksi</p>
    @endforelse

</div>

@endsection