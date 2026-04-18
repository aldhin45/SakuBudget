<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SakuBudget - Register</title>

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
                <i class="fas fa-sign-out-alt text-9xl text-white opacity-80 stroke-white transform scale-x-[-1]"></i>
            </div>
        </div>

        <div class="w-1/2 rounded-3xl bg-sakubudget-form-bg p-12">
            <div class="flex flex-col items-center justify-center h-full text-white">
                <div class="w-full max-w-md">
                    <h2 class="mb-2 text-4xl font-bold text-center">Register</h2>
                    <p class="mb-10 text-lg font-medium text-center text-gray-200">Lengkapi data untuk membuat akun baru</p>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-6">
                            <x-input-label for="name" class="text-white" :value="__('Nama Lengkap')" />
                            <x-text-input id="name" class="block mt-1 w-full bg-white border-white rounded-full py-3 px-6 text-gray-800 focus:border-sakubudget-oranye focus:ring-sakubudget-oranye" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-200" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="email" class="text-white" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full bg-white border-white rounded-full py-3 px-6 text-gray-800 focus:border-sakubudget-oranye focus:ring-sakubudget-oranye" type="email" name="email" :value="old('email')" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-200" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="password" class="text-white" :value="__('Password')" />
                            <x-text-input id="password" class="block mt-1 w-full bg-white border-white rounded-full py-3 px-6 text-gray-800 focus:border-sakubudget-oranye focus:ring-sakubudget-oranye" type="password" name="password" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-200" />
                        </div>

                        <div class="mb-8">
                            <x-input-label for="password_confirmation" class="text-white" :value="__('Konfirmasi Password')" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full bg-white border-white rounded-full py-3 px-6 text-gray-800 focus:border-sakubudget-oranye focus:ring-sakubudget-oranye" type="password" name="password_confirmation" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-200" />
                        </div>

                        <div class="flex items-center justify-center">
                            <button class="w-full bg-sakubudget-oranye text-white font-bold py-4 px-6 rounded-full hover:bg-orange-600 transition duration-300">
                                {{ __('Daftar sekarang') }}
                            </button>
                        </div>
                        
                        <div class="flex items-center justify-center mt-8 gap-1">
                            <span class="text-white text-sm">atau</span>
                            <a href="{{ route('login') }}" class="text-white text-sm font-bold underline hover:text-gray-100">Sudah Punya Akun? Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>