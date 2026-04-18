@extends('layouts.app')

@section('content')

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Profil & Akun</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola informasi personal dan keamanan akun Anda.</p>
        </div>
        
        <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Apakah Anda yakin ingin keluar?')">
            @csrf
            <button type="submit" class="bg-red-50 text-red-500 hover:bg-red-100 hover:text-red-600 px-5 py-2.5 rounded-xl font-bold transition flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-10">
        
        <div class="xl:col-span-2 bg-white rounded-2xl p-8 shadow-sm">
            <h3 class="text-lg font-bold text-gray-800 mb-6">Informasi Personal</h3>
            
            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>

            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('patch')

                <div class="flex items-center gap-6 mb-8">
                    <div class="relative shrink-0">
                        <div class="w-24 h-24 rounded-2xl overflow-hidden shadow-sm border border-gray-100 bg-gray-50 flex items-center justify-center">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name ?? 'User') }}&background=2b95b1&color=fff" alt="Profile" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div>
                        <label class="cursor-pointer bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-xl hover:bg-gray-50 font-medium text-sm transition">
                            <i class="fa-solid fa-camera mr-2"></i> Ubah Foto
                            <input type="file" name="photo" class="hidden" accept="image/*">
                        </label>
                        <p class="text-xs text-gray-400 mt-2">Format JPG, PNG, atau GIF maksimal 2MB.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                            class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl py-3 px-4 focus:ring-2 focus:ring-[#2b95b1] focus:border-transparent transition">
                        <x-input-error class="mt-2 text-red-500" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-bold text-gray-700 mb-2">Status / Posisi</label>
                        <input type="text" id="status" name="status" value="{{ old('status', 'Senior Financial Planner') }}" 
                            class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl py-3 px-4 focus:ring-2 focus:ring-[#2b95b1] focus:border-transparent transition">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Alamat Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                            class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl py-3 px-4 focus:ring-2 focus:ring-[#2b95b1] focus:border-transparent transition">
                        <x-input-error class="mt-2 text-red-500" :messages="$errors->get('email')" />
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">Nomor Telepon</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', '+62 812 3456 7890') }}" 
                            class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl py-3 px-4 focus:ring-2 focus:ring-[#2b95b1] focus:border-transparent transition">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="location" class="block text-sm font-bold text-gray-700 mb-2">Lokasi / Domisili</label>
                        <input type="text" id="location" name="location" value="{{ old('location', 'Jakarta Selatan, Indonesia') }}" 
                            class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl py-3 px-4 focus:ring-2 focus:ring-[#2b95b1] focus:border-transparent transition">
                    </div>
                </div>

                <div class="flex items-center gap-4 mt-6 pt-4 border-t border-gray-100">
                    <button type="submit" class="bg-[#2b95b1] text-white px-6 py-2.5 rounded-xl hover:bg-[#237a91] font-bold shadow-sm transition">
                        Simpan Profil
                    </button>
                    @if (session('status') === 'profile-updated')
                        <p class="text-sm text-green-600 font-bold"><i class="fa-solid fa-check mr-1"></i> Tersimpan</p>
                    @endif
                </div>
            </form>
        </div>

        <div class="flex flex-col gap-6">
            
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <h3 class="text-lg font-bold text-gray-800 mb-6">Keamanan Akun</h3>
                
                <div class="flex items-center justify-between bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-[#e6f4f8] text-[#2b95b1] rounded-full flex items-center justify-center text-sm shrink-0">
                            <i class="fa-solid fa-mobile-screen-button"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-800">Two-Factor Auth (2FA)</p>
                            <p class="text-[10px] text-gray-400">Amankan login dengan kode</p>
                        </div>
                    </div>
                    <div class="w-10 h-5 bg-gray-200 rounded-full relative cursor-pointer shadow-inner shrink-0">
                        <div class="absolute left-1 top-1 w-3 h-3 bg-white shadow-sm rounded-full transition-all"></div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm flex-1">
                <h3 class="text-lg font-bold text-gray-800 mb-2">Ganti Kata Sandi</h3>
                <p class="text-xs text-gray-500 mb-6">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak.</p>

                <form method="post" action="{{ route('password.update') }}" class="space-y-4">
                    @csrf
                    @method('put')

                    <div>
                        <label for="current_password" class="block text-xs font-bold text-gray-700 mb-1">Password Saat Ini</label>
                        <input type="password" id="current_password" name="current_password" autocomplete="current-password"
                            class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl py-2.5 px-3 text-sm focus:ring-2 focus:ring-[#2b95b1] focus:border-transparent transition">
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1 text-xs text-red-500" />
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-bold text-gray-700 mb-1">Password Baru</label>
                        <input type="password" id="password" name="password" autocomplete="new-password"
                            class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl py-2.5 px-3 text-sm focus:ring-2 focus:ring-[#2b95b1] focus:border-transparent transition">
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1 text-xs text-red-500" />
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-gray-700 mb-1">Konfirmasi Password Baru</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password"
                            class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl py-2.5 px-3 text-sm focus:ring-2 focus:ring-[#2b95b1] focus:border-transparent transition">
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1 text-xs text-red-500" />
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full bg-gray-800 text-white px-4 py-2.5 rounded-xl hover:bg-gray-700 font-bold text-sm transition shadow-sm">
                            Update Password
                        </button>
                        @if (session('status') === 'password-updated')
                            <p class="text-xs text-green-600 font-bold mt-2 text-center"><i class="fa-solid fa-check mr-1"></i> Password berhasil diubah</p>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="bg-red-50 rounded-2xl p-8 border border-red-100 shadow-sm">
        <div class="max-w-2xl">
            <h3 class="text-lg font-bold text-red-600 mb-2">Hapus Akun</h3>
            <p class="text-sm text-red-500/80 mb-6">
                Setelah akun Anda dihapus, semua sumber daya dan data di dalamnya akan dihapus secara permanen. Sebelum menghapus akun, harap unduh data atau informasi apa pun yang ingin Anda simpan.
            </p>

            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="bg-red-600 text-white px-6 py-2.5 rounded-xl hover:bg-red-700 font-bold shadow-sm transition">
                Hapus Akun Permanen
            </button>
        </div>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <h2 class="text-xl font-bold text-gray-900">
                Apakah Anda yakin ingin menghapus akun Anda?
            </h2>

            <p class="mt-3 text-sm text-gray-600">
                Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Silakan masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun Anda secara permanen.
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">Password</label>
                <input type="password" id="password" name="password" placeholder="Password"
                    class="w-full sm:w-3/4 bg-white border border-gray-300 text-gray-900 rounded-xl py-3 px-4 focus:ring-2 focus:ring-red-500 focus:border-transparent transition">
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-red-500" />
            </div>

            <div class="mt-8 flex justify-end gap-4">
                <button type="button" x-on:click="$dispatch('close')" class="bg-white border border-gray-300 text-gray-700 px-5 py-2.5 rounded-xl hover:bg-gray-50 font-bold transition">
                    Batal
                </button>
                <button type="submit" class="bg-red-600 text-white px-5 py-2.5 rounded-xl hover:bg-red-700 font-bold shadow-sm transition">
                    Hapus Akun
                </button>
            </div>
        </form>
    </x-modal>

@endsection