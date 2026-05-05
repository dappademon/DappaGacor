@extends('layouts.app')
@section('title', 'Edit Kategori')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Kategori</h1>
        <a href="{{ route('kategori.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        {{-- Gunakan method PUT untuk proses update --}}
        <form method="POST" action="{{ route('kategori.update', $kategori->id) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori *</label>
                <input type="text" name="name" id="name" 
                    value="{{ old('name', $kategori->name) }}" {{-- Menampilkan data lama jika gagal validasi, atau data dari DB[cite: 1] --}}
                    required maxlength="50" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                <textarea name="description" id="description" rows="3" 
                    placeholder="Tambahkan keterangan kategori di sini..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('description', $kategori->description) }}</textarea>
                @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="pt-4 flex justify-end gap-3 border-t mt-6">
                <button type="submit" class="px-5 py-2.5 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition flex items-center gap-2">
                    <i class="fas fa-edit"></i> Perbarui Kategori
                </button>
            </div>
        </form>
    </div>
</div>
@endsection