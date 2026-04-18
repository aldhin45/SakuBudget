<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SakuBudget - Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Poppins', sans-serif; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
    </style>
</head>

<body class="bg-[#f4f7f9] text-gray-800 antialiased flex h-screen overflow-hidden">

    <aside class="w-[280px] bg-gradient-to-b from-[#0c4d7c] to-[#a6dcf0] text-white flex flex-col shrink-0">

        <div class="p-8 flex items-center gap-2 text-2xl font-bold">
            <i class="fas fa-globe"></i>
            <i class="fa-solid fa-wallet -ml-2"></i>
            <span>SakuBudget</span>
        </div>

        <nav class="flex-1 px-4 space-y-2">

            <a href="{{ route('dashboard') }}" 
               class="flex items-center gap-4 px-4 py-3 rounded-lg transition-all duration-200
               {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white font-bold shadow-inner' : 'text-white/80 hover:bg-white/5 hover:text-white font-medium' }}">
                <i class="fa-solid fa-border-all w-5"></i> Dasbor
            </a>

            <a href="{{ route('profile.edit') }}" 
               class="flex items-center gap-4 px-4 py-3 rounded-lg transition-all duration-200
               {{ request()->routeIs('profile.*') ? 'bg-white/10 text-white font-bold shadow-inner' : 'text-white/80 hover:bg-white/5 hover:text-white font-medium' }}">
                <i class="fa-solid fa-building-columns w-5"></i> Akun
            </a>

            <a href="{{ route('categories.index') }}" 
               class="flex items-center gap-4 px-4 py-3 rounded-lg transition-all duration-200
               {{ request()->routeIs('categories.*') ? 'bg-white/10 text-white font-bold shadow-inner' : 'text-white/80 hover:bg-white/5 hover:text-white font-medium' }}">
                <i class="fa-solid fa-shapes w-5"></i> Kategori Pengeluaran
            </a>

            <a href="{{ route('transactions.index') }}" 
               class="flex items-center gap-4 px-4 py-3 rounded-lg transition-all duration-200
               {{ request()->routeIs('transactions.*') ? 'bg-white/10 text-white font-bold shadow-inner' : 'text-white/80 hover:bg-white/5 hover:text-white font-medium' }}">
                <i class="fa-solid fa-receipt w-5"></i> Transaksi
            </a>

            <a href="{{ route('topup') }}" 
               class="flex items-center gap-4 px-4 py-3 rounded-lg transition-all duration-200
               {{ request()->routeIs('topup') ? 'bg-white/10 text-white font-bold shadow-inner' : 'text-white/80 hover:bg-white/5 hover:text-white font-medium' }}">
                <i class="fa-solid fa-money-bill-wave w-5"></i> Top Up
            </a>

        </nav>

        <div class="p-6 mt-auto">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gray-800 border-2 border-white overflow-hidden flex items-center justify-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=random" 
                         alt="Profile" class="w-full h-full object-cover">
                </div>
                <div>
                    <p class="text-sm font-semibold">{{ Auth::user()->name ?? 'User' }}</p>
                    <p class="text-xs text-blue-200">Financial Tracker</p>
                </div>
            </div>
        </div>

    </aside>

    <div class="flex-1 flex flex-col h-screen overflow-hidden">

        <header class="h-20 px-8 flex items-center justify-end bg-transparent relative z-50">
            
            @php
                $user = Auth::user();
                $unreadCount = $user ? $user->unreadNotifications->count() : 0;
            @endphp

            <div class="flex items-center text-gray-500">
                <div class="relative">
                    
                    <button id="notificationBtn" class="relative hover:text-[#2b95b1] transition focus:outline-none p-2">
                        <i class="fa-regular fa-bell text-xl"></i>
                        @if($unreadCount > 0)
                            <span class="absolute top-1.5 right-1 flex h-2.5 w-2.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500 border-2 border-[#f4f7f9]"></span>
                            </span>
                        @endif
                    </button>

                    <div id="notificationDropdown" class="hidden absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.15)] border border-gray-100 overflow-hidden transform origin-top-right transition-all">
                        
                        <div class="px-5 py-4 border-b border-gray-100 flex justify-between items-center bg-white">
                            <h3 class="text-sm font-bold text-gray-800">Notifikasi</h3>
                            @if($unreadCount > 0)
                                <span class="text-[10px] font-bold bg-[#e6f4f8] text-[#2b95b1] px-2 py-1 rounded-md">{{ $unreadCount }} Baru</span>
                            @endif
                        </div>

                        <div class="max-h-[350px] overflow-y-auto">
                            
                            @if($unreadCount > 0)
                                @foreach($user->unreadNotifications as $notif)
                                    @php
                                        // Deteksi tipe notifikasi untuk desain dinamis
                                        $type = $notif->data['type'] ?? 'info';
                                        $bgClass = $type == 'warning' ? 'bg-orange-50/30' : ($type == 'success' ? 'bg-green-50/30' : 'bg-blue-50/30');
                                        $iconBg = $type == 'warning' ? 'bg-orange-100 text-orange-500' : ($type == 'success' ? 'bg-green-100 text-green-500' : 'bg-blue-100 text-blue-500');
                                        $icon = $type == 'warning' ? 'fa-triangle-exclamation' : ($type == 'success' ? 'fa-wallet' : 'fa-bell');
                                    @endphp

                                    <form action="{{ route('notifications.read.single', $notif->id) }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="w-full text-left block px-5 py-4 hover:bg-gray-50 transition border-b border-gray-50 {{ $bgClass }}">
                                            <div class="flex items-start gap-3">
                                                <div class="w-8 h-8 rounded-full {{ $iconBg }} flex items-center justify-center shrink-0 mt-0.5">
                                                    <i class="fa-solid {{ $icon }} text-xs"></i>
                                                </div>
                                                <div>
                                                    <p class="text-xs font-bold text-gray-800">{{ $notif->data['title'] ?? 'Pemberitahuan' }}</p>
                                                    <p class="text-[11px] text-gray-500 mt-1 leading-relaxed">{{ $notif->data['message'] ?? '-' }}</p>
                                                    <p class="text-[9px] font-bold text-gray-400 mt-2">{{ $notif->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </button>
                                    </form>
                                @endforeach
                            @else
                                <div class="px-5 py-8 text-center">
                                    <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <i class="fa-regular fa-bell-slash text-gray-400 text-lg"></i>
                                    </div>
                                    <p class="text-xs font-bold text-gray-600">Semua sudah terbaca</p>
                                    <p class="text-[10px] text-gray-400 mt-1">Tidak ada notifikasi baru.</p>
                                </div>
                            @endif

                        </div>
                        
                        @if($unreadCount > 0)
                            <div class="p-3 text-center border-t border-gray-100 bg-gray-50">
                                <form action="{{ route('notifications.read') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="text-[11px] font-bold text-[#2b95b1] hover:text-[#1c667a] transition">Tandai semua dibaca</button>
                                </form>
                            </div>
                        @endif

                    </div>
                </div>
            </div>

        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#f4f7f9] px-8 pb-8 animate-fade-in">
            @yield('content')
        </main>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('notificationBtn');
            const dropdown = document.getElementById('notificationDropdown');

            if (btn && dropdown) {
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    dropdown.classList.toggle('hidden');
                });

                document.addEventListener('click', function (e) {
                    if (!dropdown.contains(e.target) && !btn.contains(e.target)) {
                        dropdown.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>
</html>