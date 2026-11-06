@extends('layouts.admin')

@section('title', 'Penugasan Crew')

@section('content')
<main class="flex-1 p-8 overflow-y-auto space-y-6 bg-[#e9eff6]" x-data="{ showAddModal: false, editData: null }">
    
    <!-- NOTIFIKASI SUKSES / ERROR -->
    @if(session('success'))
    <div class="bg-emerald-600 text-white p-4 rounded-xl shadow-sm text-sm font-medium flex justify-between items-center">
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="font-bold text-lg">&times;</button>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-rose-600 text-white p-4 rounded-xl shadow-sm text-sm font-medium flex justify-between items-center">
        <span>{{ session('error') }}</span>
        <button onclick="this.parentElement.remove()" class="font-bold text-lg">&times;</button>
    </div>
    @endif

    <!-- HEADER BAR: JUDUL & FILTER DROPDOWN TERKONEKSI INTERAKTIF -->
    <div class="flex justify-between items-center bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
        <div>
            <h2 class="font-serif-title text-2xl font-bold text-black">Penugasan Crew</h2>
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
                <select id="filterKlien" onchange="renderTableCrew(this.value)" 
                        class="bg-[#f8fafc] border border-gray-300 text-gray-800 text-xs font-semibold rounded-xl px-4 py-2.5 focus:outline-none focus:border-[#1e314b] shadow-sm min-w-[240px] cursor-pointer">
                </select>
            </div>
        </div>
    </div>

    <!-- AREA KONTEN TABEL CREW -->
    <div id="contentArea" class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 space-y-4 min-h-[420px]">
        <div class="flex justify-between items-center mb-2 border-b pb-4">
            <div>
                <h3 id="tableTitle" class="font-serif-title text-xl font-bold text-black">Tim Crew Bertugas</h3>
                <p id="tableSubtitle" class="text-xs text-gray-500">Tanggal Acara: -</p>
            </div>

            <button @click="showAddModal = true" class="bg-[#1e314b] text-white text-xs px-4 py-2.5 rounded-xl font-semibold hover:bg-slate-800 transition-colors flex items-center gap-1.5 shadow-sm">
                <span>+</span> Penugasan Crew
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-separate border-spacing-y-2">
                <thead>
                    <tr class="font-serif-title font-bold text-black border-b border-gray-200 text-xs uppercase tracking-wider">
                        <th class="py-3 px-4">Nama Crew</th>
                        <th class="py-3 px-4">Username Akun</th>
                        <th class="py-3 px-4">No. HP</th>
                        <th class="py-3 px-4">Jobdesk Acara Ini</th>
                        <th class="py-3 px-4 text-center w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody id="crewTableBody" class="divide-y divide-gray-100 text-gray-800">
                </tbody>
            </table>
        </div>
    </div>

    <!-- AREA EMPTY STATE -->
    <div id="emptyArea" class="hidden bg-white rounded-2xl p-12 text-center border border-gray-100 text-slate-400 text-sm">
        Tidak ditemukan acara pengantin pada bulan terpilih.
    </div>

    <!-- MODAL PENUGASAN CREW -->
    <div x-show="showAddModal" style="display: none;" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md space-y-4 shadow-xl relative" @click.outside="showAddModal = false">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="font-serif-title font-bold text-lg text-black">Tugaskan Crew ke Acara</h3>
                <button @click="showAddModal = false" class="text-gray-400 hover:text-gray-600 font-bold text-xl">&times;</button>
            </div>
            
            <form action="{{ route('admin.crew.store') }}" method="POST" class="space-y-3">
                @csrf
                <input type="hidden" id="modalInputIdPemesanan" name="id_pemesanan" value="">
                
                <div>
                    <label class="text-xs font-semibold text-gray-600 mb-1 block">Pilih Crew</label>
                    <select name="id_crew" required class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                        <option value="">-- Pilih Crew NOMIMOS --</option>
                        @foreach($masterCrew as $c)
                            <option value="{{ $c->id_crew }}">{{ $c->nama_crew }} - Username: {{ $c->user->username ?? '' }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-600 mb-1 block">Jobdesk Acara Ini</label>
                    <select name="jobdesk" required class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                        <option value="Team Leader">Team Leader</option>
                        <option value="Stage Manager">Stage Manager</option>
                        <option value="Bride Assistant">Bride Assistant</option>
                        <option value="WCC (Wedding Content Creator)">WCC (Wedding Content Creator)</option>
                        <option value="IT Man">IT Man</option>
                        <option value="Usher">Usher</option>
                        <option value="Helper">Helper</option>
                        <option value="Buku Tamu">Buku Tamu</option>
                        <option value="Souvenir Specialist">Souvenir Specialist</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t">
                    <button type="button" @click="showAddModal = false" class="px-4 py-2 border rounded-xl text-xs font-semibold text-gray-600">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-[#1e314b] text-white rounded-xl text-xs font-semibold hover:bg-slate-800 transition-colors shadow-sm">
                        Tugaskan Crew
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT PENUGASAN CREW -->
    <div x-show="editData" style="display: none;" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md space-y-4 shadow-xl relative" @click.outside="editData = null">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="font-serif-title font-bold text-lg text-black">Edit Penugasan Crew</h3>
                <button @click="editData = null" class="text-gray-400 hover:text-gray-600 font-bold text-xl">&times;</button>
            </div>
            
            <form :action="`{{ url('/admin/crew') }}/${editData?.id_laporan}`" method="POST" class="space-y-3">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="text-xs font-semibold text-gray-600 mb-1 block">Pilih Crew</label>
                    <select name="id_crew" :value="editData?.id_crew" required class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                        @foreach($masterCrew as $c)
                            <option value="{{ $c->id_crew }}">{{ $c->nama_crew }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-600 mb-1 block">Jobdesk Acara Ini</label>
                    <select name="jobdesk" :value="editData?.jobdesk" required class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                        <option value="Team Leader">Team Leader</option>
                        <option value="Stage Manager">Stage Manager</option>
                        <option value="Bride Assistant">Bride Assistant</option>
                        <option value="WCC (Wedding Content Creator)">WCC (Wedding Content Creator)</option>
                        <option value="IT Man">IT Man</option>
                        <option value="Usher">Usher</option>
                        <option value="Helper">Helper</option>
                        <option value="Buku Tamu">Buku Tamu</option>
                        <option value="Souvenir Specialist">Souvenir Specialist</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t">
                    <button type="button" @click="editData = null" class="px-4 py-2 border rounded-xl text-xs font-semibold text-gray-600">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-[#1e314b] text-white rounded-xl text-xs font-semibold hover:bg-slate-800 transition-colors shadow-sm">
                        Update Penugasan
                    </button>
                </div>
            </form>
        </div>
    </div>

</main>

<!-- SCRIPT FILTERING & EDIT MODAL FIX -->
<script>
    const rawEvents = [
        @foreach($events as $e)
        {
            id: {{ $e->id_pemesanan }},
            bulan: '{{ \Carbon\Carbon::parse($e->tgl_acara)->format("m") }}',
            nama: {!! json_encode(($e->klien->nama_pria ?? '') . ' & ' . ($e->klien->nama_wanita ?? '')) !!},
            tglAcaraFormatted: '{{ \Carbon\Carbon::parse($e->tgl_acara)->translatedFormat("d F Y") }}',
            tglAcaraRaw: '{{ \Carbon\Carbon::parse($e->tgl_acara)->format("d/m/Y") }}',
            lokasi: {!! json_encode($e->lokasi_acara) !!},
            crews: [
                @foreach($e->penugasanCrews as $pc)
                {
                    id_laporan: {{ $pc->id_laporan }},
                    id_crew: {{ $pc->id_crew }},
                    nama_crew: {!! json_encode($pc->crew->nama_crew ?? '-') !!},
                    username: {!! json_encode($pc->crew->user->username ?? '-') !!},
                    no_hp: {!! json_encode($pc->crew->no_hp ?? '-') !!},
                    jobdesk: {!! json_encode($pc->jobdesk) !!}
                },
                @endforeach
            ]
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

            renderTableCrew(filteredEvents[0].id);
        } else {
            const opt = document.createElement('option');
            opt.value = '';
            opt.innerText = '-- Tidak Ada Pengantin di Bulan Ini --';
            selectKlien.appendChild(opt);

            document.getElementById('contentArea').classList.add('hidden');
            document.getElementById('emptyArea').classList.remove('hidden');
        }
    }

    function renderTableCrew(idPemesanan) {
        const event = rawEvents.find(e => e.id == idPemesanan);
        if(!event) return;

        document.getElementById('modalInputIdPemesanan').value = event.id;
        document.getElementById('tableTitle').innerText = 'Tim Crew Bertugas - ' + event.nama;
        document.getElementById('tableSubtitle').innerText = `Tanggal Acara: ${event.tglAcaraFormatted} (${event.lokasi})`;

        const tbody = document.getElementById('crewTableBody');
        tbody.innerHTML = '';

        if(event.crews.length > 0) {
            event.crews.forEach(pc => {
                const tr = document.createElement('tr');
                tr.className = 'hover:bg-slate-50 transition-colors';
                tr.innerHTML = `
                    <td class="py-3.5 px-4 font-bold text-black">${pc.nama_crew}</td>
                    <td class="py-3.5 px-4 text-xs font-mono text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-md w-fit font-semibold">${pc.username}</td>
                    <td class="py-3.5 px-4 text-xs text-gray-600">${pc.no_hp}</td>
                    <td class="py-3.5 px-4 font-bold text-[#1e314b]">${pc.jobdesk}</td>
                    <td class="py-3.5 px-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button type="button" onclick="openEditCrewModal(${pc.id_laporan}, ${event.id})" 
                                    class="bg-amber-500/10 text-amber-700 hover:bg-amber-500 hover:text-white px-3 py-1 rounded-md text-xs font-semibold transition-all">
                                Edit
                            </button>
                            <form action="{{ url('/admin/crew') }}/${pc.id_laporan}" method="POST" class="inline" onsubmit="return confirm('Batalkan penugasan crew ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500/10 text-red-600 hover:bg-red-600 hover:text-white px-3 py-1 rounded-md text-xs font-semibold transition-all">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        } else {
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="py-12 text-center text-gray-400 text-sm">Belum ada crew yang ditugaskan untuk acara ini.</td>
                </tr>
            `;
        }
    }

    // FUNGSI MEMASUKKAN DATA KE ALPINE STATE EDITDATA
    function openEditCrewModal(idLaporan, idPemesanan) {
        const event = rawEvents.find(e => e.id == idPemesanan);
        if(!event) return;
        const crewData = event.crews.find(c => c.id_laporan == idLaporan);
        if(crewData) {
            // Mengakses instance Alpine.js pada tag <main>
            const mainComponent = document.querySelector('main');
            if (window.Alpine) {
                Alpine.$data(mainComponent).editData = {
                    id_laporan: crewData.id_laporan,
                    id_crew: crewData.id_crew,
                    jobdesk: crewData.jobdesk
                };
            } else if (mainComponent && mainComponent.__x) {
                mainComponent.__x.$data.editData = {
                    id_laporan: crewData.id_laporan,
                    id_crew: crewData.id_crew,
                    jobdesk: crewData.jobdesk
                };
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        filterKlienByBulan();
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.min.js" defer></script>
@endsection