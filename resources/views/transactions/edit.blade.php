@extends('layouts.app')

@section('content')

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Edit Transaksi</h1>
            <p class="text-sm text-gray-500 mt-1">Perbarui data transaksi yang sudah dicatat sebelumnya.</p>
        </div>
        
        <a href="{{ route('transactions.index') }}" class="bg-white border border-gray-300 text-gray-700 px-5 py-2.5 rounded-xl hover:bg-gray-50 font-medium transition flex items-center gap-2 shadow-sm">
            <i class="fa-solid fa-arrow-left text-sm"></i> Batal
        </a>
    </div>

    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 max-w-4xl relative overflow-hidden">
        
        <div class="absolute top-0 right-0 bg-orange-100 text-orange-600 px-4 py-1.5 rounded-bl-xl font-bold text-xs">
            <i class="fa-solid fa-pen-to-square mr-1"></i> Mode Edit
        </div>

        <form method="POST" action="{{ route('transactions.update', $transaction->id) }}" class="space-y-6 mt-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="amount" class="block text-sm font-bold text-gray-700 mb-2">Nominal Harga (Rp)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <span class="text-gray-500 font-bold">Rp</span>
                        </div>
                        <input type="number" id="amount" name="amount" value="{{ old('amount', $transaction->amount) }}" required
                            class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl py-3 pl-12 pr-4 focus:ring-2 focus:ring-[#2b95b1] focus:border-transparent transition">
                    </div>
                </div>

                <div>
                    <label for="quantity" class="block text-sm font-bold text-gray-700 mb-2">Jumlah Barang</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-400">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>
                        <input type="number" id="quantity" name="quantity" value="{{ old('quantity', $transaction->quantity) }}" min="1" required
                            class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl py-3 pl-11 pr-4 focus:ring-2 focus:ring-[#2b95b1] focus:border-transparent transition">
                    </div>
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-bold text-gray-700 mb-2">Kategori</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-400">
                            <i class="fa-solid fa-tag"></i>
                        </div>
                        <select id="category_id" name="category_id" required
                            class="w-full bg-gray-50 border border-gray-200 text-gray-700 rounded-xl py-3 pl-11 pr-4 focus:ring-2 focus:ring-[#2b95b1] focus:border-transparent transition cursor-pointer appearance-none">
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}" {{ $transaction->category_id == $c->id ? 'selected' : '' }}>
                                    {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="date" class="block text-sm font-bold text-gray-700 mb-2">Tanggal & Waktu</label>
                    <div class="relative">
                        <input type="datetime-local" id="date" name="date" 
                            value="{{ old('date', \Carbon\Carbon::parse($transaction->date)->format('Y-m-d\TH:i')) }}" required
                            class="w-full bg-gray-50 border border-gray-200 text-gray-700 rounded-xl py-3 px-4 focus:ring-2 focus:ring-[#2b95b1] focus:border-transparent transition cursor-pointer">
                    </div>
                </div>
            </div>

            <div>
                <label for="note" class="block text-sm font-bold text-gray-700 mb-2">Catatan (Opsional)</label>
                <div class="relative">
                    <div class="absolute top-4 left-4 pointer-events-none text-gray-400">
                        <i class="fa-solid fa-pen"></i>
                    </div>
                    <textarea id="note" name="note" rows="3"
                        class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl py-3 pl-11 pr-4 focus:ring-2 focus:ring-[#2b95b1] focus:border-transparent transition resize-none">{{ old('note', $transaction->note) }}</textarea>
                </div>
            </div>

            <div class="flex items-center gap-4 pt-4 mt-6 border-t border-gray-100">
                <button type="submit" class="bg-orange-500 text-white px-8 py-3 rounded-xl hover:bg-orange-600 font-bold shadow-sm transition flex items-center gap-2">
                    <i class="fa-solid fa-check"></i> Update Transaksi
                </button>
            </div>

        </form>
    </div>

@endsection