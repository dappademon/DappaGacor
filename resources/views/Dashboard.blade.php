@extends('layouts.app')
@section('title', 'Dashboard')
 
@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard</h1>
 
{{-- Stats Cards --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-blue-600 text-white rounded-xl p-5 shadow">
        <p class="text-sm opacity-80">Total Arsip</p>
        <p class="text-4xl font-bold">{{ $stats['total_arsip'] }}</p>
        <i class="fas fa-file-alt text-3xl opacity-30 float-right -mt-8"></i>
    </div>
    <div class="bg-green-600 text-white rounded-xl p-5 shadow">
        <p class="text-sm opacity-80">Total Kategori</p>
        <p class="text-4xl font-bold">{{ $stats['total_kategori'] }}</p>
        <i class="fas fa-tags text-3xl opacity-30 float-right -mt-8"></i>
    </div>
    <div class="bg-purple-600 text-white rounded-xl p-5 shadow">
        <p class="text-sm opacity-80">Data Penduduk</p>
        <p class="text-4xl font-bold">{{ $stats['total_penduduk'] }}</p>
        <i class="fas fa-users text-3xl opacity-30 float-right -mt-8"></i>
    </div>
    <div class="bg-orange-500 text-white rounded-xl p-5 shadow">
        <p class="text-sm opacity-80">Total User</p>
        <p class="text-4xl font-bold">{{ $stats['total_user'] }}</p>
        <i class="fas fa-user-tie text-3xl opacity-30 float-right -mt-8"></i>
    </div>
</div>
 
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Arsip Terbaru --}}
    <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Arsip Terbaru</h2>
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-3 py-2">No. Surat</th>
                    <th class="text-left px-3 py-2">Judul</th>
                    <th class="text-left px-3 py-2">Kategori</th>
                    <th class="text-left px-3 py-2">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($arsip_terbaru as $a)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-3 py-2 font-mono text-xs">{{ $a->archive_number }}</td>
                    <td class="px-3 py-2">{{ Str::limit($a->title, 40) }}</td>
                    <td class="px-3 py-2">
                        <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded text-xs">
                            {{ $a->kategori->name }}
                        </span>
                    </td>
                    <td class="px-3 py-2">{{ $a->document_date->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-3 py-4 text-center text-gray-400">Belum ada arsip</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
 
    {{-- Grafik Pie Chart --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Arsip per Kategori</h2>
        <canvas id="chartKategori"></canvas>
    </div>
</div>
 
@push('scripts')
<script>
const chartData = @json($chart_data);
new Chart(document.getElementById('chartKategori'), {
    type: 'doughnut',
    data: {
        labels: chartData.map(d => d.label),
        datasets: [{ data: chartData.map(d => d.value),
            backgroundColor: ['#3B82F6','#10B981','#8B5CF6','#F59E0B','#EF4444'] }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
});
</script>
@endpush
@endsection
