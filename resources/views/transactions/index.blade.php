@extends('layouts.app')

@section('content')

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Riwayat Transaksi</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola dan pantau semua aktivitas keuangan Anda</p>
        </div>
        
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('transactions.export') }}" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-xl hover:bg-gray-50 flex items-center gap-2 font-medium shadow-sm transition">
                <i class="fa-solid fa-file-csv text-green-600 text-lg"></i> Export CSV
            </a>
            
            <a href="{{ route('transactions.pdf') }}" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-xl hover:bg-gray-50 flex items-center gap-2 font-medium shadow-sm transition">
                <i class="fa-solid fa-file-pdf text-red-500 text-lg"></i> Export PDF
            </a>
            
            <a href="{{ route('transactions.create') }}" class="bg-[#2b95b1] text-white px-5 py-2 rounded-xl hover:bg-[#237a91] flex items-center gap-2 font-bold shadow-sm shadow-[#2b95b1]/30 transition">
                <i class="fa-solid fa-plus"></i> Tambah Transaksi
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-xl shadow-sm flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-xl"></i>
            <p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
        <h3 class="text-gray-500 font-bold mb-4 text-sm uppercase tracking-wider">Filter Transaksi</h3>
        
        <form method="GET" action="{{ route('transactions.index') }}" class="flex flex-col md:flex-row gap-4 items-end">
            <div class="flex-1 w-full">
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" placeholder="Cari nama transaksi..." value="{{ request('search') }}" 
                        class="w-full bg-gray-50 border-transparent focus:bg-white border-gray-200 rounded-xl py-2.5 pl-11 pr-4 focus:ring-2 focus:ring-[#2b95b1] focus:border-[#2b95b1] transition text-sm">
                </div>
            </div>
            
            <div class="w-full md:w-56">
                <select name="category_id" class="w-full bg-gray-50 border-gray-200 rounded-xl py-2.5 px-4 focus:ring-2 focus:ring-[#2b95b1] focus:border-[#2b95b1] text-sm text-gray-700 cursor-pointer">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ request('category_id') == $c->id ? 'selected' : '' }}>
                            {{ $c->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="w-full md:w-48">
                <input type="date" name="date" value="{{ request('date') }}" 
                    class="w-full bg-gray-50 border-gray-200 rounded-xl py-2.5 px-4 focus:ring-2 focus:ring-[#2b95b1] focus:border-[#2b95b1] text-sm text-gray-700 cursor-pointer">
            </div>
            
            <button type="submit" class="w-full md:w-auto bg-gray-800 text-white px-6 py-2.5 rounded-xl hover:bg-gray-700 transition font-medium text-sm flex justify-center items-center gap-2">
                <i class="fa-solid fa-filter"></i> Terapkan
            </button>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-8">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-xs text-gray-500 uppercase tracking-wider">
                        <th class="py-4 px-6 font-bold">Harga (Rp)</th>
                        <th class="py-4 px-6 font-bold">Jumlah</th>
                        <th class="py-4 px-6 font-bold">Total</th>
                        <th class="py-4 px-6 font-bold">Kategori</th>
                        <th class="py-4 px-6 font-bold">Tanggal</th>
                        <th class="py-4 px-6 font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transactions as $t)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="py-4 px-6 text-gray-800 font-medium">Rp {{ number_format($t->amount, 0, ',', '.') }}</td>
                            
                            <td class="py-4 px-6 text-gray-600">
                                <span class="bg-gray-100 px-2.5 py-1 rounded-md text-xs font-semibold">{{ $t->quantity }}x</span>
                            </td>
                            
                            <td class="py-4 px-6 text-[#2b95b1] font-bold">
                                Rp {{ number_format($t->amount * $t->quantity, 0, ',', '.') }}
                            </td>
                            
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-600 px-3 py-1 rounded-full text-xs font-semibold">
                                    <i class="fa-solid fa-tag text-[10px]"></i> {{ $t->category->name ?? '-' }}
                                </span>
                            </td>
                            
                            <td class="py-4 px-6 text-sm text-gray-500">
                                {{ $t->date ? $t->date->format('d M Y, H:i') : '-' }}
                            </td>
                            
                            <td class="py-4 px-6">
                                <div class="flex justify-center items-center gap-2">
                                    <a href="{{ route('transactions.edit', $t->id) }}" 
                                       class="text-blue-500 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 w-8 h-8 rounded-lg flex items-center justify-center transition" title="Edit">
                                        <i class="fa-solid fa-pen text-sm"></i>
                                    </a>
                                    
                                    <form action="{{ route('transactions.destroy', $t->id) }}" method="POST" class="inline-block m-0 p-0">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')" 
                                                class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 w-8 h-8 rounded-lg flex items-center justify-center transition" title="Hapus">
                                            <i class="fa-solid fa-trash-can text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <i class="fa-solid fa-receipt text-4xl mb-3 opacity-50"></i>
                                    <p class="text-base font-medium text-gray-500">Belum ada transaksi</p>
                                    <p class="text-sm mt-1">Mulai catat pengeluaran Anda dengan klik tombol Tambah Transaksi.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection