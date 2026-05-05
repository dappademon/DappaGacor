@extends('layouts.app')
@section('title', 'Detail Arsip')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detail Arsip</h1>
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
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Metadata Kiri --}}
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-start justify-between border-b pb-4 mb-4">
                    <div>
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded border border-blue-200">
                            {{ $arsip->kategori->name }}
                        </span>
                        <h2 class="text-xl font-bold text-gray-900 mt-2">{{ $arsip->title }}</h2>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500 mb-1">Nomor Surat</p>
                        <p class="font-mono font-medium text-gray-900">{{ $arsip->archive_number }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 mb-1">Tanggal Dokumen</p>
                        <p class="font-medium text-gray-900">{{ $arsip->document_date->format('d F Y') }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-gray-500 mb-1">Pengirim / Penerima</p>
                        <p class="font-medium text-gray-900">{{ $arsip->sender_receiver ?: '-' }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-gray-500 mb-1">Catatan Tambahan</p>
                        <div class="bg-gray-50 p-3 rounded border text-gray-700 whitespace-pre-line">
                            {{ $arsip->notes ?: 'Tidak ada catatan.' }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Dokumen File Preview/Download --}}
            <div class="bg-white rounded-xl shadow p-6 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="bg-red-100 text-red-600 p-3 rounded-lg">
                        <i class="fas fa-file-pdf text-2xl"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">File Dokumen</p>
                        <p class="text-xs text-gray-500">PDF/Image yang diunggah</p>
                    </div>
                </div>
                <a href="{{ route('arsip.download', $arsip) }}" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                    <i class="fas fa-download"></i> Unduh File
                </a>
            </div>
        </div>

        {{-- Sidebar Kanan --}}
        <div class="space-y-6">
            {{-- Data Penduduk Terkait --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="font-bold text-gray-800 border-b pb-2 mb-3">
                    <i class="fas fa-user-tag text-blue-500 mr-2"></i>Penduduk Terkait
                </h3>
                @if($arsip->penduduk)
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-gray-500 text-xs">Nama</p>
                            <p class="font-medium text-gray-900">{{ $arsip->penduduk->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs">NIK</p>
                            <p class="font-mono text-gray-900">{{ $arsip->penduduk->nik }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs">Alamat</p>
                            <p class="text-gray-900">{{ $arsip->penduduk->address }}</p>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-user-slash text-gray-300 text-3xl mb-2 block"></i>
                        <p class="text-gray-500 text-sm">Tidak ada penduduk yang ditautkan pada arsip ini.</p>
                    </div>
                @endif
            </div>

            {{-- Info Sistem --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="font-bold text-gray-800 border-b pb-2 mb-3">
                    <i class="fas fa-info-circle text-blue-500 mr-2"></i>Info Sistem
                </h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-gray-500 text-xs">Diunggah Oleh</p>
                        <p class="font-medium text-gray-900 flex items-center gap-2">
                            <i class="fas fa-user-circle text-gray-400"></i>
                            {{ $arsip->user->name }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Waktu Upload</p>
                        <p class="text-gray-900">{{ $arsip->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Terakhir Diupdate</p>
                        <p class="text-gray-900">{{ $arsip->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection