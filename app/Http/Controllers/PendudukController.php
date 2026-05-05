<?php
namespace App\Http\Controllers;
 
use App\Models\Penduduk;
use Illuminate\Http\Request;
 
class PendudukController extends Controller
{
    /**
     * AJAX: Cari penduduk berdasarkan NIK
     * GET /api/penduduk/cari?nik=xxxx
     */
    public function cariByNik(Request $request)
    {
        $request->validate(['nik' => 'required|digits:16']);
 
        $penduduk = Penduduk::where('nik', $request->nik)->first();
 
        if ($penduduk) {
            return response()->json([
                'found'   => true,
                'id'      => $penduduk->id,
                'name'    => $penduduk->name,
                'nik'     => $penduduk->nik,
                'address' => $penduduk->address,
            ]);
        }
 
        return response()->json(['found' => false]);
    }
 
    /**
     * AJAX: Simpan penduduk baru
     * POST /api/penduduk
     */
    public function simpanBaru(Request $request)
    {
        $validated = $request->validate([
            'nik'     => 'required|digits:16|unique:penduduks,nik',
            'name'    => 'required|string|max:100',
            'address' => 'required|string',
        ]);
 
        $penduduk = Penduduk::create($validated);
 
        return response()->json([
            'success' => true,
            'id'      => $penduduk->id,
            'name'    => $penduduk->name,
            'message' => 'Data penduduk berhasil disimpan.',
        ], 201);
    }
}
