@extends('layouts.app')
@section('title', 'Manajemen Kategori')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Manajemen Kategori</h1>
    <a href="{{ route('kategori.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
        <i class="fas fa-plus"></i> Tambah Kategori
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                <tr>
                    <th scope="col" class="px-6 py-3 w-16 text-center">No</th>
                    <th scope="col" class="px-6 py-3">Nama Kategori</th>
                    <th scope="col" class="px-6 py-3">Deskripsi</th>
                    <th scope="col" class="px-6 py-3 text-center">Jumlah Arsip Terkait</th>
                    <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategoris as $index => $k)
                    <tr class="bg-white border-b hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-center font-medium text-gray-900">
                            {{ $kategoris->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4 font-bold text-gray-800">
                            {{ $k->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $k->description ?: '-' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full border border-blue-200 text-xs font-semibold">
                                {{ $k->arsips_count }} Arsip
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right flex justify-end gap-2">
                            <a href="{{ route('kategori.edit', $k) }}" class="text-yellow-600 hover:text-yellow-900 bg-yellow-50 p-2 rounded" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('kategori.destroy', $k) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                    class="p-2 rounded {{ $k->arsips_count > 0 ? 'text-gray-400 bg-gray-100 cursor-not-allowed' : 'text-red-600 hover:text-red-900 bg-red-50' }}" 
                                    title="{{ $k->arsips_count > 0 ? 'Tidak dapat dihapus karena sedang digunakan' : 'Hapus' }}"
                                    {{ $k->arsips_count > 0 ? 'disabled' : '' }}>
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-tags text-3xl mb-3 text-gray-300 block"></i>
                            Belum ada kategori arsip yang ditambahkan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection