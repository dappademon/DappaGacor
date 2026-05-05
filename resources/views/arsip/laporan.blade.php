@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;">
    
    <!-- Header Halaman -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <!-- Meniru style tulisan "Dashboard" di kiri atas -->
        <h3 style="color: #1a202c; font-weight: 700; margin: 0; font-size: 1.5rem;">Laporan Arsip</h3>
        <!-- Meniru style warna tombol sidebar/header -->
        <button onclick="window.print()" class="btn" style="background-color: #171f38; color: white; border-radius: 6px; padding: 6px 16px; font-size: 0.875rem; border: none;">
            Cetak Laporan
        </button>
    </div>

    <!-- Kotak Card (Meniru persis kotak "Arsip Terbaru" & "Arsip per Kategori") -->
    <div class="card" style="border: 1px solid #edf2f7; border-radius: 8px; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); background-color: white;">
        <div class="card-body p-4">
            
            <div class="table-responsive">
                <table class="table" style="width: 100%; margin-bottom: 0; color: #4a5568; font-size: 0.9rem;">
                    <!-- Bagian Header Tabel (Background abu-abu sangat muda seperti di gambar) -->
                    <thead style="background-color: #f8fafc;">
                        <tr>
                            <th style="padding: 12px 16px; border: none; font-weight: 700; color: #1a202c; text-align: left;">No. Surat</th>
                            <th style="padding: 12px 16px; border: none; font-weight: 700; color: #1a202c; text-align: left;">Judul</th>
                            <th style="padding: 12px 16px; border: none; font-weight: 700; color: #1a202c; text-align: left;">Kategori</th>
                            <th style="padding: 12px 16px; border: none; font-weight: 700; color: #1a202c; text-align: left;">Penduduk</th>
                            <th style="padding: 12px 16px; border: none; font-weight: 700; color: #1a202c; text-align: left;">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($arsips as $arsip)
                            <!-- Meniru style baris tabel -->
                            <tr style="border-bottom: 1px solid #edf2f7;">
                                <td style="padding: 16px; border-top: none; color: #1a202c; font-weight: 600;">{{ $arsip->archive_number ?? '-' }}</td>
                                <td style="padding: 16px; border-top: none;">{{ $arsip->title }}</td>
                                <td style="padding: 16px; border-top: none;">{{ $arsip->kategori->name ?? '-' }}</td>
                                <td style="padding: 16px; border-top: none;">{{ $arsip->penduduk->name ?? '-' }}</td>
                                <td style="padding: 16px; border-top: none;">{{ $arsip->document_date->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <!-- Meniru persis teks kosong "Belum ada arsip" yang ada di gambar -->
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 24px; color: #a0aec0; border-top: none; font-size: 0.9rem;">
                                    Belum ada arsip
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- CSS tambahan agar hasil cetak rapi -->
<style>
    @media print {
        body * { visibility: hidden; }
        .card, .card * { visibility: visible; }
        .card { position: absolute; left: 0; top: 0; width: 100%; border: none !important; box-shadow: none !important; padding: 0 !important;}
        button, .sidebar, .navbar { display: none !important; }
    }
</style>
@endsection