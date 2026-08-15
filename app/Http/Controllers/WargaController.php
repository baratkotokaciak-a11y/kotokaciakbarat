<?php

namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use App\Models\Warga;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class WargaController extends Controller
{
    use LogsActivity;
    public function index(Request $request)
    {
        $query = Warga::with(['kartuKeluarga.jorong']);
        
        // Role-based filtering
        if (Auth::check() && Auth::user()->isWaliJorong()) {
            // Wali Jorong can only see data from their jorong
            $query->whereHas('kartuKeluarga', function($q) {
                $q->where('jorong_id', Auth::user()->jorong_id);
            });
        } elseif ($request->has('jorong_id') && $request->jorong_id) {
            // Admin can filter by jorong
            $query->whereHas('kartuKeluarga', function($q) use ($request) {
                $q->where('jorong_id', $request->jorong_id);
            });
        }
        
        // Filter by kartu keluarga
        if ($request->has('kk_id') && $request->kk_id) {
            $query->where('kartu_keluarga_id', $request->kk_id);
        }
        
        // Filter by status
        if ($request->has('status') && $request->status) {
            if ($request->status === 'wafat') {
                $query->wafat();
            } elseif ($request->status === 'hidup') {
                $query->hidup();
            }
        }
        
        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nik', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nama_panggilan', 'like', "%{$search}%");
            });
        }

        $wargas = $query->orderBy('nama_lengkap')->paginate(20);
        
        // Get current jorong info for Wali Jorong
        $currentJorong = null;
        if (Auth::check() && Auth::user()->isWaliJorong() && Auth::user()->jorong) {
            $currentJorong = Auth::user()->jorong;
        }
        
        return view('warga.index', compact('wargas', 'currentJorong'));
    }

    public function create(Request $request)
    {
        $kartuKeluargas = KartuKeluarga::active()->with('jorong');
        
        // Wali Jorong can only create data for their jorong
        if (Auth::user()->isWaliJorong()) {
            $kartuKeluargas->where('jorong_id', Auth::user()->jorong_id);
        }
        
        $kartuKeluargas = $kartuKeluargas->get();
        $selectedKk = $request->kk_id ? KartuKeluarga::find($request->kk_id) : null;
        
        return view('warga.create', compact('kartuKeluargas', 'selectedKk'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Kartu Keluarga
            'kartu_keluarga_id' => 'nullable|exists:kartu_keluargas,id',
            'is_tetap' => 'boolean',
            'nik' => 'nullable|string|max:16|unique:wargas,nik',
            
            // Data Diri
            'nama_lengkap' => 'required|string|max:100',
            'nama_panggilan' => 'nullable|string|max:50',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu,Lainnya',
            
            // Status dan Keluarga
            'status_perkawinan' => 'required|in:Belum Menikah,Menikah,Cerai Hidup,Cerai Mati',
            'hubungan_keluarga' => 'required|in:Kepala Keluarga,Istri,Anak,Orang Tua,Cucu,Famili Lain,Lainnya',
            'nama_ayah_kandung' => 'nullable|string|max:100',
            'nama_ibu_kandung' => 'nullable|string|max:100',
            
            // Alamat dan Domisili
            'alamat_lengkap' => 'required|string',
            'kelurahan' => 'nullable|string|max:50',
            'kecamatan' => 'nullable|string|max:50',
            'kabupaten' => 'nullable|string|max:50',
            'provinsi' => 'nullable|string|max:50',
            'sesuai_kk' => 'boolean',
            
            // Pekerjaan
            'pekerjaan' => 'required|in:Belum/Tidak Bekerja,Pegawai Negeri Sipil,TNI,Polri,Karyawan Swasta,Wiraswasta,Pedagang,Petani,Tukang,Buruh Tani,Pensiunan,Nelayan,Peternak,Jasa,Pengrajin,Pekerja Seni,Lainnya',
            'pekerjaan_lain' => 'nullable|string|max:100',
            
            // Pendidikan
            'tingkat_pendidikan' => 'required|in:Tidak/Belum Sekolah,Tidak Lulus SD,SD/Sederajat,SMP/Sederajat,SMA/Sederajat,D1,D2,D3,S1/D4,S2,S3,Pondok Pesantren,Pendidikan Keagamaan,Sekolah Luar Biasa,Kursus Keterampilan,Lainnya',
            'pendidikan_lain' => 'nullable|string|max:100',
            
            // Data Tambahan
            'golongan_darah' => 'nullable|in:A,B,AB,O',
            'no_paspor' => 'nullable|string|max:20',
            'no_kitap' => 'nullable|string|max:20',
            'ayah_nik' => 'nullable|string|max:16',
            'ibu_nik' => 'nullable|string|max:16',
            'is_wafat' => 'boolean',
            'tanggal_wafat' => 'nullable|date|required_if:is_wafat,1',
            'catatan' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $warga = Warga::create($validated);

        // Update KK counter
        if ($warga->kartuKeluarga) {
            $warga->kartuKeluarga->updateJumlahAnggota();
            $warga->kartuKeluarga->jorong->updateCounters();
        }

        // Log activity
        $this->logCreate($warga, "Menambahkan data warga: {$warga->nama_lengkap}");

        return redirect()->route('warga.index')
            ->with('success', 'Data warga berhasil ditambahkan.');
    }

    public function show(Warga $warga)
    {
        $warga->load(['kartuKeluarga.jorong']);
        
        return view('warga.show', compact('warga'));
    }

    public function edit(Warga $warga)
    {
        $warga->load('kartuKeluarga.jorong');
        $kartuKeluargas = KartuKeluarga::active()->with('jorong')->get();
        
        return view('warga.edit', compact('warga', 'kartuKeluargas'));
    }

    public function update(Request $request, Warga $warga)
    {
        $validated = $request->validate([
            // Kartu Keluarga
            'kartu_keluarga_id' => 'nullable|exists:kartu_keluargas,id',
            'is_tetap' => 'boolean',
            'nik' => [
                'nullable',
                'string',
                'max:16',
                Rule::unique('wargas')->ignore($warga->id),
            ],
            
            // Data Diri
            'nama_lengkap' => 'required|string|max:100',
            'nama_panggilan' => 'nullable|string|max:50',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu,Lainnya',
            
            // Status dan Keluarga
            'status_perkawinan' => 'required|in:Belum Menikah,Menikah,Cerai Hidup,Cerai Mati',
            'hubungan_keluarga' => 'required|in:Kepala Keluarga,Istri,Anak,Orang Tua,Cucu,Famili Lain,Lainnya',
            'nama_ayah_kandung' => 'nullable|string|max:100',
            'nama_ibu_kandung' => 'nullable|string|max:100',
            
            // Alamat dan Domisili
            'alamat_lengkap' => 'required|string',
            'kelurahan' => 'nullable|string|max:50',
            'kecamatan' => 'nullable|string|max:50',
            'kabupaten' => 'nullable|string|max:50',
            'provinsi' => 'nullable|string|max:50',
            'sesuai_kk' => 'boolean',
            
            // Pekerjaan
            'pekerjaan' => 'required|in:Belum/Tidak Bekerja,Pegawai Negeri Sipil,TNI,Polri,Karyawan Swasta,Wiraswasta,Pedagang,Petani,Tukang,Buruh Tani,Pensiunan,Nelayan,Peternak,Jasa,Pengrajin,Pekerja Seni,Lainnya',
            'pekerjaan_lain' => 'nullable|string|max:100',
            
            // Pendidikan
            'tingkat_pendidikan' => 'required|in:Tidak/Belum Sekolah,Tidak Lulus SD,SD/Sederajat,SMP/Sederajat,SMA/Sederajat,D1,D2,D3,S1/D4,S2,S3,Pondok Pesantren,Pendidikan Keagamaan,Sekolah Luar Biasa,Kursus Keterampilan,Lainnya',
            'pendidikan_lain' => 'nullable|string|max:100',
            
            // Data Tambahan
            'golongan_darah' => 'nullable|in:A,B,AB,O',
            'no_paspor' => 'nullable|string|max:20',
            'no_kitap' => 'nullable|string|max:20',
            'ayah_nik' => 'nullable|string|max:16',
            'ibu_nik' => 'nullable|string|max:16',
            'is_wafat' => 'boolean',
            'tanggal_wafat' => 'nullable|date|required_if:is_wafat,1',
            'catatan' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $oldKkId = $warga->kartu_keluarga_id;
        $oldValues = $warga->toArray();
        $warga->update($validated);

        // Update counters for both old and new KK
        if ($oldKkId != $validated['kartu_keluarga_id']) {
            if ($oldKkId) {
                $oldKk = KartuKeluarga::find($oldKkId);
                $oldKk?->updateJumlahAnggota();
                $oldKk?->jorong?->updateCounters();
            }

            if ($warga->kartuKeluarga) {
                $warga->kartuKeluarga->updateJumlahAnggota();
                $warga->kartuKeluarga->jorong->updateCounters();
            }
        }

        // Log activity
        $this->logUpdate($warga, $oldValues, "Memperbarui data warga: {$warga->nama_lengkap}");

        return redirect()->route('warga.index')
            ->with('success', 'Data warga berhasil diperbarui.');
    }

    public function destroy(Warga $warga)
    {
        $kkId = $warga->kartu_keluarga_id;
        $jorongId = $warga->kartuKeluarga->jorong_id;

        $warga->delete();

        // Update counters
        if ($kkId) {
            $kk = KartuKeluarga::find($kkId);
            $kk?->updateJumlahAnggota();
            $kk?->jorong?->updateCounters();
        }

        return redirect()->route('warga.index')
            ->with('success', 'Data warga berhasil dihapus.');
    }

    // Transfer warga between KKs
    public function transfer(Request $request, Warga $warga)
    {
        // Prevent transferring head of family
        if ($warga->hubungan_keluarga === 'Kepala Keluarga') {
            return back()->with('error', 'Kepala Keluarga tidak dapat dipindahkan. Silakan ubah kepala keluarga terlebih dahulu.');
        }

        $validated = $request->validate([
            'new_kartu_keluarga_id' => 'required|exists:kartu_keluargas,id|different:' . $warga->kartu_keluarga_id,
        ]);

        $oldKkId = $warga->kartu_keluarga_id;
        
        if ($warga->transferToKK($validated['new_kartu_keluarga_id'])) {
            // Log activity
            $this->logUpdate($warga, ['kartu_keluarga_id' => $oldKkId], "Memindahkan warga {$warga->nama_lengkap} ke KK lain");
            
            return redirect()->route('kartu-keluarga.show', $validated['new_kartu_keluarga_id'])
                ->with('success', 'Warga berhasil dipindahkan ke kartu keluarga lain.');
        }

        return back()->with('error', 'Gagal memindahkan warga. Silakan coba lagi.');
    }

    // Convert temporary resident to permanent
    public function convertToPermanent(Request $request, Warga $warga)
    {
        $validated = $request->validate([
            'kartu_keluarga_id' => 'required|exists:kartu_keluargas,id',
        ]);

        if ($warga->convertToPermanent($validated['kartu_keluarga_id'])) {
            // Update counters
            $warga->kartuKeluarga->updateJumlahAnggota();
            $warga->kartuKeluarga->jorong->updateCounters();

            // Log activity
            $this->logUpdate($warga, [], "Mengkonversi warga {$warga->nama_lengkap} menjadi warga tetap");
            
            return redirect()->route('kartu-keluarga.show', $validated['kartu_keluarga_id'])
                ->with('success', 'Warga sementara berhasil dikonversi menjadi warga tetap.');
        }

        return back()->with('error', 'Gagal mengkonversi warga. Pastikan warga adalah warga sementara tanpa KK.');
    }
}
