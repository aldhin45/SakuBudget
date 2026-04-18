@extends('layouts.app')

@section('content')

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Top Up Saldo</h1>
        <p class="text-sm text-gray-500 mt-1">Tambahkan dana ke dompet SakuBudget Anda dengan aman dan cepat.</p>
    </div>
    
    <a href="{{ route('dashboard') }}" class="bg-white border border-gray-300 text-gray-700 px-5 py-2.5 rounded-xl hover:bg-gray-50 font-medium transition flex items-center gap-2 shadow-sm">
        <i class="fa-solid fa-arrow-left text-sm"></i> Kembali
    </a>
</div>

@if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-xl shadow-sm flex items-center gap-3">
        <i class="fa-solid fa-circle-check text-xl"></i>
        <p class="font-medium">{{ session('success') }}</p>
    </div>
@endif

@if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-xl shadow-sm">
        {{ session('error') }}
    </div>
@endif

<div class="grid grid-cols-1 xl:grid-cols-3 gap-8 mb-10">
    
    {{-- FORM --}}
    <div class="xl:col-span-2 bg-white rounded-2xl p-8 shadow-sm">
        
        <form action="{{ route('topup.store') }}" method="POST">
            @csrf
            
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <div class="w-8 h-8 bg-[#e6f4f8] text-[#2b95b1] rounded-full flex items-center justify-center text-sm">1</div>
                Pilih Nominal Top Up
            </h3>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6 pl-10">
                @foreach([50000,100000,250000,500000,1000000] as $nominal)
                <label class="cursor-pointer relative">
                    <input type="radio" name="amount" value="{{ $nominal }}" class="peer sr-only">
                    <div class="w-full bg-white border-2 border-gray-200 rounded-xl p-4 text-center hover:bg-gray-50 transition peer-checked:border-[#2b95b1] peer-checked:bg-[#e6f4f8] peer-checked:text-[#1c667a]">
                        <p class="font-bold text-lg">Rp {{ number_format($nominal,0,',','.') }}</p>
                    </div>
                </label>
                @endforeach
            </div>

            <div class="pl-10 mb-10">
                <label class="block text-sm font-bold text-gray-700 mb-2">Atau masukkan nominal khusus</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                        <span class="text-gray-500 font-bold">Rp</span>
                    </div>
                    <input type="number" name="custom_amount" placeholder="Minimal 10.000" 
                        class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl py-3 pl-12 pr-4 focus:ring-2 focus:ring-[#2b95b1] focus:border-[#2b95b1] transition">
                </div>
            </div>

            <hr class="border-gray-100 mb-8">

            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <div class="w-8 h-8 bg-[#e6f4f8] text-[#2b95b1] rounded-full flex items-center justify-center text-sm">2</div>
                Metode Pembayaran
            </h3>

            <div class="pl-10 space-y-4 mb-10">
                <label class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200 cursor-pointer hover:bg-gray-100 transition group relative">
                    <input type="radio" name="payment_method" value="bank_transfer" class="peer sr-only" checked>
                    <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-[#2b95b1] pointer-events-none transition"></div>
                    
                    <div class="flex items-center gap-4 relative z-10">
                        <div class="w-12 h-12 bg-white shadow-sm border border-gray-100 rounded-lg flex items-center justify-center text-blue-600 text-xl">
                            <i class="fa-solid fa-building-columns"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800">Transfer Bank</p>
                            <p class="text-xs text-gray-500">BCA, BNI, Mandiri, BRI</p>
                        </div>
                    </div>
                </label>

                <label class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200 cursor-pointer hover:bg-gray-100 transition group relative">
                    <input type="radio" name="payment_method" value="qris" class="peer sr-only">
                    <div class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-[#2b95b1] pointer-events-none transition"></div>
                    
                    <div class="flex items-center gap-4 relative z-10">
                        <div class="w-12 h-12 bg-white shadow-sm border border-gray-100 rounded-lg flex items-center justify-center text-pink-600 text-2xl">
                            <i class="fa-solid fa-qrcode"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800">QRIS</p>
                            <p class="text-xs text-gray-500">Gopay, OVO, Dana, ShopeePay</p>
                        </div>
                    </div>
                </label>
            </div>

            <div class="pl-10">
                <button type="submit" class="w-full bg-[#2b95b1] text-white px-6 py-4 rounded-xl hover:bg-[#237a91] font-bold text-lg shadow-sm transition flex items-center justify-center gap-2">
                    Lanjutkan Pembayaran
                </button>
            </div>

        </form>
    </div>

    {{-- SIDE --}}
    <div class="flex flex-col gap-6">
        
        <div class="bg-[#2b95b1] rounded-2xl p-7 text-white shadow-md">
            <p class="text-xs">Saldo Saat Ini</p>
            <h3 class="text-3xl font-bold">
                Rp {{ number_format(Auth::user()->balance, 0, ',', '.') }}
            </h3>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border">
            <h3 class="font-bold mb-4 text-sm">Informasi</h3>
            <ul class="text-sm text-gray-600 space-y-2">
                <li>Minimal Top Up Rp 10.000</li>
                <li>Proses instan</li>
                <li>Aman digunakan</li>
            </ul>
        </div>

    </div>
</div>

{{-- SCRIPT BIAR INTERAKTIF --}}
<script>
    const custom = document.querySelector('input[name="custom_amount"]');
    const radios = document.querySelectorAll('input[name="amount"]');

    custom.addEventListener('input', () => {
        radios.forEach(r => r.checked = false);
    });
</script>

@endsection