<?php

namespace App\Http\Controllers;

use App\Models\Jorong;
use App\Models\KartuKeluarga;
use App\Models\Warga;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KartuKeluargaController extends Controller
{
    use LogsActivity;
    public function index(Request $request)
    {
        $query = KartuKeluarga::with(['jorong', 'wargas']);
        
        // Role-based filtering
        if (Auth::check() && Auth::user()->isWaliJorong()) {
            // Wali Jorong can only see data from their jorong
            $query->where('jorong_id', Auth::user()->jorong_id);
        } elseif ($request->has('jorong_id') && $request->jorong_id) {
            // Admin can filter by jorong
            $query->where('jorong_id', $request->jorong_id);
        }
        
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_kk', 'like', "%{$search}%")
                  ->orWhere('kepala_keluarga', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        $kartuKeluargas = $query->orderBy('nomor_kk')->paginate(15);
        $jorongs = Jorong::active()->orderBy('nama_jorong')->get();
        
        // Get current jorong info for Wali Jorong
        $currentJorong = null;
        if (Auth::check() && Auth::user()->isWaliJorong() && Auth::user()->jorong) {
            $currentJorong = Auth::user()->jorong;
        }

        return view('warga.kartu-keluarga.index', compact('kartuKeluargas', 'jorongs', 'currentJorong'));
    }

    public function create()
    {
        $jorongs = Jorong::active()->orderBy('nama_jorong')->get();
        return view('warga.kartu-keluarga.create', compact('jorongs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jorong_id' => 'required|exists:jorongs,id',
            'nomor_kk' => 'required|string|max:16|unique:kartu_keluargas,nomor_kk',
            'kepala_keluarga' => 'required|string|max:100',
            'alamat' => 'required|string',
            'rt' => 'nullable|string|max:3',
            'rw' => 'nullable|string|max:3',
            'kode_pos' => 'nullable|string|max:5',
            'telepon' => 'nullable|string|max:20',
            'tanggal_pembuatan' => 'nullable|date',
            'tanggal_berlaku' => 'nullable|date',
            'kelompok_sosial' => 'nullable|in:Miskin,Rentan Miskin,Menengah,Mampu',
            'catatan' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $kartuKeluarga = KartuKeluarga::create($validated);

        // Update jorong counter
        $kartuKeluarga->jorong->updateCounters();

        // Log activity
        $this->logCreate($kartuKeluarga, "Menambahkan kartu keluarga: {$kartuKeluarga->nomor_kk}");

        return redirect()->route('kartu-keluarga.index')
            ->with('success', 'Kartu Keluarga berhasil ditambahkan.');
    }

    public function show(KartuKeluarga $kartuKeluarga)
    {
        $kartuKeluarga->load(['jorong', 'wargas' => function($query) {
            $query->orderBy('hubungan_keluarga');
        }]);
        
        return view('warga.kartu-keluarga.show', compact('kartuKeluarga'));
    }

    public function edit(KartuKeluarga $kartuKeluarga)
    {
        $jorongs = Jorong::active()->orderBy('nama_jorong')->get();
        return view('warga.kartu-keluarga.edit', compact('kartuKeluarga', 'jorongs'));
    }

    public function update(Request $request, KartuKeluarga $kartuKeluarga)
    {
        $validated = $request->validate([
            'jorong_id' => 'required|exists:jorongs,id',
            'nomor_kk' => [
                'required',
                'string',
                'max:16',
                Rule::unique('kartu_keluargas')->ignore($kartuKeluarga->id),
            ],
            'kepala_keluarga' => 'required|string|max:100',
            'alamat' => 'required|string',
            'rt' => 'nullable|string|max:3',
            'rw' => 'nullable|string|max:3',
            'kode_pos' => 'nullable|string|max:5',
            'telepon' => 'nullable|string|max:20',
            'tanggal_pembuatan' => 'nullable|date',
            'tanggal_berlaku' => 'nullable|date',
            'kelompok_sosial' => 'nullable|in:Miskin,Rentan Miskin,Menengah,Mampu',
            'catatan' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $oldJorongId = $kartuKeluarga->jorong_id;
        $oldValues = $kartuKeluarga->toArray();
        $kartuKeluarga->update($validated);

        // Update counters for both old and new jorong
        if ($oldJorongId != $validated['jorong_id']) {
            Jorong::find($oldJorongId)->updateCounters();
            $kartuKeluarga->jorong->updateCounters();
        }

        // Log activity
        $this->logUpdate($kartuKeluarga, $oldValues, "Memperbarui kartu keluarga: {$kartuKeluarga->nomor_kk}");

        return redirect()->route('kartu-keluarga.index')
            ->with('success', 'Kartu Keluarga berhasil diperbarui.');
    }

    public function destroy(KartuKeluarga $kartuKeluarga)
    {
        $jorongId = $kartuKeluarga->jorong_id;
        
        if (!$kartuKeluarga->canBeDeleted()) {
            return back()->with('error', 'Tidak dapat menghapus KK yang masih memiliki anggota keluarga.');
        }

        $kartuKeluarga->delete();

        // Update jorong counter
        Jorong::find($jorongId)->updateCounters();

        return redirect()->route('kartu-keluarga.index')
            ->with('success', 'Kartu Keluarga berhasil dihapus.');
    }

    // Wizard-style KK creation with head of family
    public function createWizard()
    {
        $jorongs = Jorong::active()->orderBy('nama_jorong')->get();
        return view('warga.kartu-keluarga.create-wizard', compact('jorongs'));
    }

    public function storeWizard(Request $request)
    {
        $validated = $request->validate([
            // Kartu Keluarga Data
            'jorong_id' => 'required|exists:jorongs,id',
            'nomor_kk' => 'required|string|max:16|unique:kartu_keluargas,nomor_kk',
            'alamat' => 'required|string',
            'rt' => 'nullable|string|max:3',
            'rw' => 'nullable|string|max:3',
            'kode_pos' => 'nullable|string|max:5',
            'telepon' => 'nullable|string|max:20',
            'tanggal_pembuatan' => 'nullable|date',
            'tanggal_berlaku' => 'nullable|date',
            'kelompok_sosial' => 'nullable|in:Miskin,Rentan Miskin,Menengah,Mampu',
            'catatan' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            
            // Head of Family Data
            'kepala_keluarga_nik' => 'required|string|max:16|unique:wargas,nik',
            'kepala_keluarga_nama' => 'required|string|max:100',
            'kepala_keluarga_nama_panggilan' => 'nullable|string|max:50',
            'kepala_keluarga_jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'kepala_keluarga_tempat_lahir' => 'required|string|max:50',
            'kepala_keluarga_tanggal_lahir' => 'required|date',
            'kepala_keluarga_agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu,Lainnya',
            'kepala_keluarga_status_perkawinan' => 'required|in:Belum Menikah,Menikah,Cerai Hidup,Cerai Mati',
            'kepala_keluarga_nama_ayah_kandung' => 'nullable|string|max:100',
            'kepala_keluarga_nama_ibu_kandung' => 'nullable|string|max:100',
            'kepala_keluarga_alamat_lengkap' => 'required|string',
            'kepala_keluarga_kelurahan' => 'nullable|string|max:50',
            'kepala_keluarga_kecamatan' => 'nullable|string|max:50',
            'kepala_keluarga_kabupaten' => 'nullable|string|max:50',
            'kepala_keluarga_provinsi' => 'nullable|string|max:50',
            'kepala_keluarga_sesuai_kk' => 'boolean',
            'kepala_keluarga_pekerjaan' => 'required|in:Belum/Tidak Bekerja,Pegawai Negeri Sipil,TNI,Polri,Karyawan Swasta,Wiraswasta,Pedagang,Petani,Tukang,Buruh Tani,Pensiunan,Nelayan,Peternak,Jasa,Pengrajin,Pekerja Seni,Lainnya',
            'kepala_keluarga_pekerjaan_lain' => 'nullable|string|max:100',
            'kepala_keluarga_tingkat_pendidikan' => 'required|in:Tidak/Belum Sekolah,Tidak Lulus SD,SD/Sederajat,SMP/Sederajat,SMA/Sederajat,D1,D2,D3,S1/D4,S2,S3,Pondok Pesantren,Pendidikan Keagamaan,Sekolah Luar Biasa,Kursus Keterampilan,Lainnya',
            'kepala_keluarga_pendidikan_lain' => 'nullable|string|max:100',
            'kepala_keluarga_golongan_darah' => 'nullable|in:A,B,AB,O',
            'kepala_keluarga_no_paspor' => 'nullable|string|max:20',
            'kepala_keluarga_no_kitap' => 'nullable|string|max:20',
            'kepala_keluarga_ayah_nik' => 'nullable|string|max:16',
            'kepala_keluarga_ibu_nik' => 'nullable|string|max:16',
            'kepala_keluarga_catatan' => 'nullable|string',
        ]);

        // Use database transaction for atomic creation
        DB::beginTransaction();
        try {
            // Create Kartu Keluarga
            $kartuKeluarga = KartuKeluarga::create([
                'jorong_id' => $validated['jorong_id'],
                'nomor_kk' => $validated['nomor_kk'],
                'kepala_keluarga' => $validated['kepala_keluarga_nama'],
                'alamat' => $validated['alamat'],
                'rt' => $validated['rt'] ?? null,
                'rw' => $validated['rw'] ?? null,
                'kode_pos' => $validated['kode_pos'] ?? null,
                'telepon' => $validated['telepon'] ?? null,
                'tanggal_pembuatan' => $validated['tanggal_pembuatan'] ?? null,
                'tanggal_berlaku' => $validated['tanggal_berlaku'] ?? null,
                'kelompok_sosial' => $validated['kelompok_sosial'] ?? null,
                'catatan' => $validated['catatan'] ?? null,
                'is_active' => $validated['is_active'] ?? true,
            ]);

            // Create Head of Family
            $kepalaKeluarga = Warga::create([
                'kartu_keluarga_id' => $kartuKeluarga->id,
                'is_tetap' => true,
                'nik' => $validated['kepala_keluarga_nik'],
                'nama_lengkap' => $validated['kepala_keluarga_nama'],
                'nama_panggilan' => $validated['kepala_keluarga_nama_panggilan'] ?? null,
                'jenis_kelamin' => $validated['kepala_keluarga_jenis_kelamin'],
                'tempat_lahir' => $validated['kepala_keluarga_tempat_lahir'],
                'tanggal_lahir' => $validated['kepala_keluarga_tanggal_lahir'],
                'agama' => $validated['kepala_keluarga_agama'],
                'status_perkawinan' => $validated['kepala_keluarga_status_perkawinan'],
                'hubungan_keluarga' => 'Kepala Keluarga',
                'nama_ayah_kandung' => $validated['kepala_keluarga_nama_ayah_kandung'] ?? null,
                'nama_ibu_kandung' => $validated['kepala_keluarga_nama_ibu_kandung'] ?? null,
                'alamat_lengkap' => $validated['kepala_keluarga_alamat_lengkap'],
                'kelurahan' => $validated['kepala_keluarga_kelurahan'] ?? null,
                'kecamatan' => $validated['kepala_keluarga_kecamatan'] ?? null,
                'kabupaten' => $validated['kepala_keluarga_kabupaten'] ?? null,
                'provinsi' => $validated['kepala_keluarga_provinsi'] ?? null,
                'sesuai_kk' => $validated['kepala_keluarga_sesuai_kk'] ?? true,
                'pekerjaan' => $validated['kepala_keluarga_pekerjaan'],
                'pekerjaan_lain' => $validated['kepala_keluarga_pekerjaan_lain'] ?? null,
                'tingkat_pendidikan' => $validated['kepala_keluarga_tingkat_pendidikan'],
                'pendidikan_lain' => $validated['kepala_keluarga_pendidikan_lain'] ?? null,
                'golongan_darah' => $validated['kepala_keluarga_golongan_darah'] ?? null,
                'no_paspor' => $validated['kepala_keluarga_no_paspor'] ?? null,
                'no_kitap' => $validated['kepala_keluarga_no_kitap'] ?? null,
                'ayah_nik' => $validated['kepala_keluarga_ayah_nik'] ?? null,
                'ibu_nik' => $validated['kepala_keluarga_ibu_nik'] ?? null,
                'catatan' => $validated['kepala_keluarga_catatan'] ?? null,
                'is_active' => true,
            ]);

            // Update counters
            $kartuKeluarga->updateJumlahAnggota();
            $kartuKeluarga->jorong->updateCounters();

            // Log activity
            $this->logCreate($kartuKeluarga, "Menambahkan kartu keluarga dengan kepala keluarga: {$kartuKeluarga->nomor_kk}");
            $this->logCreate($kepalaKeluarga, "Menambahkan kepala keluarga: {$kepalaKeluarga->nama_lengkap}");

            DB::commit();

            return redirect()->route('kartu-keluarga.show', $kartuKeluarga)
                ->with('success', 'Kartu Keluarga dan Kepala Keluarga berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }
}
