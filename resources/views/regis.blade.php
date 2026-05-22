<head>
    @include('partials.head')
</head>
<body class="flex items-center justify-center min-h-screen bg-yellow-400">
    <div class="absolute inset-0">
        <img src="{{url('image/background.png')}}" alt="Background" class="object-cover w-full h-full opacity-40">
    </div>

    <!-- Form regis -->
    <div class="relative z-10 flex flex-col items-center justify-center w-full max-w-md p-6 bg-white rounded-lg shadow-md md:max-w-lg">
        <h1 class="mb-6 text-2xl font-bold text-center">Daftar Akun</h1>
        <form class="space-y-4">
            <input type="text" placeholder="Nama Lengkap" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
            <input type="email" placeholder="Email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
            <input type="password" placeholder="Kata Sandi" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
            <input type="password" placeholder="Konfirmasi Sandi" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">

        </form>
        <p class="mt-4 text-center text-gray-600">Sudah Punya Akun? <a href="#" class="text-yellow-600 hover:underline">Masuk</a></p>
        <button type="submit" class="w-full py-2 text-white bg-yellow-600 rounded-lg hover:bg-yellow-500">Daftar</button>
    </div>
</body>
</html>
