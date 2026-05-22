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

<body class="bg-gray-200 min-h-screen bg-cover bg-center flex justify-end items-center pr-28"
    style="background-image: url('{{ url('image/background_login.png') }}');">

    <!-- Form Register -->
    <div class="bg-white bg-opacity-90 backdrop-blur-md rounded-xl shadow-xl w-full max-w-md p-8 overflow-y-auto max-h-[95vh]">
        <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Daftar Akun</h1>

        <form action="/register" method="POST" onsubmit="return validateForm();" class="space-y-4">
            @csrf

            <!-- Input Group Template -->
            @php
                $inputs = [
                    ['id' => 'nama_lengkap', 'label' => 'Nama Lengkap', 'type' => 'text', 'icon' => 'M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                    ['id' => 'email', 'label' => 'Email', 'type' => 'email', 'icon' => 'M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z'],
['id' => 'no badge', 'label' => 'No badge', 'type' => 'text', 'icon' => 'M3 4a1 1 0 011-1h16a1 1 0 011 1v16a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm4 3a2 2 0 104 0 2 2 0 00-4 0zm0 4h8v1H7v-1zm0 2h8v1H7v-1z'],
                    ['id' => 'No Telephone', 'label' => 'No Telephone', 'type' => 'text', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0z M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                ];
            @endphp

            @foreach ($inputs as $input)
                <div>
                    <label for="{{ $input['id'] }}" class="block text-sm font-medium text-gray-700">{{ $input['label'] }}</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $input['icon'] }}" />
                            </svg>
                        </div>
                        <input type="{{ $input['type'] }}" name="{{ $input['id'] }}" id="{{ $input['id'] }}" required
                            value="{{ old($input['id']) }}"
                            class="w-full pl-10 pr-4 py-2 rounded-lg bg-gray-100 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    @error($input['id'])
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endforeach

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
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Kata Sandi</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 11h14a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm7-7a4 4 0 014 4v3H8V8a4 4 0 014-4z" />
                        </svg>
                    </div>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full pl-10 pr-12 py-2 rounded-lg bg-gray-100 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="button" id="togglePasswordConfirm" class="absolute right-0 top-0 h-full px-3 text-gray-600">
                        <svg id="eyeShowConfirm" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg id="eyeHideConfirm" class="h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Tombol Daftar -->
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                Daftar
            </button>

            <!-- Link Login -->
            <p class="text-center text-sm text-gray-600 mt-2">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Masuk</a>
            </p>
        </form>
    </div>

    <!-- JS Validasi & Toggle Mata -->
    <script>
        function validateForm() {
            const pass = document.getElementById('password').value;
            const confirm = document.getElementById('password_confirmation').value;
            if (pass !== confirm) {
                alert("Konfirmasi kata sandi tidak sesuai.");
                return false;
            }
            return true;
        }

        document.addEventListener('DOMContentLoaded', function () {
            const toggle = (btnId, inputId, eyeShowId, eyeHideId) => {
                const btn = document.getElementById(btnId);
                const input = document.getElementById(inputId);
                const eyeShow = document.getElementById(eyeShowId);
                const eyeHide = document.getElementById(eyeHideId);

                btn.addEventListener('click', function () {
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
            };

            toggle('togglePassword', 'password', 'eyeShow', 'eyeHide');
            toggle('togglePasswordConfirm', 'password_confirmation', 'eyeShowConfirm', 'eyeHideConfirm');
        });
    </script>
</body>

</html>
