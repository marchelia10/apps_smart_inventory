@extends('layout.kelolapengguna')

@section('title', 'Kelola Pengguna')

@section('content')
<div class="bg-gray-100 font-poppins leading-normal tracking-normal">
    <div class="w-full p-8">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-3xl font-bold text-gray-800">KELOLA PENGGUNA</h1>
            <button
                onclick="openAddModal()"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Pengguna
            </button>
        </div>

        <!-- Tampilkan pesan success/error -->
        @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
        @endif

        <div class="overflow-hidden rounded-lg border border-gray-300 shadow-sm mb-8">
            <table class="table-auto w-full border-collapse">
                <thead>
                    <tr class="bg-blue-300 text-black">
                        <th class="py-3 px-4 font-bold text-center rounded-tl-lg">No</th>
                        <th class="py-3 px-4 font-bold text-left">Nama Pengguna</th>
                        <th class="py-3 px-4 font-bold text-left">Email</th>
                        <th class="py-3 px-4 font-bold text-center">Role</th>
                        <th class="py-3 px-4 font-bold text-center rounded-tr-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kelolapengguna as $index => $user)
                    <tr class="bg-white border-b hover:bg-gray-100">
                        <td class="py-3 px-4 text-center">{{ $index + 1 }}</td>
                        <td class="py-3 px-4 text-left">{{ $user->username }}</td>
                        <td class="py-3 px-4 text-left">{{ $user->email }}</td>
                        <td class="py-3 px-4 text-center capitalize">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <!-- Ubah ini: panggil fungsi openEditModal langsung dengan onclick -->
                            <button
                                onclick="openEditModal({{ $user->id }}, '{{ addslashes($user->username) }}', '{{ addslashes($user->email) }}', '{{ $user->role }}')"
                                class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded mr-1">
                                Edit
                            </button>
                            <form action="{{ route('kelolapengguna.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Pengguna -->
<div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-lg p-6">
        <h2 class="text-2xl font-bold mb-6 text-black">Tambah Pengguna Baru</h2>
        <form id="addForm" action="{{ route('kelolapengguna.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-black mb-1 font-semibold">Nama Pengguna <span class="text-red-500">*</span></label>
                <input type="text" name="username" id="addUsername" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-black mb-1 font-semibold">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" id="addEmail" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-black mb-1 font-semibold">Kata Sandi <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input type="password" name="password" id="addPassword" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10">
                    <button type="button" onclick="togglePassword('addPassword')" class="absolute right-0 top-0 h-full px-3 text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter</p>
            </div>

            <div class="mb-6">
                <label class="block text-black mb-1 font-semibold">Role <span class="text-red-500">*</span></label>
                <select name="role" id="addRole" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Role</option>
                    <option value="pengguna">Pengguna</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeAddModal()" class="bg-red-500 hover:bg-red-600 text-white font-semibold px-6 py-2 rounded-lg">Batal</button>
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-2 rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-lg p-6">
        <h2 class="text-2xl font-bold mb-6 text-black">Form Edit Role Pengguna</h2>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-black mb-1 font-semibold">Nama Pengguna</label>
                <input id="editUsername" type="text" class="w-full px-4 py-2 border rounded-lg bg-gray-100" disabled>
            </div>

            <div class="mb-4">
                <label class="block text-black mb-1 font-semibold">Email</label>
                <input id="editEmail" type="text" class="w-full px-4 py-2 border rounded-lg bg-gray-100" disabled>
            </div>

            <div class="mb-6">
                <label class="block text-black mb-1 font-semibold">Role Saat Ini</label>
                <select id="editRole" name="role" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="pengguna">Pengguna</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeEditModal()" class="bg-red-500 hover:bg-red-600 text-white font-semibold px-6 py-2 rounded-lg">Batal</button>
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-2 rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Fungsi untuk Modal Tambah
    function openAddModal() {
        document.getElementById('addModal').classList.remove('hidden');
        document.getElementById('addForm').reset();
    }

    function closeAddModal() {
        document.getElementById('addModal').classList.add('hidden');
    }

    // Fungsi untuk Modal Edit
    function openEditModal(id, username, email, role) {
        console.log('Opening edit modal for user:', id, username, email, role); // Debugging

        const editModal = document.getElementById('editModal');
        const editUsername = document.getElementById('editUsername');
        const editEmail = document.getElementById('editEmail');
        const editRole = document.getElementById('editRole');
        const editForm = document.getElementById('editForm');

        if (!editModal || !editUsername || !editEmail || !editRole || !editForm) {
            console.error('Modal elements not found!');
            return;
        }

        // Isi data ke modal
        editUsername.value = username;
        editEmail.value = email;
        editRole.value = role;

        // Set action form
        editForm.action = `/kelola-pengguna/${id}`;

        // Tampilkan modal
        editModal.classList.remove('hidden');

        // Tambahkan efek fade in
        editModal.style.opacity = '0';
        setTimeout(() => {
            editModal.style.opacity = '1';
        }, 10);
    }

    function closeEditModal() {
        const editModal = document.getElementById('editModal');
        if (editModal) {
            editModal.classList.add('hidden');
            // Reset opacity
            editModal.style.opacity = '';
        }
    }

    // Fungsi toggle password visibility
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        if (input) {
            if (input.type === 'password') {
                input.type = 'text';
            } else {
                input.type = 'password';
            }
        }
    }

    // Tutup modal jika klik di luar modal
    window.onclick = function(event) {
        const addModal = document.getElementById('addModal');
        const editModal = document.getElementById('editModal');

        if (event.target === addModal) {
            closeAddModal();
        }
        if (event.target === editModal) {
            closeEditModal();
        }
    }

    // Debug: Cek apakah fungsi tersedia
    console.log('Functions loaded: openEditModal', typeof openEditModal);
</script>

<style>
    /* Smooth transition untuk modal */
    .fixed {
        transition: all 0.3s ease;
    }

    /* Animasi untuk modal */
    #editModal,
    #addModal {
        transition: opacity 0.3s ease;
    }

    /* Scrollbar styling */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>
@endsection