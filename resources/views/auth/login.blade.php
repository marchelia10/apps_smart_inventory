<!DOCTYPE html>
<html lang="id">

<head>
    @include('partials.head')
    <style>
        body {
            overflow: hidden;
        }
    </style>
    <link rel="preload" href="{{ url('image/background_login.png') }}" as="image">
</head>

@php
$bgImage = asset('image/background_login.png');
@endphp

<body class="bg-gray-200 min-h-screen bg-cover bg-center flex justify-end items-center pr-28"
    style="background-image: url('{{ $bgImage }}');">

    <!-- Login Card -->
    <div class="bg-white bg-opacity-90 backdrop-blur-md rounded-xl shadow-xl w-full max-w-md p-8">
        <h1 class="text-2xl font-bold text-center mb-6 text-gray-800">Masuk Akun</h1>

        <!-- Tampilkan pesan success dari registrasi -->
        @if (session('success'))
        <div class="p-3 bg-green-100 text-green-700 rounded-lg text-sm mb-4">
            {{ session('success') }}
        </div>
        @endif

        <!-- Tampilkan pesan error -->
        @if (session('error'))
        <div class="p-3 bg-red-100 text-red-700 rounded-lg text-sm mb-4">
            {{ session('error') }}
        </div>
        @endif

        <!-- Tampilkan error validasi -->
        @if ($errors->any())
        <div class="p-3 bg-red-100 text-red-700 rounded-lg text-sm mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Login Field (Username atau Email) -->
            <div>
                <label for="login" class="block text-sm font-medium text-gray-700">Nama Pengguna atau Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <input type="text" name="login" id="login" required value="{{ old('login') }}"
                        placeholder="Masukkan username atau email"
                        class="w-full pl-10 pr-4 py-2 rounded-lg bg-gray-100 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input type="password" name="password" id="password" required
                        class="w-full pl-10 pr-12 py-2 rounded-lg bg-gray-100 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="button" id="togglePassword" class="absolute right-0 top-0 h-full px-3 text-gray-600">
                        <svg id="eyeShow" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg id="eyeHide" class="h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Login Button -->
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                Masuk
            </button>

            <!-- Registration Link -->
            <p class="text-center text-sm text-gray-600 mt-2">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Daftar</a>
            </p>
        </form>
    </div>

    <!-- JavaScript: toggle mata -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('togglePassword');
            const input = document.getElementById('password');
            const eyeShow = document.getElementById('eyeShow');
            const eyeHide = document.getElementById('eyeHide');

            if (btn && input && eyeShow && eyeHide) {
                btn.addEventListener('click', function() {
                    if (input.type === 'password') {
                        input.type = 'text';
                        eyeShow.classList.add('hidden');
                        eyeHide.classList.remove('hidden');
                    } else {
                        input.type = 'password';
                        eyeShow.classList.remove('hidden');
                        eyeHide.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>

</html>