@extends('layouts.app')
@section('title', 'Data Arsip')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Data Arsip Desa</h1>
    <a href="{{ route('arsip.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
        <i class="fas fa-plus"></i> Tambah Arsip
    </a>
</div>

{{-- Filter & Search Form --}}
<div class="bg-white p-4 rounded-xl shadow mb-6">
    <form method="GET" action="{{ route('arsip.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
        <div class="md:col-span-2">
            <label class="block text-xs font-medium text-gray-500 mb-1">Cari (Judul/No. Surat/Pengirim)</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik kata kunci..."
                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>
        
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Kategori</label>
            <select name="category_id" class="w-full py-2 px-3 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $k)
                    <option value="{{ $k->id }}" {{ request('category_id') == $k->id ? 'selected' : '' }}>
                        {{ $k->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Dari Tanggal</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}"
                class="w-full py-2 px-3 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="flex gap-2">
            <div class="flex-1">
                <label class="block text-xs font-medium text-gray-500 mb-1">Sampai Tanggal</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}"
                    class="w-full py-2 px-3 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-gray-800 text-white px-3 py-2 rounded-lg hover:bg-gray-900 transition text-sm">
                    Filter
                </button>
                @if(request()->anyFilled(['search', 'category_id', 'date_from', 'date_to']))
                    <a href="{{ route('arsip.index') }}" class="bg-gray-200 text-gray-700 px-3 py-2 rounded-lg hover:bg-gray-300 transition text-sm ml-2" title="Reset Filters">
                        <i class="fas fa-undo"></i>
                    </a>
                @endif
            </div>
        </div>
    </form>
</div>

{{-- Data Table --}}
<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                <tr>
                    <th scope="col" class="px-6 py-3">No. Surat / Tanggal</th>
                    <th scope="col" class="px-6 py-3">Kategori</th>
                    <th scope="col" class="px-6 py-3">Judul / Perihal</th>
                    <th scope="col" class="px-6 py-3">Penduduk Terkait</th>
                    <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($arsips as $a)
                    <tr class="bg-white border-b hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-mono text-gray-900">{{ $a->archive_number }}</div>
                            <div class="text-xs text-gray-500 mt-1"><i class="far fa-calendar-alt mr-1"></i>{{ $a->document_date->format('d M Y') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-blue-50 text-blue-700 px-2.5 py-0.5 rounded border border-blue-200 text-xs">
                                {{ $a->kategori->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900 line-clamp-2" title="{{ $a->title }}">{{ $a->title }}</div>
                            @if($a->sender_receiver)
                                <div class="text-xs text-gray-500 mt-1"><i class="fas fa-exchange-alt mr-1 text-gray-400"></i>{{ $a->sender_receiver }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($a->penduduk)
                                <div class="text-gray-900">{{ $a->penduduk->name }}</div>
                                <div class="text-xs text-gray-500 font-mono">{{ $a->penduduk->nik }}</div>
                            @else
                                <span class="text-gray-400 text-xs italic">Tidak ada</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('arsip.show', $a) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 p-2 rounded" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('arsip.edit', $a) }}" class="text-yellow-600 hover:text-yellow-900 bg-yellow-50 p-2 rounded" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('arsip.destroy', $a) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus arsip ini beserta filenya?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 p-2 rounded" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                @endif
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                            <i class="fas fa-folder-open text-4xl mb-3 text-gray-300 block"></i>
                            Tidak ada data arsip yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection