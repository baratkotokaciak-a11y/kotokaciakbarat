<?php

namespace App\Http\Controllers;

use App\Models\Jorong;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class JorongController extends Controller
{
    use LogsActivity;
    public function index()
    {
        $query = Jorong::withCount('kartuKeluargas', 'wargas');
        
        // Wali Jorong can only see their own jorong
        if (Auth::check() && Auth::user()->isWaliJorong()) {
            $query->where('id', Auth::user()->jorong_id);
        }
        
        $jorongs = $query->orderBy('nama_jorong')->paginate(10);
        
        return view('warga.jorong.index', compact('jorongs'));
    }

    public function create()
    {
        return view('warga.jorong.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_jorong' => 'required|string|max:100|unique:jorongs,nama_jorong',
            'deskripsi' => 'nullable|string',
            'nik_ketua_jorong' => 'nullable|string|max:16',
            'nama_ketua_jorong' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        $jorong = Jorong::create($validated);

        // Log activity
        $this->logCreate($jorong, "Menambahkan jorong: {$jorong->nama_jorong}");

        return redirect()->route('jorong.index')
            ->with('success', 'Jorong berhasil ditambahkan.');
    }

    public function show(Jorong $jorong)
    {
        $jorong->load(['kartuKeluargas.wargas', 'wargas']);
        return view('warga.jorong.show', compact('jorong'));
    }

    public function edit(Jorong $jorong)
    {
        return view('warga.jorong.edit', compact('jorong'));
    }

    public function update(Request $request, Jorong $jorong)
    {
        $validated = $request->validate([
            'nama_jorong' => [
                'required',
                'string',
                'max:100',
                Rule::unique('jorongs')->ignore($jorong->id),
            ],
            'deskripsi' => 'nullable|string',
            'nik_ketua_jorong' => 'nullable|string|max:16',
            'nama_ketua_jorong' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        $oldValues = $jorong->toArray();
        $jorong->update($validated);

        // Log activity
        $this->logUpdate($jorong, $oldValues, "Memperbarui jorong: {$jorong->nama_jorong}");

        return redirect()->route('jorong.index')
            ->with('success', 'Jorong berhasil diperbarui.');
    }

    public function destroy(Jorong $jorong)
    {
        if ($jorong->kartuKeluargas()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus jorong yang masih memiliki kartu keluarga.');
        }

        $jorong->delete();

        return redirect()->route('jorong.index')
            ->with('success', 'Jorong berhasil dihapus.');
    }
}