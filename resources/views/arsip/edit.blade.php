@extends('layouts.app')
@section('title', 'Edit Arsip')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Data Arsip</h1>
        <a href="{{ route('arsip.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <form method="POST" action="{{ route('arsip.update', $arsip) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Nomor Surat *</label>
                    <input type="text" name="archive_number" value="{{ old('archive_number', $arsip->archive_number) }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                    @error('archive_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Tanggal Dokumen *</label>
                    <input type="date" name="document_date" value="{{ old('document_date', $arsip->document_date->format('Y-m-d')) }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                    @error('document_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-1">Judul / Perihal *</label>
                    <input type="text" name="title" value="{{ old('title', $arsip->title) }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                    @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Kategori *</label>
                    <select name="category_id" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $k)
                            <option value="{{ $k->id }}" {{ old('category_id', $arsip->category_id) == $k->id ? 'selected' : '' }}>
                                {{ $k->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Pengirim / Penerima</label>
                    <input type="text" name="sender_receiver" value="{{ old('sender_receiver', $arsip->sender_receiver) }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-1">Ganti File Dokumen
                        <span class="text-gray-400 font-normal">(Opsional. Biarkan kosong jika tidak ingin mengganti file)</span>
                    </label>
                    <div class="flex items-center gap-3">
                        <input type="file" name="file" accept=".pdf,.jpg,.jpeg,.png"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        <a href="{{ route('arsip.download', $arsip) }}" class="shrink-0 bg-blue-50 text-blue-600 px-3 py-2 rounded border border-blue-200 text-sm hover:bg-blue-100">
                            <i class="fas fa-file-download mr-1"></i> File Saat Ini
                        </a>
                    </div>
                    @error('file')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-1">Catatan Tambahan</label>
                    <textarea name="notes" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2">{{ old('notes', $arsip->notes) }}</textarea>
                </div>
            </div>

            <div class="pt-4 flex justify-end gap-3 border-t mt-6">
                <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2 font-medium">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection