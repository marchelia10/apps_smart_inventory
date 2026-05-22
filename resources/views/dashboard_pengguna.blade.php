@extends('layout.dashboard_pengguna')

@section('title', 'Dashboard Pengguna')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Dashboard</h1>
    <div class="text-sm text-gray-700 flex items-center gap-2">
        <i class="fas fa-user text-blue-600"></i>
        <span class="font-semibold">{{ Auth::user()->username }}</span> {{-- Ubah dari nama_mahasiswa ke username --}}
    </div>
</div>

<!-- Rest of your code remains the same -->
<!-- Search & Filter -->
<form method="GET" action="{{ route('dashboard_pengguna') }}" class="mb-6 flex flex-col md:flex-row gap-4">
    <input type="text" name="search" placeholder="Cari barang..." value="{{ $search ?? '' }}"
        class="px-4 py-2 border rounded-md w-full md:w-1/2">

    <select name="kategori" class="px-4 py-2 border rounded-md w-full md:w-1/4">
        <option value="">Semua Kategori</option>
        @foreach ($kategoris as $kategori)
        <option value="{{ $kategori->id }}" {{ (isset($kategoriId) && $kategoriId == $kategori->id) ? 'selected' : '' }}>
            {{ $kategori->nama_kategori }}
        </option>
        @endforeach
    </select>

    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 w-full md:w-auto">
        Filter
    </button>
</form>

<!-- List Barang dalam Card -->
@if ($barangs->isEmpty())
<p class="text-gray-600 italic">Tidak ada barang yang ditemukan.</p>
@else
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @foreach ($barangs as $barang)
    <div class="bg-white rounded-xl shadow hover:shadow-lg overflow-hidden transition duration-300">
        @if ($barang->gambar)
        <img src="{{ asset('storage/' . $barang->gambar) }}" alt="{{ $barang->nama_barang }}" class="w-full h-40 object-cover">
        @else
        <div class="w-full h-40 bg-gray-200 flex items-center justify-center text-gray-500">
            Tidak ada gambar
        </div>
        @endif

        <div class="p-4">
            <h2 class="text-lg font-bold mb-1">{{ $barang->nama_barang }}</h2>
            <p class="text-sm text-gray-600"><strong>Kategori:</strong> {{ $barang->kategori->nama_kategori ?? '-' }}</p>
            <p class="text-sm text-gray-600"><strong>Stok:</strong> {{ $barang->jumlah }} pcs</p>
            <p class="text-sm text-gray-700 mt-2"><strong>Deskripsi:</strong><br> {!! nl2br(e($barang->deskripsi)) !!}</p>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection