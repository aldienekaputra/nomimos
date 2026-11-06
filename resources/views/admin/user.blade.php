@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')
<main class="flex-1 p-8 overflow-y-auto space-y-6 bg-[#e9eff6]" x-data="{ showAddModal: false, editUser: null }">
    
    <!-- NOTIFIKASI SUKSES / ERROR -->
    @if(session('success'))
    <div class="bg-emerald-600 text-white p-4 rounded-xl shadow-sm text-sm font-medium flex justify-between items-center">
        <span class="flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </span>
        <button onclick="this.parentElement.remove()" class="font-bold text-lg hover:opacity-80">&times;</button>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-rose-600 text-white p-4 rounded-xl shadow-sm text-sm font-medium flex justify-between items-center">
        <span class="flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            {{ session('error') }}
        </span>
        <button onclick="this.parentElement.remove()" class="font-bold text-lg hover:opacity-80">&times;</button>
    </div>
    @endif

    <!-- HEADER BAR: JUDUL & PENCARIAN -->
    <div class="flex justify-between items-center bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
        <div>
            <h2 class="font-serif-title text-2xl font-bold text-black">Pengguna Website</h2>
            <p class="text-xs text-gray-500 mt-0.5">Daftar seluruh akun yang terdaftar untuk mengakses sistem NOMIMOS</p>
        </div>

        <div class="flex items-center gap-3">
            <!-- INPUT SEARCH INSTAN -->
            <div class="relative">
                <input type="text" id="userSearchInput" onkeyup="searchUsers()" placeholder="Cari username / role di hal ini..." 
                       class="bg-[#f8fafc] border border-gray-300 text-gray-800 text-xs font-medium rounded-xl pl-9 pr-4 py-2.5 focus:outline-none focus:border-[#1e314b] shadow-sm w-64">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            <!-- TOMBOL TAMBAH USER -->
            <button @click="showAddModal = true" class="bg-[#1e314b] text-white text-xs px-4 py-2.5 rounded-xl font-semibold hover:bg-slate-800 transition-all flex items-center gap-1.5 shadow-sm">
                <span>+</span> Tambah User
            </button>
        </div>
    </div>

    <!-- STATISTIK RINGKASAN AKUN BERMANFAAT -->
    <div class="grid grid-cols-4 gap-5">
        <!-- 1. TOTAL USER -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total Akun</p>
                <h4 class="text-2xl font-bold text-[#1e314b] mt-0.5">{{ $totalUsers }}</h4>
            </div>
            <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600 font-bold text-sm">
                👥
            </div>
        </div>

        <!-- 2. TOTAL ADMIN -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Akun Admin</p>
                <h4 class="text-2xl font-bold text-purple-700 mt-0.5">{{ $totalAdmin }}</h4>
            </div>
            <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600 font-bold text-sm">
                🔑
            </div>
        </div>

        <!-- 3. TOTAL KLIEN -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Akun Klien</p>
                <h4 class="text-2xl font-bold text-blue-700 mt-0.5">{{ $totalKlien }}</h4>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 font-bold text-sm">
                💍
            </div>
        </div>

        <!-- 4. TOTAL CREW -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Akun Crew</p>
                <h4 class="text-2xl font-bold text-amber-700 mt-0.5">{{ $totalCrew }}</h4>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 font-bold text-sm">
                🎬
            </div>
        </div>
    </div>

    <!-- KONTEN TABEL DAFTAR USER -->
    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 flex flex-col justify-between min-h-[460px]">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-separate border-spacing-y-2">
                <thead>
                    <tr class="font-serif-title font-bold text-black border-b border-gray-200 text-xs uppercase tracking-wider">
                        <th class="py-3 px-4 w-20">ID User</th>
                        <th class="py-3 px-4">Username</th>
                        <th class="py-3 px-4 text-center">Role Akses</th>
                        <th class="py-3 px-4 text-center w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody id="userTableBody" class="divide-y divide-gray-100 text-gray-800">
                    @forelse($users as $u)
                    <tr class="user-row hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4 text-xs font-mono font-bold text-gray-400">#{{ $u->id_user }}</td>
                        <td class="py-3 px-4 font-bold text-black font-mono text-sm username-cell">{{ $u->username }}</td>
                        <td class="py-3 px-4 text-center role-cell">
                            @if($u->role === 'Admin')
                                <span class="bg-purple-100 text-purple-800 text-xs px-3 py-1 rounded-full font-bold inline-block border border-purple-200">Admin</span>
                            @elseif($u->role === 'Klien')
                                <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full font-bold inline-block border border-blue-200">Klien</span>
                            @else
                                <span class="bg-amber-100 text-amber-800 text-xs px-3 py-1 rounded-full font-bold inline-block border border-amber-200">Crew</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button @click="editUser = {{ json_encode($u) }}" 
                                        class="bg-amber-500/10 text-amber-700 hover:bg-amber-500 hover:text-white px-3 py-1 rounded-md text-xs font-semibold transition-all shadow-xs">
                                    Edit
                                </button>
                                <form action="{{ route('admin.user.destroy', $u->id_user) }}" method="POST" class="inline" onsubmit="return confirm('Hapus akun pengguna {{ $u->username }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500/10 text-red-600 hover:bg-red-600 hover:text-white px-3 py-1 rounded-md text-xs font-semibold transition-all shadow-xs">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-12 text-center text-gray-400 text-sm">Belum ada akun pengguna yang terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- LINK PAGINATION -->
        <div class="pt-6 border-t border-gray-100">
            {{ $users->links() }}
        </div>
    </div>

    <!-- MODAL TAMBAH USER -->
    <div x-show="showAddModal" style="display: none;" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md space-y-4 shadow-xl relative" @click.outside="showAddModal = false">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="font-serif-title font-bold text-lg text-black">Tambah Akun Pengguna</h3>
                <button @click="showAddModal = false" class="text-gray-400 hover:text-gray-600 font-bold text-xl">&times;</button>
            </div>
            
            <form action="{{ route('admin.user.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="text-xs font-semibold text-gray-600 mb-1 block">Username</label>
                    <input type="text" name="username" placeholder="Masukkan username" required 
                           class="w-full border border-gray-300 rounded-xl p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-600 mb-1 block">Password</label>
                    <input type="password" name="password" placeholder="******" required 
                           class="w-full border border-gray-300 rounded-xl p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-600 mb-1 block">Role Akses</label>
                    <select name="role" required class="w-full border border-gray-300 rounded-xl p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                        <option value="Admin">Admin</option>
                        <option value="Klien">Klien</option>
                        <option value="Crew">Crew</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t">
                    <button type="button" @click="showAddModal = false" class="px-4 py-2 border rounded-xl text-xs font-semibold text-gray-600">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-[#1e314b] text-white rounded-xl text-xs font-semibold hover:bg-slate-800 transition-colors shadow-sm">
                        Simpan User
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT USER -->
    <div x-show="editUser" style="display: none;" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md space-y-4 shadow-xl relative" x-if="editUser" @click.outside="editUser = null">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="font-serif-title font-bold text-lg text-black">Edit Akun Pengguna</h3>
                <button @click="editUser = null" class="text-gray-400 hover:text-gray-600 font-bold text-xl">&times;</button>
            </div>
            
            <form :action="`{{ url('/admin/user') }}/${editUser?.id_user}`" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="text-xs font-semibold text-gray-600 mb-1 block">Username</label>
                    <input type="text" name="username" :value="editUser?.username" required 
                           class="w-full border border-gray-300 rounded-xl p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-600 mb-1 block">Password Baru <span class="text-gray-400 font-normal">(Kosongkan jika tidak diubah)</span></label>
                    <input type="password" name="password" placeholder="******" 
                           class="w-full border border-gray-300 rounded-xl p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-600 mb-1 block">Role Akses</label>
                    <select name="role" :value="editUser?.role" required class="w-full border border-gray-300 rounded-xl p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                        <option value="Admin">Admin</option>
                        <option value="Klien">Klien</option>
                        <option value="Crew">Crew</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t">
                    <button type="button" @click="editUser = null" class="px-4 py-2 border rounded-xl text-xs font-semibold text-gray-600">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-[#1e314b] text-white rounded-xl text-xs font-semibold hover:bg-slate-800 transition-colors shadow-sm">
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>

</main>

<script>
    function searchUsers() {
        const input = document.getElementById('userSearchInput').value.toLowerCase();
        const rows = document.querySelectorAll('.user-row');

        rows.forEach(row => {
            const username = row.querySelector('.username-cell').textContent.toLowerCase();
            const role = row.querySelector('.role-cell').textContent.toLowerCase();

            if (username.includes(input) || role.includes(input)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.min.js" defer></script>
@endsection