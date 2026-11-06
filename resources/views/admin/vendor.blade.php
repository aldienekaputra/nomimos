@extends('layouts.admin')

@section('title', 'Vendor')

@section('content')
<main class="flex-1 p-8 overflow-y-auto space-y-6 bg-[#e9eff6]" x-data="{ showAddModal: false, editData: null }">
    
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
            <h2 class="font-serif-title text-2xl font-bold text-black">Vendor Acara</h2>
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
                <select id="filterKlien" onchange="renderTableVendor(this.value)" 
                        class="bg-[#f8fafc] border border-gray-300 text-gray-800 text-xs font-semibold rounded-xl px-4 py-2.5 focus:outline-none focus:border-[#1e314b] shadow-sm min-w-[240px] cursor-pointer">
                </select>
            </div>
        </div>
    </div>

    <!-- AREA KONTEN TABEL VENDOR -->
    <div id="contentArea" class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 space-y-4 min-h-[420px]">
        <div class="flex justify-between items-center mb-2 border-b pb-4">
            <div>
                <h3 id="tableTitle" class="font-serif-title text-xl font-bold text-black">Daftar Vendor</h3>
                <p id="tableSubtitle" class="text-xs text-gray-500">Tanggal Acara: -</p>
            </div>
            
            <button @click="showAddModal = true" class="bg-[#1e314b] text-white text-xs px-4 py-2.5 rounded-xl font-semibold hover:bg-slate-800 transition-colors flex items-center gap-1.5 shadow-sm">
                <span>+</span> Tambah Vendor
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-separate border-spacing-y-2">
                <thead>
                    <tr class="font-serif-title font-bold text-black border-b border-gray-200 text-xs uppercase tracking-wider">
                        <th class="py-3 px-4">Nama Vendor</th>
                        <th class="py-3 px-4">Kategori</th>
                        <th class="py-3 px-4">Nominal DP</th>
                        <th class="py-3 px-4">Nominal Pelunasan</th>
                        <th class="py-3 px-4">Total</th>
                        <th class="py-3 px-4">Tgl Bayar</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-center w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody id="vendorTableBody" class="divide-y divide-gray-100 text-gray-800">
                </tbody>
            </table>
        </div>
    </div>

    <!-- AREA EMPTY STATE -->
    <div id="emptyArea" class="hidden bg-white rounded-2xl p-12 text-center border border-gray-100 text-slate-400 text-sm">
        Tidak ditemukan acara pengantin pada bulan terpilih.
    </div>

    <!-- MODAL ADD VENDOR -->
    <div x-show="showAddModal" style="display: none;" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4" x-data="{ isVendorBaru: true }">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md space-y-4 shadow-xl relative" @click.outside="showAddModal = false">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="font-serif-title font-bold text-lg text-black">Tambah Vendor ke Acara</h3>
                <button @click="showAddModal = false" class="text-gray-400 hover:text-gray-600 font-bold text-xl">&times;</button>
            </div>
            
            <form action="{{ route('admin.vendor.store') }}" method="POST" class="space-y-3">
                @csrf
                <input type="hidden" id="modalInputIdPemesanan" name="id_pemesanan" value="">
                
                <!-- TOGGLE PILIHAN VENDOR -->
                <div class="flex gap-4 border-b pb-2 text-xs font-semibold">
                    <button type="button" @click="isVendorBaru = true" :class="{ 'text-[#1e314b] border-b-2 border-[#1e314b] pb-1': isVendorBaru, 'text-gray-400': !isVendorBaru }">
                        + Input Vendor Baru
                    </button>
                    <button type="button" @click="isVendorBaru = false" :class="{ 'text-[#1e314b] border-b-2 border-[#1e314b] pb-1': !isVendorBaru, 'text-gray-400': isVendorBaru }">
                        Pilih Dari Master Vendor
                    </button>
                </div>

                <!-- FORM INPUT VENDOR BARU -->
                <template x-if="isVendorBaru">
                    <div class="space-y-2">
                        <div>
                            <label class="text-xs font-semibold text-gray-600 mb-1 block">Nama Vendor Baru</label>
                            <input type="text" name="nama_vendor_baru" placeholder="misal: Buana Decor / Lotus MUA" class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-600 mb-1 block">Kategori Vendor</label>
                            <select name="kategori_vendor_baru" class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                                <option value="Catering">Catering</option>
                                <option value="Dekorasi">Dekorasi</option>
                                <option value="MUA & Attire">MUA & Attire</option>
                                <option value="Foto & Video">Foto & Video</option>
                                <option value="Entertainment">Entertainment</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-600 mb-1 block">No. HP Vendor (Opsional)</label>
                            <input type="text" name="no_hp_baru" placeholder="08xxxxxxxxxx" class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                        </div>
                    </div>
                </template>

                <!-- FORM PILIH MASTER VENDOR -->
                <template x-if="!isVendorBaru">
                    <div>
                        <label class="text-xs font-semibold text-gray-600 mb-1 block">Pilih Master Vendor</label>
                        <select name="id_vendor" class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                            <option value="">-- Pilih Vendor --</option>
                            @foreach($masterVendor as $mv)
                                <option value="{{ $mv->id_vendor }}">{{ $mv->nama_vendor }} ({{ $mv->kategori_vendor }})</option>
                            @endforeach
                        </select>
                    </div>
                </template>

                <!-- NOMINAL & TANGGAL -->
                <div class="grid grid-cols-2 gap-2 pt-2 border-t">
                    <div>
                        <label class="text-xs font-semibold text-gray-600 mb-1 block">Nominal DP (Rp)</label>
                        <input type="number" name="nominal_dp" value="0" required class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-600 mb-1 block">Nominal Pelunasan (Rp)</label>
                        <input type="number" name="nominal_pelunasan" value="0" required class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                    </div>
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-600 mb-1 block">Tanggal Bayar</label>
                    <input type="date" name="tgl_bayar" value="{{ date('Y-m-d') }}" required class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-600 mb-1 block">Status Pembayaran</label>
                    <select name="status_bayar_vendor" required class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                        <option value="Pending">Pending</option>
                        <option value="Confirmed">Lunas (Confirmed)</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t">
                    <button type="button" @click="showAddModal = false" class="px-4 py-2 border rounded-xl text-xs font-semibold text-gray-600">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-[#1e314b] text-white rounded-xl text-xs font-semibold hover:bg-slate-800 transition-colors shadow-sm">Simpan Vendor</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT VENDOR -->
    <div x-show="editData" style="display: none;" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md space-y-4 shadow-xl relative" @click.outside="editData = null">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="font-serif-title font-bold text-lg text-black">Edit Data Vendor</h3>
                <button @click="editData = null" class="text-gray-400 hover:text-gray-600 font-bold text-xl">&times;</button>
            </div>

            <form :action="`{{ url('/admin/vendor') }}/${editData?.id_pay_vendor}`" method="POST" class="space-y-3">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="text-xs font-semibold text-gray-600 mb-1 block">Nama Vendor</label>
                    <input type="text" name="nama_vendor" :value="editData?.nama_vendor" required class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-600 mb-1 block">Kategori Vendor</label>
                    <select name="kategori_vendor" :value="editData?.kategori_vendor" required class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                        <option value="Catering">Catering</option>
                        <option value="Dekorasi">Dekorasi</option>
                        <option value="MUA & Attire">MUA & Attire</option>
                        <option value="Foto & Video">Foto & Video</option>
                        <option value="Entertainment">Entertainment</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="text-xs font-semibold text-gray-600 mb-1 block">Nominal DP (Rp)</label>
                        <input type="number" name="nominal_dp" :value="editData?.nominal_dp" required class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-600 mb-1 block">Nominal Pelunasan (Rp)</label>
                        <input type="number" name="nominal_pelunasan" :value="editData?.nominal_pelunasan" required class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                    </div>
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-600 mb-1 block">Tanggal Bayar</label>
                    <input type="date" name="tgl_bayar" :value="editData?.tgl_bayar" required class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-600 mb-1 block">Status Pembayaran</label>
                    <select name="status_bayar_vendor" :value="editData?.status_bayar_vendor" required class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                        <option value="Pending">Pending</option>
                        <option value="Confirmed">Lunas (Confirmed)</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t">
                    <button type="button" @click="editData = null" class="px-4 py-2 border rounded-xl text-xs font-semibold text-gray-600">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-[#1e314b] text-white rounded-xl text-xs font-semibold hover:bg-slate-800 transition-colors shadow-sm">Update Vendor</button>
                </div>
            </form>
        </div>
    </div>

</main>

<!-- SCRIPT FILTERING INTERAKTIF & TRIGGER EDIT MODAL -->
<script>
    const rawEvents = [
        @foreach($events as $e)
        {
            id: {{ $e->id_pemesanan }},
            bulan: '{{ \Carbon\Carbon::parse($e->tgl_acara)->format("m") }}',
            nama: {!! json_encode(($e->klien->nama_pria ?? '') . ' & ' . ($e->klien->nama_wanita ?? '')) !!},
            tglAcaraFormatted: '{{ \Carbon\Carbon::parse($e->tgl_acara)->translatedFormat("d F Y") }}',
            tglAcaraRaw: '{{ \Carbon\Carbon::parse($e->tgl_acara)->format("d/m/Y") }}',
            vendors: [
                @foreach($e->pembayaranVendors as $pv)
                {
                    id_pay_vendor: {{ $pv->id_pay_vendor }},
                    nama_vendor: {!! json_encode($pv->vendor->nama_vendor ?? '-') !!},
                    kategori_vendor: {!! json_encode($pv->vendor->kategori_vendor ?? '-') !!},
                    nominal_dp: {{ $pv->nominal_dp ?? 0 }},
                    nominal_pelunasan: {{ $pv->nominal_pelunasan ?? 0 }},
                    tgl_bayar: '{{ $pv->tgl_bayar }}',
                    tgl_bayar_formatted: '{{ \Carbon\Carbon::parse($pv->tgl_bayar)->format("d/m/Y") }}',
                    status_bayar_vendor: '{{ $pv->status_bayar_vendor }}'
                },
                @endforeach
            ]
        },
        @endforeach
    ];

    function formatRupiah(num) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(num);
    }

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

            renderTableVendor(filteredEvents[0].id);
        } else {
            const opt = document.createElement('option');
            opt.value = '';
            opt.innerText = '-- Tidak Ada Pengantin di Bulan Ini --';
            selectKlien.appendChild(opt);

            document.getElementById('contentArea').classList.add('hidden');
            document.getElementById('emptyArea').classList.remove('hidden');
        }
    }

    function renderTableVendor(idPemesanan) {
        const event = rawEvents.find(e => e.id == idPemesanan);
        if(!event) return;

        document.getElementById('modalInputIdPemesanan').value = event.id;
        document.getElementById('tableTitle').innerText = 'Daftar Vendor - ' + event.nama;
        document.getElementById('tableSubtitle').innerText = 'Tanggal Acara: ' + event.tglAcaraFormatted;

        const tbody = document.getElementById('vendorTableBody');
        tbody.innerHTML = '';

        if(event.vendors.length > 0) {
            event.vendors.forEach(pv => {
                const total = pv.nominal_dp + pv.nominal_pelunasan;
                const statusBadge = pv.status_bayar_vendor === 'Confirmed' 
                    ? `<span class="bg-emerald-100 text-emerald-800 text-xs px-2.5 py-1 rounded-full font-semibold">Lunas</span>`
                    : `<span class="bg-amber-100 text-amber-800 text-xs px-2.5 py-1 rounded-full font-semibold">Pending</span>`;

                const tr = document.createElement('tr');
                tr.className = 'hover:bg-slate-50 transition-colors';
                tr.innerHTML = `
                    <td class="py-3 px-4 font-bold text-black">${pv.nama_vendor}</td>
                    <td class="py-3 px-4 text-xs text-gray-600">${pv.kategori_vendor}</td>
                    <td class="py-3 px-4 font-medium text-gray-700">${formatRupiah(pv.nominal_dp)}</td>
                    <td class="py-3 px-4 font-medium text-gray-700">${formatRupiah(pv.nominal_pelunasan)}</td>
                    <td class="py-3 px-4 font-bold text-[#1e314b]">${formatRupiah(total)}</td>
                    <td class="py-3 px-4 text-xs text-gray-600">${pv.tgl_bayar_formatted}</td>
                    <td class="py-3 px-4 text-center">${statusBadge}</td>
                    <td class="py-3 px-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button type="button" onclick="openEditVendorModal(${pv.id_pay_vendor}, ${event.id})" 
                                    class="bg-amber-500/10 text-amber-700 hover:bg-amber-500 hover:text-white px-3 py-1 rounded-md text-xs font-semibold transition-all">
                                Edit
                            </button>
                            <form action="{{ url('/admin/vendor') }}/${pv.id_pay_vendor}" method="POST" class="inline" onsubmit="return confirm('Hapus vendor ini dari acara?')">
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
                    <td colspan="8" class="py-8 text-center text-gray-400">Belum ada vendor terdaftar untuk acara ini.</td>
                </tr>
            `;
        }
    }

    // FUNGSI FIXED POPULATE EDIT VENDOR TO ALPINE DATA
    function openEditVendorModal(idPayVendor, idPemesanan) {
        const event = rawEvents.find(e => e.id == idPemesanan);
        if(!event) return;
        const vendorData = event.vendors.find(v => v.id_pay_vendor == idPayVendor);
        if(vendorData) {
            const mainComponent = document.querySelector('main');
            if (window.Alpine) {
                Alpine.$data(mainComponent).editData = {
                    id_pay_vendor: vendorData.id_pay_vendor,
                    nama_vendor: vendorData.nama_vendor,
                    kategori_vendor: vendorData.kategori_vendor,
                    nominal_dp: vendorData.nominal_dp,
                    nominal_pelunasan: vendorData.nominal_pelunasan,
                    tgl_bayar: vendorData.tgl_bayar,
                    status_bayar_vendor: vendorData.status_bayar_vendor
                };
            } else if (mainComponent && mainComponent.__x) {
                mainComponent.__x.$data.editData = {
                    id_pay_vendor: vendorData.id_pay_vendor,
                    nama_vendor: vendorData.nama_vendor,
                    kategori_vendor: vendorData.kategori_vendor,
                    nominal_dp: vendorData.nominal_dp,
                    nominal_pelunasan: vendorData.nominal_pelunasan,
                    tgl_bayar: vendorData.tgl_bayar,
                    status_bayar_vendor: vendorData.status_bayar_vendor
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