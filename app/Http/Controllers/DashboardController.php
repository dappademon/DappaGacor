<?php
namespace App\Http\Controllers;
 
use App\Models\Arsip;
use App\Models\Kategori;
use App\Models\Penduduk;
use App\Models\User;
 
class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_arsip'    => Arsip::count(),
            'total_kategori' => Kategori::count(),
            'total_penduduk' => Penduduk::count(),
            'total_user'     => User::count(),
        ];
 
        $arsip_terbaru = Arsip::with(['kategori', 'user', 'penduduk'])
            ->latest()
            ->take(5)
            ->get();
 
        // Statistik per kategori untuk grafik
        $chart_data = Kategori::withCount('arsips')
            ->get()
            ->map(fn($k) => [
                'label' => $k->name,
                'value' => $k->arsips_count
            ]);
 
        return view('dashboard', compact('stats', 'arsip_terbaru', 'chart_data'));
    }
}
