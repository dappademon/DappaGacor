<?php
namespace App\Http\Controllers;
 
use App\Models\Arsip;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\database\Eloquent\Collection;
 
class ArsipController extends Controller
{
    public function index(Request $request)
    {
        $query = Arsip::with(['kategori', 'user', 'penduduk']);
 
        // Filter & Pencarian
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%$s%")
                  ->orWhere('archive_number', 'like', "%$s%")
                  ->orWhere('sender_receiver', 'like', "%$s%");
            });
        }
 
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
 
        if ($request->filled('date_from')) {
            $query->whereDate('document_date', '>=', $request->date_from);
        }
 
        if ($request->filled('date_to')) {
            $query->whereDate('document_date', '<=', $request->date_to);
        }
 
        $arsips     = $query->latest()->paginate(15)->withQueryString();
        $kategoris  = Kategori::all();
 
        return view('arsip.index', compact('arsips', 'kategoris'));
    }
 
    public function create()
    {
        $kategoris = Kategori::all();
        return view('arsip.create', compact('kategoris'));
    }
 
    /**
     * STORE - Implementasi Flow Map NIK
     * Menggunakan DB::transaction untuk atomicity
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'archive_number'  => 'required|string|max:50|unique:arsips',
            'title'           => 'required|string|max:150',
            'category_id'     => 'required|exists:kategoris,id',
            'document_date'   => 'required|date',
            'sender_receiver' => 'nullable|string|max:100',
            'notes'           => 'nullable|string',
            'file'            => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            // Data penduduk (jika disertakan)
            'resident_id'     => 'nullable|exists:penduduks,id',
        ]);
 
        try {
            DB::transaction(function () use ($request, $validated) {
                // Upload file
                $path = $request->file('file')->store('arsip', 'public');
 
                Arsip::create([
                    'archive_number'  => $validated['archive_number'],
                    'title'           => $validated['title'],
                    'category_id'     => $validated['category_id'],
                    'resident_id'     => $validated['resident_id'] ?? null,
                    'user_id'         => auth()->id(),
                    'document_date'   => $validated['document_date'],
                    'sender_receiver' => $validated['sender_receiver'] ?? null,
                    'file_path'       => $path,
                    'notes'           => $validated['notes'] ?? null,
                ]);
            });
 
            return redirect()->route('arsip.index')
                ->with('success', 'Arsip berhasil disimpan!');
 
        } catch (\Throwable $e) {
            return back()->withInput()
                ->with('error', 'Gagal menyimpan arsip: ' . $e->getMessage());
        }
    }
 
    public function show(Arsip $arsip)
    {
        $arsip->load(['kategori', 'user', 'penduduk']);
        return view('arsip.show', compact('arsip'));
    }
 
    public function edit(Arsip $arsip)
    {
        $kategoris = Kategori::all();
        return view('arsip.edit', compact('arsip', 'kategoris'));
    }
 
    public function update(Request $request, Arsip $arsip)
    {
        $validated = $request->validate([
            'archive_number'  => 'required|string|max:50|unique:arsips,archive_number,'.$arsip->id,
            'title'           => 'required|string|max:150',
            'category_id'     => 'required|exists:kategoris,id',
            'document_date'   => 'required|date',
            'sender_receiver' => 'nullable|string|max:100',
            'notes'           => 'nullable|string',
            'file'            => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);
 
        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($arsip->file_path);
            $validated['file_path'] = $request->file('file')->store('arsip', 'public');
        }
 
        $arsip->update($validated);
        return redirect()->route('arsip.index')->with('success', 'Arsip diperbarui!');
    }
 
    public function destroy(Arsip $arsip)
    {
        Storage::disk('public')->delete($arsip->file_path);
        $arsip->delete();
        return redirect()->route('arsip.index')->with('success', 'Arsip dihapus!');
    }
 
    public function download(Arsip $arsip)
    {
        return Storage::disk('public')->download($arsip->file_path, $arsip->title);
    }
 
    public function laporan()
    {
        $arsips = Arsip::with(['kategori', 'user', 'penduduk'])->latest()->get();
        return view('arsip.laporan', compact('arsips'));
    }
}

