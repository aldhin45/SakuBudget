@extends('layouts.app')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Kategori Pengeluaran</h1>
    <p class="text-sm text-gray-500">Ringkasan pengeluaran berdasarkan kategori</p>
</div>

{{-- ================== GRAFIK ================== --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

    {{-- PIE / DONUT CHART --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm">
        <h3 class="font-bold text-gray-800 mb-4">Distribusi Pengeluaran</h3>

        <div class="h-64 flex items-center justify-center">
            <canvas id="categoryChart" class="max-w-xs"></canvas>
        </div>
    </div>

    {{-- BAR CHART --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm">
        <h3 class="font-bold text-gray-800 mb-4">Pengeluaran Bulanan</h3>

        <div class="h-52">
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>

</div>

{{-- ================== CARD KATEGORI ================== --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

@foreach($categories as $categoryName => $items)

    @php
        $totalCat = $items->sum(function ($t) {
            return $t->amount * ($t->quantity ?? 1);
        });

        $first = $items->first();
        $limit = $first->category->budget_limit ?? 0;

        $percent = $limit > 0 
            ? ($totalCat / $limit) * 100 
            : 0;
    @endphp

    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        
        {{-- Nama kategori --}}
        <h3 class="font-bold text-gray-800 text-lg mb-2">
            {{ $categoryName }}
        </h3>

        {{-- Total --}}
        <p class="text-xl font-bold text-gray-800">
            Rp {{ number_format($totalCat, 0, ',', '.') }}
        </p>

        {{-- Budget --}}
        <p class="text-xs text-gray-400 mb-3">
            Batas: Rp {{ number_format($limit, 0, ',', '.') }}
        </p>

        {{-- Progress --}}
        <div class="w-full bg-gray-100 rounded-full h-2">
            <div class="bg-blue-400 h-2 rounded-full"
                style="width: {{ min($percent, 100) }}%">
            </div>
        </div>

        {{-- Persentase --}}
        <p class="text-xs mt-2 text-gray-500">
            {{ round($percent) }}% digunakan
        </p>

        {{-- Status --}}
        @if($percent >= 100)
            <p class="text-xs text-red-500 font-semibold mt-1">
                Melebihi batas
            </p>
        @elseif($percent >= 80)
            <p class="text-xs text-orange-500 font-semibold mt-1">
                Hampir habis
            </p>
        @else
            <p class="text-xs text-green-500 font-semibold mt-1">
                Aman
            </p>
        @endif

    </div>

@endforeach

</div>

{{-- ================== CHART SCRIPT ================== --}}
<script>

    // DONUT CHART (Kategori)
    new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: {
            labels: @json($chartLabels ?? []),
            datasets: [{
                data: @json($chartData ?? []),
                backgroundColor: [
                    '#2b95b1',
                    '#ff9f43',
                    '#10b981',
                    '#ef4444',
                    '#6366f1',
                    '#f59e0b'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // BAR CHART (Bulanan)
    new Chart(document.getElementById('monthlyChart'), {
        type: 'bar',
        data: {
            labels: @json($monthLabels ?? []),
            datasets: [{
                data: @json($monthData ?? []),
                backgroundColor: '#2b95b1'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

</script>

@endsection