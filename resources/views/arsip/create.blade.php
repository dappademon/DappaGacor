@extends('layouts.app') 
@section('title', 'Tambah Arsip')
 
@section('content')
<div class="max-w-3xl">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Arsip Baru</h1>
 
    <form id="formArsip" method="POST" action="{{ route('arsip.store') }}"
          enctype="multipart/form-data" class="space-y-6">
        @csrf
 
        {{-- BAGIAN 1: DATA ARSIP --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="font-semibold text-gray-700 mb-4 border-b pb-2">
                <i class="fas fa-file-alt mr-2 text-blue-600"></i>Data Arsip
            </h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Nomor Surat *</label>
                    <input type="text" name="archive_number" value="{{ old('archive_number') }}"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
                        placeholder="Contoh: 001/DS/2024" required>
                    @error('archive_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Tanggal Dokumen *</label>
                    <input type="date" name="document_date" value="{{ old('document_date') }}"
                        class="w-full border rounded-lg px-3 py-2" required>
                    @error('document_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-1">Judul / Perihal *</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        class="w-full border rounded-lg px-3 py-2" required>
                    @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Kategori *</label>
                    <select name="category_id" class="w-full border rounded-lg px-3 py-2" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $k)
                        <option value="{{ $k->id }}" {{ old('category_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Pengirim / Penerima</label>
                    <input type="text" name="sender_receiver" value="{{ old('sender_receiver') }}"
                        class="w-full border rounded-lg px-3 py-2">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-1">Upload File *
                        <span class="text-gray-400 font-normal">(PDF/JPG/PNG, maks 10MB)</span>
                    </label>
                    <input type="file" name="file" accept=".pdf,.jpg,.jpeg,.png"
                        class="w-full border rounded-lg px-3 py-2" required>
                    @error('file')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-1">Catatan Tambahan</label>
                    <textarea name="notes" rows="3" class="w-full border rounded-lg px-3 py-2">{{ old('notes') }}</textarea>
                </div>
            </div>
        </div>
 
        {{-- BAGIAN 2: DATA PENDUDUK (Flow Map NIK) --}}
        <div class="bg-white rounded-xl shadow p-6" x-data="nikHandler()">
            <h2 class="font-semibold text-gray-700 mb-4 border-b pb-2">
                <i class="fas fa-user mr-2 text-blue-600"></i>Data Penduduk (Opsional)
            </h2>
 
            {{-- Input NIK + Tombol Cari --}}
            <div class="flex gap-3 mb-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-600 mb-1">NIK (16 digit)</label>
                    <input type="text" x-model="nik" @input="reset()"
                        maxlength="16" placeholder="Masukkan 16 digit NIK..."
                        class="w-full border rounded-lg px-3 py-2 font-mono">
                </div>
                <div class="flex items-end">
                    <button type="button" @click="cariNik()"
                        class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700"
                        :disabled="nik.length !== 16">
                        <i class="fas fa-search mr-1"></i>Cari NIK
                    </button>
                </div>
            </div>
 
            {{-- Loading --}}
            <div x-show="loading" class="text-center py-4 text-blue-500">
                <i class="fas fa-spinner fa-spin mr-2"></i>Mencari data penduduk...
            </div>
 
            {{-- DITEMUKAN: Tampil data penduduk --}}
            <div x-show="found" class="bg-green-50 border border-green-200 rounded-lg p-4">
                <p class="text-green-700 font-medium mb-2">
                    <i class="fas fa-check-circle mr-1"></i>Penduduk ditemukan!
                </p>
                <div class="grid grid-cols-2 gap-2 text-sm text-gray-700">
                    <div><span class="font-medium">Nama:</span> <span x-text="penduduk.name"></span></div>
                    <div><span class="font-medium">NIK:</span> <span x-text="penduduk.nik" class="font-mono"></span></div>
                    <div class="col-span-2"><span class="font-medium">Alamat:</span> <span x-text="penduduk.address"></span></div>
                </div>
                <input type="hidden" name="resident_id" :value="penduduk.id">
            </div>
 
            {{-- TIDAK DITEMUKAN: Form penduduk baru --}}
            <div x-show="notFound" class="border border-yellow-200 rounded-lg p-4 bg-yellow-50">
                <p class="text-yellow-700 font-medium mb-3">
                    <i class="fas fa-exclamation-triangle mr-1"></i>
                    NIK tidak ditemukan. Isi data penduduk baru:
                </p>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium mb-1">NIK *</label>
                        <input type="text" x-model="newPenduduk.nik" :value="nik"
                            class="w-full border rounded px-3 py-2 font-mono text-sm" maxlength="16">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Nama Lengkap *</label>
                        <input type="text" x-model="newPenduduk.name"
                            class="w-full border rounded px-3 py-2 text-sm">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium mb-1">Alamat (RT/RW) *</label>
                        <textarea x-model="newPenduduk.address" rows="2"
                            class="w-full border rounded px-3 py-2 text-sm"></textarea>
                    </div>
                    <div class="col-span-2">
                        <button type="button" @click="simpanPenduduk()"
                            class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 text-sm">
                            <i class="fas fa-save mr-1"></i>Simpan & Gunakan Data Ini
                        </button>
                    </div>
                </div>
            </div>
 
            {{-- Penduduk berhasil didaftarkan --}}
            <div x-show="saved" class="bg-green-50 border border-green-300 rounded-lg p-3 mt-2">
                <p class="text-green-700 text-sm">
                    <i class="fas fa-check mr-1"></i>
                    Penduduk baru berhasil didaftarkan dan dihubungkan ke arsip ini.
                </p>
                <input type="hidden" name="resident_id" :value="savedId">
            </div>
        </div>
 
        <div class="flex gap-3">
            <button type="submit"
                class="bg-blue-600 text-white px-8 py-2.5 rounded-lg hover:bg-blue-700 font-medium">
                <i class="fas fa-save mr-2"></i>Simpan Arsip
            </button>
            <a href="{{ route('arsip.index') }}"
                class="bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg hover:bg-gray-300">
                Batal
            </a>
        </div>
    </form>
</div>
 
@push('scripts')
<script>
function nikHandler() {
    return {
        nik: '',
        loading: false,
        found: false,
        notFound: false,
        saved: false,
        savedId: null,
        penduduk: {},
        newPenduduk: { nik: '', name: '', address: '' },
 
        reset() {
            this.found = false; this.notFound = false; this.saved = false;
            this.penduduk = {}; this.savedId = null;
        },
 
        async cariNik() {
            if (this.nik.length !== 16) return;
            this.loading = true; this.reset();
            try {
                const res = await fetch(`/api/penduduk/cari?nik=${this.nik}`, {
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }
                });
                const data = await res.json();
                if (data.found) {
                    this.penduduk = data; this.found = true;
                } else {
                    this.newPenduduk.nik = this.nik; this.notFound = true;
                }
            } catch(e) { alert('Gagal mencari NIK.'); }
            finally { this.loading = false; }
        },
 
        async simpanPenduduk() {
            const { nik, name, address } = this.newPenduduk;
            if (!nik || !name || !address) { alert('Semua field wajib diisi!'); return; }
            try {
                const res = await fetch('/api/penduduk', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify({ nik, name, address })
                });
                const data = await res.json();
                if (data.success) {
                    this.savedId = data.id;
                    this.notFound = false; this.saved = true;
                }
            } catch(e) { alert('Gagal menyimpan penduduk.'); }
        }
    }
}
</script>
@endpush
@endsection
