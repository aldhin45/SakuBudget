<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SakuBudget - Lupa Password</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased h-full">
    <div class="flex flex-row h-full min-h-screen p-6 bg-sakubudget-gradient relative">
        
        <a href="{{ route('login') }}" class="absolute top-10 left-10 text-white text-2xl hover:text-gray-200 transition">
            <i class="fa-solid fa-angle-left text-3xl font-light"></i>
        </a>

        <div class="flex flex-col justify-center w-1/2 p-16 pt-24 text-white">
            <div class="flex items-center gap-2 mb-16 text-4xl font-bold">
                <i class="fas fa-globe"></i>
                <i class="fa-solid fa-wallet" style="margin-left: -12px;"></i>
                <span>SakuBudget</span>
            </div>
            
            <h1 class="mb-6 text-4xl font-bold">Lupa Password?</h1>
            
            <p class="mb-10 text-lg font-medium w-4/5 leading-relaxed">
                Masukkan email kamu dan kami akan mengirimkan link reset password
            </p>
            
            <div class="flex items-center justify-center mt-10">
                <i class="fas fa-lock text-[12rem] text-white opacity-80 stroke-white"></i>
            </div>
        </div>

        <div class="w-1/2 rounded-3xl bg-sakubudget-form-bg p-12">
            <div class="flex flex-col items-start justify-center h-full text-white px-8">
                <div class="w-full max-w-md">
                    <h2 class="mb-3 text-4xl font-bold italic">Reset Password</h2>
                    <p class="mb-10 text-lg font-medium text-gray-100">Masukan email yang terdaftar</p>

                    <x-auth-session-status class="mb-4 text-white font-bold bg-green-500/50 p-3 rounded-lg" :status="session('status')" />

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-8">
                            <label for="email" class="block mb-2 text-base font-medium text-white">Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-5 pointer-events-none text-gray-800">
                                    <i class="far fa-envelope text-lg"></i>
                                </div>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                                    class="block w-full pl-14 bg-white border-transparent rounded-lg py-4 pr-6 text-gray-800 focus:border-sakubudget-oranye focus:ring focus:ring-sakubudget-oranye focus:ring-opacity-50" 
                                    placeholder="nama@email.com" />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-200" />
                        </div>

                        <div class="mb-8">
                            <button class="w-full bg-sakubudget-oranye text-white font-bold py-4 px-6 rounded-lg hover:bg-orange-600 transition duration-300">
                                {{ __('Kirim Link Reset') }}
                            </button>
                        </div>
                        
                        <div class="bg-white/30 backdrop-blur-sm text-sakubudget-blue-dark rounded-xl p-5 flex items-start gap-4 mb-8">
                            <i class="fa-regular fa-circle-exclamation text-2xl mt-0.5"></i>
                            <p class="text-sm font-medium leading-relaxed">
                                Link reset password akan dikirim ke email kamu dalam beberapa menit
                            </p>
                        </div>

                        <div>
                            <a href="{{ route('login') }}" class="flex items-center gap-2 text-white text-base font-medium hover:text-gray-200 transition">
                                <i class="fa-solid fa-arrow-left-long"></i>
                                Kembali ke Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>