@extends('layouts.admin')

@section('title', 'Klien / Event')

@section('content')
<main class="flex-1 p-8 overflow-y-auto space-y-6 bg-[#e9eff6]" 
      x-data="{ 
          activeTab: 'rundown', 
          showAddRundown: false, 
          editRundownData: null, 
          showAddMoodboard: false,
          editMoodboardData: null,
          showAddNote: false,
          showEditNote: false
      }">
    
    <!-- NOTIFIKASI SUKSES -->
    @if(session('success'))
    <div class="bg-emerald-600 text-white p-4 rounded-xl shadow-sm text-sm font-medium flex justify-between items-center">
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="font-bold text-lg">&times;</button>
    </div>
    @endif

    <!-- HEADER BAR: JUDUL & FILTER DROPDOWN TERKONEKSI INTERAKTIF -->
    <div class="flex justify-between items-center bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
        <div>
            <h2 class="font-serif-title text-2xl font-bold text-black">Klien / Event</h2>
            <p class="text-xs text-gray-500 mt-0.5">Filter bulan acara untuk mempersempit daftar pengantin</p>
        </div>
        
        <div class="flex items-center gap-3">
            <!-- 1. FILTER BULAN -->
            <div class="flex flex-col">
                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">1. Pilih Bulan Acara</label>
                <select id="filterBulan" onchange="filterKlienByBulan()" 
                        class="bg-[#f8fafc] border border-gray-300 text-gray-800 text-xs font-semibold rounded-xl px-4 py-2.5 focus:outline-none focus:border-[#1e314b] shadow-sm cursor-pointer">
                    <option value="">-- Semua Bulan --</option>
                    <option value="01">Januari</option>
                    <option value="02">Februari</option>
                    <option value="03">Maret</option>
                    <option value="04">April</option>
                    <option value="05">Mei</option>
                    <option value="06">Juni</option>
                    <option value="07">Juli</option>
                    <option value="08">Agustus</option>
                    <option value="09">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
            </div>

            <!-- 2. FILTER NAMA PENGANTIN -->
            <div class="flex flex-col">
                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">2. Pilih Pengantin</label>
                <select id="filterKlien" onchange="renderEventDetail(this.value)" 
                        class="bg-[#f8fafc] border border-gray-300 text-gray-800 text-xs font-semibold rounded-xl px-4 py-2.5 focus:outline-none focus:border-[#1e314b] shadow-sm min-w-[240px] cursor-pointer">
                </select>
            </div>
        </div>
    </div>

    <!-- MAIN WRAPPER KONTEN EVENT -->
    <div id="contentArea" class="space-y-6">
        
        <!-- NAVIGASI TAB MENU -->
        <div class="flex border-b border-gray-300 gap-8 text-lg font-serif-title font-bold text-gray-500">
            <button @click="activeTab = 'rundown'" 
                    :class="{ 'text-[#1e314b] border-b-2 border-[#1e314b] pb-2': activeTab === 'rundown' }" 
                    class="hover:text-[#1e314b] transition-colors focus:outline-none">
                Rundown
            </button>
            <button @click="activeTab = 'moodboard'" 
                    :class="{ 'text-[#1e314b] border-b-2 border-[#1e314b] pb-2': activeTab === 'moodboard' }" 
                    class="hover:text-[#1e314b] transition-colors focus:outline-none">
                Moodboard
            </button>
            <button @click="activeTab = 'note'" 
                    :class="{ 'text-[#1e314b] border-b-2 border-[#1e314b] pb-2': activeTab === 'note' }" 
                    class="hover:text-[#1e314b] transition-colors focus:outline-none">
                Note & List
            </button>
        </div>

        <!-- AREA KONTEN TAB -->
        <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 min-h-[420px]">
            
            <!-- 1. TAB RUNDOWN -->
            <div x-show="activeTab === 'rundown'" class="space-y-4">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 id="rundownTitle" class="font-serif-title text-xl font-bold text-black">Rundown Acara</h3>
                        <p id="rundownSubtitle" class="text-xs text-gray-500">Tanggal Acara: -</p>
                    </div>
                    <button @click="showAddRundown = true" class="bg-[#1e314b] text-white text-xs px-4 py-2.5 rounded-xl font-semibold hover:bg-slate-800 transition-colors flex items-center gap-1.5 shadow-sm">
                        <span>+</span> Tambah Rundown
                    </button>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm border-separate border-spacing-y-2">
                        <thead>
                            <tr class="font-serif-title font-bold text-black border-b border-gray-200 uppercase text-xs tracking-wider">
                                <th class="py-3 px-4 w-36">Waktu</th>
                                <th class="py-3 px-4">Nama Kegiatan</th>
                                <th class="py-3 px-4">Penanggung Jawab</th>
                                <th class="py-3 px-4">Keterangan</th>
                                <th class="py-3 px-4 text-center w-36">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="rundownTableBody" class="divide-y divide-gray-100 text-gray-800">
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 2. TAB MOODBOARD -->
            <div x-show="activeTab === 'moodboard'" style="display: none;" class="space-y-4">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 id="moodboardTitle" class="font-serif-title text-xl font-bold text-black">Moodboard Acara</h3>
                        <p id="moodboardSubtitle" class="text-xs text-gray-500">Tanggal Acara: -</p>
                    </div>
                    <button @click="showAddMoodboard = true" class="bg-[#1e314b] text-white text-xs px-4 py-2.5 rounded-xl font-semibold hover:bg-slate-800 transition-colors flex items-center gap-1.5 shadow-sm">
                        <span>+</span> Tambah Moodboard
                    </button>
                </div>
                
                <div id="moodboardGrid" class="grid grid-cols-3 gap-6">
                </div>
            </div>

            <!-- 3. TAB NOTE & LIST -->
            <div x-show="activeTab === 'note'" style="display: none;" class="space-y-6">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 id="noteTitle" class="font-serif-title text-xl font-bold text-black">Catatan & List Kebutuhan</h3>
                        <p id="noteSubtitle" class="text-xs text-gray-500">Tanggal Acara: -</p>
                    </div>
                    
                    <div id="noteActionBox" class="flex gap-2">
                    </div>
                </div>
                
                <div id="noteContentBox">
                </div>
            </div>

        </div>
    </div>

    <!-- AREA EMPTY STATE -->
    <div id="emptyArea" class="hidden bg-white rounded-2xl p-12 text-center border border-gray-100 text-slate-400 text-sm">
        Tidak ditemukan acara pengantin pada bulan terpilih.
    </div>

    <!-- MODAL ADD RUNDOWN -->
    <div x-show="showAddRundown" style="display: none;" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md space-y-4 shadow-xl relative" @click.outside="showAddRundown = false">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="font-serif-title font-bold text-lg text-black">Tambah Item Rundown</h3>
                <button @click="showAddRundown = false" class="text-gray-400 hover:text-gray-600 font-bold text-xl">&times;</button>
            </div>
            <form action="{{ route('admin.rundown.store') }}" method="POST" class="space-y-3">
                @csrf
                <input type="hidden" id="modalRundownIdPemesanan" name="id_pemesanan" value="">
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="text-xs font-semibold text-gray-600 mb-1 block">Jam Mulai</label>
                        <input type="time" name="waktu_mulai" required class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-600 mb-1 block">Jam Selesai</label>
                        <input type="time" name="waktu_selesai" required class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                    </div>
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-600 mb-1 block">Nama Kegiatan</label>
                    <input type="text" name="nama_kegiatan" required class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-600 mb-1 block">Penanggung Jawab</label>
                    <input type="text" name="penanggung_jawab" required class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-600 mb-1 block">Keterangan</label>
                    <textarea name="keterangan" class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]"></textarea>
                </div>
                <div class="flex justify-end gap-2 pt-3 border-t">
                    <button type="button" @click="showAddRundown = false" class="px-4 py-2 border rounded-xl text-xs font-semibold text-gray-600">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-[#1e314b] text-white rounded-xl text-xs font-semibold hover:bg-slate-800 transition-colors shadow-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT RUNDOWN -->
    <div x-show="editRundownData" style="display: none;" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md space-y-4 shadow-xl relative" @click.outside="editRundownData = null">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="font-serif-title font-bold text-lg text-black">Edit Item Rundown</h3>
                <button @click="editRundownData = null" class="text-gray-400 hover:text-gray-600 font-bold text-xl">&times;</button>
            </div>
            <form :action="`{{ url('/admin/klien/rundown') }}/${editRundownData?.id_rundown}`" method="POST" class="space-y-3">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="text-xs font-semibold text-gray-600 mb-1 block">Jam Mulai</label>
                        <input type="time" name="waktu_mulai" :value="editRundownData?.waktu_mulai" required class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-600 mb-1 block">Jam Selesai</label>
                        <input type="time" name="waktu_selesai" :value="editRundownData?.waktu_selesai" required class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                    </div>
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-600 mb-1 block">Nama Kegiatan</label>
                    <input type="text" name="nama_kegiatan" :value="editRundownData?.nama_kegiatan" required class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-600 mb-1 block">Penanggung Jawab</label>
                    <input type="text" name="penanggung_jawab" :value="editRundownData?.penanggung_jawab" required class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-600 mb-1 block">Keterangan</label>
                    <textarea name="keterangan" :value="editRundownData?.keterangan" class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]"></textarea>
                </div>
                <div class="flex justify-end gap-2 pt-3 border-t">
                    <button type="button" @click="editRundownData = null" class="px-4 py-2 border rounded-xl text-xs font-semibold text-gray-600">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-[#1e314b] text-white rounded-xl text-xs font-semibold hover:bg-slate-800 transition-colors shadow-sm">Update</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL ADD MOODBOARD (UPLOADER FILE GAMBAR) -->
    <div x-show="showAddMoodboard" style="display: none;" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md space-y-4 shadow-xl relative" @click.outside="showAddMoodboard = false">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="font-serif-title font-bold text-lg text-black">Upload Item Moodboard</h3>
                <button @click="showAddMoodboard = false" class="text-gray-400 hover:text-gray-600 font-bold text-xl">&times;</button>
            </div>
            <form action="{{ route('admin.moodboard.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <input type="hidden" id="modalMoodboardIdPemesanan" name="id_pemesanan" value="">
                <div>
                    <label class="text-xs font-semibold text-gray-600 mb-1 block">Pilih File Gambar</label>
                    <input type="file" name="gambar" accept="image/*" required class="w-full border rounded-lg p-2 text-xs focus:outline-none focus:border-[#1e314b]">
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-600 mb-1 block">Keterangan / Deskripsi</label>
                    <textarea name="keterangan" required placeholder="contoh: Referensi Pelaminan Outdoor / Moodboard Bunga" class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]"></textarea>
                </div>
                <div class="flex justify-end gap-2 pt-3 border-t">
                    <button type="button" @click="showAddMoodboard = false" class="px-4 py-2 border rounded-xl text-xs font-semibold text-gray-600">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-[#1e314b] text-white rounded-xl text-xs font-semibold hover:bg-slate-800 transition-colors shadow-sm">Upload & Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT MOODBOARD (UPLOADER GANTI GAMBAR) -->
    <div x-show="editMoodboardData" style="display: none;" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md space-y-4 shadow-xl relative" @click.outside="editMoodboardData = null">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="font-serif-title font-bold text-lg text-black">Edit Moodboard</h3>
                <button @click="editMoodboardData = null" class="text-gray-400 hover:text-gray-600 font-bold text-xl">&times;</button>
            </div>
            <form :action="`{{ url('/admin/klien/moodboard') }}/${editMoodboardData?.id_moodboard}`" method="POST" enctype="multipart/form-data" class="space-y-3">
                @csrf
                @method('PUT')
                <div>
                    <label class="text-xs font-semibold text-gray-600 mb-1 block">Ganti Gambar <span class="text-gray-400 font-normal">(Kosongkan jika tidak diubah)</span></label>
                    <input type="file" name="gambar" accept="image/*" class="w-full border rounded-lg p-2 text-xs focus:outline-none focus:border-[#1e314b]">
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-600 mb-1 block">Keterangan / Deskripsi</label>
                    <textarea name="keterangan" :value="editMoodboardData?.keterangan" required class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]"></textarea>
                </div>
                <div class="flex justify-end gap-2 pt-3 border-t">
                    <button type="button" @click="editMoodboardData = null" class="px-4 py-2 border rounded-xl text-xs font-semibold text-gray-600">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-[#1e314b] text-white rounded-xl text-xs font-semibold hover:bg-slate-800 transition-colors shadow-sm">Update Moodboard</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL ADD/EDIT CATATAN -->
    <div x-show="showAddNote || showEditNote" style="display: none;" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl p-6 w-full max-w-2xl space-y-4 shadow-xl relative" @click.outside="showAddNote = false; showEditNote = false">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="font-serif-title font-bold text-lg text-black">
                    <span x-show="showAddNote">Tambah Catatan Acara</span>
                    <span x-show="showEditNote">Edit Catatan Acara</span>
                </h3>
                <button @click="showAddNote = false; showEditNote = false" class="text-gray-400 hover:text-gray-600 font-bold text-xl">&times;</button>
            </div>
            
            <form id="formCatatan" action="" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="space-y-1">
                        <label class="font-bold text-[#1e314b] text-xs">List VIP</label>
                        <textarea id="inputListVip" name="list_VIP" rows="3" class="w-full border border-gray-300 rounded-xl p-2.5 text-xs focus:outline-none focus:border-[#1e314b]"></textarea>
                    </div>

                    <div class="space-y-1">
                        <label class="font-bold text-[#1e314b] text-xs">Request Lagu</label>
                        <textarea id="inputReqLagu" name="req_lagu" rows="3" class="w-full border border-gray-300 rounded-xl p-2.5 text-xs focus:outline-none focus:border-[#1e314b]"></textarea>
                    </div>

                    <div class="space-y-1">
                        <label class="font-bold text-[#1e314b] text-xs">List Foto VVIP</label>
                        <textarea id="inputListFotoVvip" name="list_foto_VVIP" rows="3" class="w-full border border-gray-300 rounded-xl p-2.5 text-xs focus:outline-none focus:border-[#1e314b]"></textarea>
                    </div>

                    <div class="space-y-1">
                        <label class="font-bold text-[#1e314b] text-xs">Catatan Kebutuhan</label>
                        <textarea id="inputCatatanKebutuhan" name="catatan_kebutuhan" rows="3" class="w-full border border-gray-300 rounded-xl p-2.5 text-xs focus:outline-none focus:border-[#1e314b]"></textarea>
                    </div>

                    <div class="space-y-1 col-span-2">
                        <label class="font-bold text-[#1e314b] text-xs">Petugas Keluarga</label>
                        <textarea id="inputPetugasKeluarga" name="petugas_keluarga" rows="2" class="w-full border border-gray-300 rounded-xl p-2.5 text-xs focus:outline-none focus:border-[#1e314b]"></textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-gray-100">
                    <button type="button" @click="showAddNote = false; showEditNote = false" class="px-4 py-2 border rounded-xl text-xs font-semibold text-gray-600">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-[#1e314b] text-white rounded-xl text-xs font-semibold hover:bg-slate-800 transition-colors shadow-sm">
                        Simpan Catatan
                    </button>
                </div>
            </form>
        </div>
    </div>

</main>

<!-- SCRIPT FILTERING & TRIGGER EDIT FIX -->
<script>
    const rawEvents = [
        @foreach($events as $e)
        {
            id: {{ $e->id_pemesanan }},
            bulan: '{{ \Carbon\Carbon::parse($e->tgl_acara)->format("m") }}',
            nama: {!! json_encode(($e->klien->nama_pria ?? '') . ' & ' . ($e->klien->nama_wanita ?? '')) !!},
            tglAcaraFormatted: '{{ \Carbon\Carbon::parse($e->tgl_acara)->translatedFormat("d F Y") }}',
            tglAcaraRaw: '{{ \Carbon\Carbon::parse($e->tgl_acara)->format("d/m/Y") }}',
            catatanUpdateUrl: '{{ route("admin.catatan.update", $e->id_pemesanan) }}',
            rundowns: [
                @foreach($e->rundowns as $r)
                {
                    id_rundown: {{ $r->id_rundown }},
                    waktu_mulai: '{{ \Carbon\Carbon::parse($r->waktu_mulai)->format("H:i") }}',
                    waktu_selesai: '{{ \Carbon\Carbon::parse($r->waktu_selesai)->format("H:i") }}',
                    nama_kegiatan: {!! json_encode($r->nama_kegiatan) !!},
                    penanggung_jawab: {!! json_encode($r->penanggung_jawab) !!},
                    keterangan: {!! json_encode($r->keterangan ?? '') !!}
                },
                @endforeach
            ],
            moodboards: [
                @foreach($e->moodboards as $m)
                {
                    id_moodboard: {{ $m->id_moodboard }},
                    url_gambar: {!! json_encode($m->url_gambar) !!},
                    keterangan: {!! json_encode($m->keterangan) !!}
                },
                @endforeach
            ],
            catatan: {!! json_encode($e->catatan) !!}
        },
        @endforeach
    ];

    function filterKlienByBulan() {
        const selectedBulan = document.getElementById('filterBulan').value;
        const selectKlien = document.getElementById('filterKlien');

        let filteredEvents = rawEvents;
        if(selectedBulan !== "") {
            filteredEvents = rawEvents.filter(e => e.bulan === selectedBulan);
        }

        selectKlien.innerHTML = '';

        if(filteredEvents.length > 0) {
            filteredEvents.forEach(e => {
                const opt = document.createElement('option');
                opt.value = e.id;
                opt.innerText = `${e.nama} (${e.tglAcaraRaw})`;
                selectKlien.appendChild(opt);
            });

            document.getElementById('contentArea').classList.remove('hidden');
            document.getElementById('emptyArea').classList.add('hidden');

            renderEventDetail(filteredEvents[0].id);
        } else {
            const opt = document.createElement('option');
            opt.value = '';
            opt.innerText = '-- Tidak Ada Pengantin di Bulan Ini --';
            selectKlien.appendChild(opt);

            document.getElementById('contentArea').classList.add('hidden');
            document.getElementById('emptyArea').classList.remove('hidden');
        }
    }

    function renderEventDetail(idPemesanan) {
        const event = rawEvents.find(e => e.id == idPemesanan);
        if(!event) return;

        document.getElementById('modalRundownIdPemesanan').value = event.id;
        document.getElementById('modalMoodboardIdPemesanan').value = event.id;
        document.getElementById('formCatatan').action = event.catatanUpdateUrl;

        document.getElementById('rundownTitle').innerText = 'Rundown Acara - ' + event.nama;
        document.getElementById('rundownSubtitle').innerText = 'Tanggal Acara: ' + event.tglAcaraFormatted;

        document.getElementById('moodboardTitle').innerText = 'Moodboard Acara - ' + event.nama;
        document.getElementById('moodboardSubtitle').innerText = 'Tanggal Acara: ' + event.tglAcaraFormatted;

        document.getElementById('noteTitle').innerText = 'Catatan & List Kebutuhan - ' + event.nama;
        document.getElementById('noteSubtitle').innerText = 'Tanggal Acara: ' + event.tglAcaraFormatted;

        // 1. RENDER RUNDOWN
        const rBody = document.getElementById('rundownTableBody');
        rBody.innerHTML = '';
        if(event.rundowns.length > 0) {
            event.rundowns.forEach(r => {
                const tr = document.createElement('tr');
                tr.className = 'hover:bg-slate-50 transition-colors';
                tr.innerHTML = `
                    <td class="py-3 px-4 font-semibold text-[#1e314b]">${r.waktu_mulai} - ${r.waktu_selesai}</td>
                    <td class="py-3 px-4 font-bold text-black">${r.nama_kegiatan}</td>
                    <td class="py-3 px-4 text-gray-700">${r.penanggung_jawab}</td>
                    <td class="py-3 px-4 text-gray-600 text-xs">${r.keterangan || '-'}</td>
                    <td class="py-3 px-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button type="button" onclick="openEditRundownModal(${r.id_rundown}, ${event.id})" 
                                    class="bg-amber-500/10 text-amber-700 hover:bg-amber-500 hover:text-white px-3 py-1 rounded-md text-xs font-semibold transition-all">
                                Edit
                            </button>
                            <form action="{{ url('/admin/klien/rundown') }}/${r.id_rundown}" method="POST" class="inline" onsubmit="return confirm('Hapus item rundown ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500/10 text-red-600 hover:bg-red-600 hover:text-white px-3 py-1 rounded-md text-xs font-semibold transition-all">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                `;
                rBody.appendChild(tr);
            });
        } else {
            rBody.innerHTML = `<tr><td colspan="5" class="py-8 text-center text-gray-400">Belum ada data rundown untuk acara ini.</td></tr>`;
        }

        // 2. RENDER MOODBOARD GAMBAR (DENGAN ROUTE SERVE STORAGE VERCEL)
        const mGrid = document.getElementById('moodboardGrid');
        mGrid.innerHTML = '';
        if(event.moodboards.length > 0) {
            event.moodboards.forEach(m => {
                const imgUrl = m.url_gambar.startsWith('http') ? m.url_gambar : `/storage/${m.url_gambar}`;
                const card = document.createElement('div');
                card.className = 'border rounded-xl p-4 bg-slate-50 space-y-3 shadow-sm flex flex-col justify-between';
                card.innerHTML = `
                    <div class="space-y-2">
                        <div class="h-44 bg-gray-200 rounded-lg overflow-hidden flex items-center justify-center border border-gray-200">
                            <img src="${imgUrl}" alt="${m.keterangan}" class="w-full h-full object-cover">
                        </div>
                        <p class="text-sm font-semibold text-gray-800 text-center">${m.keterangan}</p>
                    </div>
                    <div class="flex items-center justify-center gap-2 pt-2 border-t border-gray-200">
                        <button type="button" onclick="openEditMoodboardModal(${m.id_moodboard}, ${event.id})" 
                                class="bg-amber-500/10 text-amber-700 hover:bg-amber-500 hover:text-white px-3 py-1 rounded-md text-xs font-semibold transition-all w-1/2 text-center">
                            Edit
                        </button>
                        <form action="{{ url('/admin/klien/moodboard') }}/${m.id_moodboard}" method="POST" class="w-1/2" onsubmit="return confirm('Hapus item moodboard ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-500/10 text-red-600 hover:bg-red-600 hover:text-white px-3 py-1 rounded-md text-xs font-semibold transition-all text-center">
                                Hapus
                            </button>
                        </form>
                    </div>
                `;
                mGrid.appendChild(card);
            });
        } else {
            mGrid.innerHTML = `<div class="col-span-3 py-12 text-center text-gray-400">Belum ada referensi gambar/moodboard.</div>`;
        }

        // 3. RENDER NOTE
        const nAction = document.getElementById('noteActionBox');
        const nContent = document.getElementById('noteContentBox');
        const c = event.catatan;

        document.getElementById('inputListVip').value = c ? (c.list_vip || c.list_VIP || '') : '';
        document.getElementById('inputReqLagu').value = c ? c.req_lagu || '' : '';
        document.getElementById('inputListFotoVvip').value = c ? (c.list_foto_vvip || c.list_foto_VVIP || '') : '';
        document.getElementById('inputCatatanKebutuhan').value = c ? c.catatan_kebutuhan || '' : '';
        document.getElementById('inputPetugasKeluarga').value = c ? c.petugas_keluarga || '' : '';

        if(c) {
            nAction.innerHTML = `
                <button @click="showEditNote = true" class="bg-amber-600 text-white text-xs px-4 py-2.5 rounded-xl font-semibold hover:bg-amber-700 transition-colors flex items-center gap-1.5 shadow-sm">
                    <span>✏️</span> Edit Catatan
                </button>
            `;
            nContent.innerHTML = `
                <div class="grid grid-cols-2 gap-6 text-sm">
                    <div class="border border-gray-200 rounded-xl p-5 bg-slate-50 space-y-1">
                        <h4 class="font-serif-title font-bold text-[#1e314b] text-base">List VIP</h4>
                        <p class="text-gray-700 whitespace-pre-line text-xs leading-relaxed">${c.list_vip || c.list_VIP || '-'}</p>
                    </div>
                    <div class="border border-gray-200 rounded-xl p-5 bg-slate-50 space-y-1">
                        <h4 class="font-serif-title font-bold text-[#1e314b] text-base">Request Lagu</h4>
                        <p class="text-gray-700 whitespace-pre-line text-xs leading-relaxed">${c.req_lagu || '-'}</p>
                    </div>
                    <div class="border border-gray-200 rounded-xl p-5 bg-slate-50 space-y-1">
                        <h4 class="font-serif-title font-bold text-[#1e314b] text-base">List Foto VVIP</h4>
                        <p class="text-gray-700 whitespace-pre-line text-xs leading-relaxed">${c.list_foto_vvip || c.list_foto_VVIP || '-'}</p>
                    </div>
                    <div class="border border-gray-200 rounded-xl p-5 bg-slate-50 space-y-1">
                        <h4 class="font-serif-title font-bold text-[#1e314b] text-base">Catatan Kebutuhan</h4>
                        <p class="text-gray-700 whitespace-pre-line text-xs leading-relaxed">${c.catatan_kebutuhan || '-'}</p>
                    </div>
                    <div class="border border-gray-200 rounded-xl p-5 bg-slate-50 space-y-1 col-span-2">
                        <h4 class="font-serif-title font-bold text-[#1e314b] text-base">Petugas Keluarga</h4>
                        <p class="text-gray-700 whitespace-pre-line text-xs leading-relaxed">${c.petugas_keluarga || '-'}</p>
                    </div>
                </div>
            `;
        } else {
            nAction.innerHTML = `
                <button @click="showAddNote = true" class="bg-[#1e314b] text-white text-xs px-4 py-2.5 rounded-xl font-semibold hover:bg-slate-800 transition-colors flex items-center gap-1.5 shadow-sm">
                    <span>+</span> Tambah Catatan
                </button>
            `;
            nContent.innerHTML = `
                <div class="py-16 text-center text-gray-400 bg-slate-50 rounded-2xl border border-dashed border-gray-300">
                    Belum ada catatan khusus untuk acara ini. Klik tombol <strong>+ Tambah Catatan</strong> di atas untuk menambahkan.
                </div>
            `;
        }
    }

    function openEditRundownModal(idRundown, idPemesanan) {
        const event = rawEvents.find(e => e.id == idPemesanan);
        if(!event) return;
        const rData = event.rundowns.find(r => r.id_rundown == idRundown);
        if(rData) {
            const mainComponent = document.querySelector('main');
            const dataToSet = {
                id_rundown: rData.id_rundown,
                waktu_mulai: rData.waktu_mulai,
                waktu_selesai: rData.waktu_selesai,
                nama_kegiatan: rData.nama_kegiatan,
                penanggung_jawab: rData.penanggung_jawab,
                keterangan: rData.keterangan
            };
            if (window.Alpine) {
                Alpine.$data(mainComponent).editRundownData = dataToSet;
            } else if (mainComponent && mainComponent.__x) {
                mainComponent.__x.$data.editRundownData = dataToSet;
            }
        }
    }

    function openEditMoodboardModal(idMoodboard, idPemesanan) {
        const event = rawEvents.find(e => e.id == idPemesanan);
        if(!event) return;
        const mData = event.moodboards.find(m => m.id_moodboard == idMoodboard);
        if(mData) {
            const mainComponent = document.querySelector('main');
            const dataToSet = {
                id_moodboard: mData.id_moodboard,
                url_gambar: mData.url_gambar,
                keterangan: mData.keterangan
            };
            if (window.Alpine) {
                Alpine.$data(mainComponent).editMoodboardData = dataToSet;
            } else if (mainComponent && mainComponent.__x) {
                mainComponent.__x.$data.editMoodboardData = dataToSet;
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        filterKlienByBulan();
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.min.js" defer></script>
@endsection