<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SakuBudget - Login</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased h-full">
    <div class="flex flex-row h-full min-h-screen p-6 bg-sakubudget-gradient">
        <div class="flex flex-col items-center justify-center w-1/2 p-10 text-white">
            <div class="flex items-center gap-2 mb-10 text-3xl font-bold">
                <i class="fas fa-globe"></i>
                <span>SakuBudget</span>
            </div>
            
            <h1 class="mb-5 text-5xl font-extrabold text-center">Selamat Datang Kembali!</h1>
            
            <p class="mb-10 text-xl font-medium text-center">Masuk untuk melanjutkan kelola keuanganmu.</p>
            
            <div class="flex items-center justify-center mt-auto">
                <i class="fas fa-wallet text-9xl text-white opacity-80 stroke-white"></i>
            </div>
        </div>

        <div class="w-1/2 rounded-3xl bg-sakubudget-form-bg p-12">
            <div class="flex flex-col items-center justify-center h-full text-white">
                <div class="w-full max-w-md">
                    <h2 class="mb-2 text-4xl font-bold text-center">Login</h2>
                    <p class="mb-10 text-lg font-medium text-center text-gray-200">Masukan email dan password kamu</p>

                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-6">
                            <x-input-label for="email" class="text-white" :value="__('Email')" />
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="block mt-1 w-full bg-white border-transparent rounded-full py-3 px-6 text-gray-800 focus:border-sakubudget-oranye focus:ring focus:ring-sakubudget-oranye focus:ring-opacity-50" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-200" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="password" class="text-white" :value="__('Password')" />
                            <input id="password" type="password" name="password" required autocomplete="current-password" class="block mt-1 w-full bg-white border-transparent rounded-full py-3 px-6 text-gray-800 focus:border-sakubudget-oranye focus:ring focus:ring-sakubudget-oranye focus:ring-opacity-50" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-200" />
                        </div>

                        <div class="flex items-center justify-between mb-8">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-sakubudget-oranye shadow-sm focus:ring-sakubudget-oranye" name="remember">
                                <span class="ms-2 text-sm text-white">{{ __('Ingat saya') }}</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="underline text-sm text-white hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sakubudget-oranye" href="{{ route('password.request') }}">
                                    {{ __('Lupa password?') }}
                                </a>
                            @endif
                        </div>

                        <div class="flex items-center justify-center">
                            <button class="w-full bg-sakubudget-oranye text-white font-bold py-4 px-6 rounded-full hover:bg-orange-600 transition duration-300">
                                {{ __('Masuk') }}
                            </button>
                        </div>
                        
                        <div class="flex items-center justify-center mt-8 gap-1">
                            <span class="text-white text-sm">atau</span>
                            <a href="{{ route('register') }}" class="text-white text-sm font-bold underline hover:text-gray-100">Daftar Akun Baru</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>