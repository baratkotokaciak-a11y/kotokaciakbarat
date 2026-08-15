<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\ContactMessage;
use App\Models\Warga;
use App\Models\KartuKeluarga;
use App\Models\Jorong;

class HomeController extends Controller
{
    public function index()
    {
        $data = $this->loadProfileData();

        $data['warga_stats'] = $this->loadWargaStatistics();

        $profilCards = [
            [
                'tag' => 'Visi',
                'title' => $data['profile']['visi'] ?? 'Nagari Sejahtera dan Inovatif',
                'description' => 'Mewujudkan masyarakat maju, mandiri, dan digital dengan pelayanan cepat serta informasi akurat.',
            ],
            [
                'tag' => 'Misi',
                'title' => 'Pelayanan dan Kesejahteraan',
                'description' => $data['profile']['misi'] ?? 'Menyediakan layanan publik prima, membangun infrastruktur unggul, serta mendukung UMKM dan budaya lokal.',
            ],
            [
                'tag' => 'Nilai',
                'title' => $data['profile']['nilai'] ?? 'Gotong Royong & Kebersamaan',
                'description' => 'Mendorong kolaborasi warga, transparansi, dan pembangunan yang berkelanjutan di nagari.',
            ],
        ];

        return view('home_dynamic', array_merge($data, compact('profilCards')));
    }

    public function admin()
    {
        $data = $this->loadProfileData();
        return view('admin', ['data' => $data]);
    }

    public function adminSection(string $section)
    {
$allowedSections = ['banner', 'hero', 'stats', 'devices', 'news', 'services', 'regulations', 'contact', 'profile', 'header', 'content', 'buttons'];
        if (!in_array($section, $allowedSections, true)) {
            abort(404);
        }

        $data = $this->loadProfileData();
$titles = [
            'banner' => 'Banner Halaman',
            'hero' => 'Hero & Ringkasan',
            'stats' => 'Statistik',
            'devices' => 'Perangkat Nagari',
            'news' => 'Berita',
            'services' => 'Layanan Publik',
            'regulations' => 'Peraturan',
            'contact' => 'Kontak',
            'profile' => 'Profil Nagari',
            'header' => 'Header & Navigasi',
            'content' => 'Konten Halaman',
            'buttons' => 'Tombol & Link',
        ];

        return view('admin_section', [
            'data' => $data,
            'section' => $section,
            'sectionTitle' => $titles[$section],
        ]);
    }

    public function saveAdminSection(Request $request, string $section)
    {
$raw = $this->loadProfileRawData();

        if ($section === 'banner') {
            $request->validate([
                'banner_badge' => ['nullable', 'string', 'max:100'],
                'banner_title' => ['nullable', 'string', 'max:255'],
                'banner_subtitle' => ['nullable', 'string', 'max:1200'],
                'banner_image' => ['nullable', 'string', 'max:1000'],
                'banner_image_file' => ['nullable', 'image', 'max:8192'],
            ]);

            $image = trim($request->input('banner_image', ''));

            if ($request->hasFile('banner_image_file') && $request->file('banner_image_file')->isValid()) {
                $upload = $request->file('banner_image_file');
                $folder = public_path('images/banner');
                if (!is_dir($folder)) {
                    mkdir($folder, 0755, true);
                }
                $filename = time() . '_' . preg_replace('/[^A-Za-z0-9_.-]/', '_', $upload->getClientOriginalName());
                $upload->move($folder, $filename);
                $image = asset('images/banner/' . $filename);
            }

            $raw['banner'] = [
                'badge' => $request->input('banner_badge', 'Selamat Datang'),
                'title' => $request->input('banner_title'),
                'subtitle' => $request->input('banner_subtitle'),
                'image' => $image,
            ];
        } elseif ($section === 'hero') {
            $request->validate([
                'hero_title' => ['required', 'string', 'max:255'],
                'hero_subtitle' => ['required', 'string', 'max:1200'],
            ]);

            $raw['hero_title'] = $request->input('hero_title');
            $raw['hero_subtitle'] = $request->input('hero_subtitle');
        } elseif ($section === 'stats') {
            $request->validate([
                'stats_text' => ['required', 'string'],
            ]);

            $raw['stats_text'] = $request->input('stats_text');
        } elseif ($section === 'devices') {
            $request->validate([
                'devices' => ['array'],
                'devices.*.name' => ['required', 'string', 'max:255'],
                'devices.*.position' => ['required', 'string', 'max:255'],
                'devices.*.image' => ['nullable', 'string', 'max:1000'],
                'device_images.*' => ['nullable', 'image', 'max:5120'],
            ]);

            $deviceUploads = $request->file('device_images', []);
            $devices = [];

            foreach ($request->input('devices', []) as $index => $device) {
                $image = trim($device['image'] ?? '');

                if (isset($deviceUploads[$index]) && $deviceUploads[$index]->isValid()) {
                    $upload = $deviceUploads[$index];
                    $folder = public_path('images/devices');
                    if (!is_dir($folder)) {
                        mkdir($folder, 0755, true);
                    }

                    $filename = time() . '_' . preg_replace('/[^A-Za-z0-9_.-]/', '_', $upload->getClientOriginalName());
                    $upload->move($folder, $filename);
                    $image = asset('images/devices/' . $filename);
                }

                if (empty($device['name']) && empty($device['position']) && empty($image)) {
                    continue;
                }

                $devices[] = [
                    'name' => $device['name'] ?? '',
                    'position' => $device['position'] ?? '',
                    'image' => $image,
                ];
            }

            $raw['devices'] = $devices;
        } elseif ($section === 'news') {
            $request->validate([
                'news' => ['array'],
                'news.*.date' => ['nullable', 'string', 'max:255'],
                'news.*.type' => ['nullable', 'string', 'max:255'],
                'news.*.title' => ['nullable', 'string', 'max:255'],
                'news.*.summary' => ['nullable', 'string', 'max:1200'],
                'news.*.body' => ['nullable', 'string'],
                'news.*.image' => ['nullable', 'string', 'max:1000'],
                'news_images.*' => ['nullable', 'image', 'max:5120'],
            ]);

            $newsUploads = $request->file('news_images', []);
            $newsObjects = [];

            foreach ($request->input('news', []) as $index => $newsItem) {
                $image = trim($newsItem['image'] ?? '');

                if (isset($newsUploads[$index]) && $newsUploads[$index]->isValid()) {
                    $upload = $newsUploads[$index];
                    $folder = public_path('images/news');
                    if (!is_dir($folder)) {
                        mkdir($folder, 0755, true);
                    }

                    $filename = time() . '_' . preg_replace('/[^A-Za-z0-9_.-]/', '_', $upload->getClientOriginalName());
                    $upload->move($folder, $filename);
                    $image = asset('images/news/' . $filename);
                }

                if (empty($newsItem['date']) && empty($newsItem['type']) && empty($newsItem['title']) && empty($newsItem['summary']) && empty($image) && empty($newsItem['body'])) {
                    continue;
                }

                $newsObjects[] = [
                    'id' => $newsItem['id'] ?? (string) (time() . '_' . $index . '_' . rand(1000, 9999)),
                    'date' => $newsItem['date'] ?? '',
                    'type' => $newsItem['type'] ?? '',
                    'title' => $newsItem['title'] ?? '',
                    'summary' => $newsItem['summary'] ?? '',
                    'body' => $newsItem['body'] ?? '',
                    'image' => $image,
                ];
            }

            $raw['news_text'] = json_encode($newsObjects, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } elseif ($section === 'services') {
            $request->validate([
                'services_text' => ['required', 'string'],
            ]);

            $raw['services_text'] = $request->input('services_text');
        } elseif ($section === 'regulations') {
            $request->validate([
                'regulations_text' => ['required', 'string'],
            ]);

            $raw['regulations_text'] = $request->input('regulations_text');
        } elseif ($section === 'contact') {
            $request->validate([
                'contact_address' => ['required', 'string', 'max:255'],
                'contact_phone' => ['required', 'string', 'max:255'],
                'contact_email' => ['required', 'email', 'max:255'],
            ]);

            $raw['contact'] = [
                'address' => $request->input('contact_address'),
                'phone' => $request->input('contact_phone'),
                'email' => $request->input('contact_email'),
            ];
        } elseif ($section === 'profile') {
            $request->validate([
                'profile_visi' => ['required', 'string', 'max:500'],
                'profile_misi' => ['required', 'string', 'max:1000'],
                'profile_nilai' => ['required', 'string', 'max:500'],
                'profile_sejarah' => ['nullable', 'string'],
                'profile_wilayah' => ['nullable', 'string', 'max:500'],
            ]);

            $raw['profile'] = [
                'visi' => $request->input('profile_visi'),
                'misi' => $request->input('profile_misi'),
                'nilai' => $request->input('profile_nilai'),
                'sejarah' => $request->input('profile_sejarah'),
                'wilayah' => $request->input('profile_wilayah'),
            ];
        } elseif ($section === 'header') {
            $request->validate([
                'site_name' => ['required', 'string', 'max:100'],
                'site_subtitle' => ['nullable', 'string', 'max:200'],
                'nav_items' => ['nullable', 'string'],
            ]);

            $raw['header'] = [
                'site_name' => $request->input('site_name'),
                'site_subtitle' => $request->input('site_subtitle'),
                'nav_items' => $request->input('nav_items'),
            ];
        } elseif ($section === 'content') {
            $request->validate([
                'section_profile_title' => ['nullable', 'string', 'max:200'],
                'section_profile_desc' => ['nullable', 'string', 'max:500'],
                'section_devices_title' => ['nullable', 'string', 'max:200'],
                'section_devices_desc' => ['nullable', 'string', 'max:500'],
                'section_news_title' => ['nullable', 'string', 'max:200'],
                'section_news_desc' => ['nullable', 'string', 'max:500'],
                'section_services_title' => ['nullable', 'string', 'max:200'],
                'section_services_desc' => ['nullable', 'string', 'max:500'],
                'section_regulations_title' => ['nullable', 'string', 'max:200'],
                'section_regulations_desc' => ['nullable', 'string', 'max:500'],
                'section_contact_title' => ['nullable', 'string', 'max:200'],
                'section_contact_desc' => ['nullable', 'string', 'max:500'],
            ]);

            $raw['content_sections'] = [
                'profile' => [
                    'title' => $request->input('section_profile_title'),
                    'description' => $request->input('section_profile_desc'),
                ],
                'devices' => [
                    'title' => $request->input('section_devices_title'),
                    'description' => $request->input('section_devices_desc'),
                ],
                'news' => [
                    'title' => $request->input('section_news_title'),
                    'description' => $request->input('section_news_desc'),
                ],
                'services' => [
                    'title' => $request->input('section_services_title'),
                    'description' => $request->input('section_services_desc'),
                ],
                'regulations' => [
                    'title' => $request->input('section_regulations_title'),
                    'description' => $request->input('section_regulations_desc'),
                ],
                'contact' => [
                    'title' => $request->input('section_contact_title'),
                    'description' => $request->input('section_contact_desc'),
                ],
            ];
        } elseif ($section === 'buttons') {
            $request->validate([
                'hero_button_primary_text' => ['nullable', 'string', 'max:50'],
                'hero_button_primary_link' => ['nullable', 'string', 'max:200'],
                'hero_button_secondary_text' => ['nullable', 'string', 'max:50'],
                'hero_button_secondary_link' => ['nullable', 'string', 'max:200'],
                'contact_button_text' => ['nullable', 'string', 'max:50'],
                'edit_profile_button_text' => ['nullable', 'string', 'max:50'],
            ]);

            $raw['buttons'] = [
                'hero_primary' => [
                    'text' => $request->input('hero_button_primary_text'),
                    'link' => $request->input('hero_button_primary_link'),
                ],
                'hero_secondary' => [
                    'text' => $request->input('hero_button_secondary_text'),
                    'link' => $request->input('hero_button_secondary_link'),
                ],
                'contact' => [
                    'text' => $request->input('contact_button_text'),
                ],
                'edit_profile' => [
                    'text' => $request->input('edit_profile_button_text'),
                ],
            ];
        }

        Storage::disk('local')->put('profile_data.json', json_encode($raw, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return Redirect::route('admin.section.edit', ['section' => $section])->with('success', 'Bagian ' . $section . ' berhasil disimpan.');
    }

    private function loadProfileData(): array
    {
        $data = $this->loadProfileRawData();

        if (!empty($data['devices']) && is_array($data['devices'])) {
            $data['devices'] = array_values(array_map(function ($item) {
                return [
                    'name' => $item['name'] ?? '',
                    'position' => $item['position'] ?? '',
                    'image' => $item['image'] ?? '',
                ];
            }, $data['devices']));
        } else {
            $data['devices'] = $this->parseLines($data['devices_text'], 3, 'device');
        }

        $dbNews = \App\Models\News::orderBy('date', 'desc')->get();
        if ($dbNews->count() > 0) {
            $data['news'] = $dbNews->map(function ($n) {
                return [
                    'id' => $n->id,
                    'date' => $n->date ? \Carbon\Carbon::parse($n->date)->format('d F Y') : '',
                    'type' => $n->type ?? 'Berita',
                    'title' => $n->title,
                    'summary' => $n->summary ?? '',
                    'image' => $n->image,
                    'body' => $n->body ?? '',
                ];
            })->toArray();
        } else {
            $data['news'] = $this->parseLines($data['news_text'], 5, 'news');
        }

        $data['statistics'] = $this->parseLines($data['stats_text'], 2, 'stat');
        $data['services'] = $this->parseLines($data['services_text'], 3, 'service');
        $data['regulations'] = $this->parseLines($data['regulations_text'], 2, 'regulation');

        // Load APBN transparency data
        $data['apbn'] = $this->loadApbnData();
// Ensure APBN section content defaults exist
        $data['content_sections']['apbn'] = $data['content_sections']['apbn'] ?? [
            'title' => 'Transparansi APBN & Dana Desa',
            'description' => 'Lihat secara terbuka perencanaan dan realisasi penggunaan APBN serta Dana Desa Nagari Koto Kaciak Barat Tahun Anggaran ' . ($data['apbn']['tahun'] ?? '2026') . '.',
        ];

        // Ensure banner defaults exist
        $data['banner'] = $data['banner'] ?? [
            'image' => asset('images/banner.png'),
            'badge' => 'Selamat Datang',
            'title' => $data['header']['site_name'] ?? 'Nagari Koto Kaciak Barat',
            'subtitle' => $data['hero_subtitle'] ?? '',
        ];

        // Ensure new fields exist with defaults
        $data['header'] = $data['header'] ?? [
            'site_name' => 'Nagari Koto Kaciak Barat',
            'site_subtitle' => 'Kec. Bonjol, Kab. Pasaman',
            'nav_items' => "Profil|#profil\nPerangkat|#perangkat\nPelayanan|#pelayanan\nBerita|#berita\nLayanan|#layanan\nPeraturan|#peraturan\nAPBN|#apbn\nData Warga|#data-warga\nKontak|#kontak\nPeta|#peta",
        ];

        $data['content_sections'] = $data['content_sections'] ?? [
            'profile' => [
                'title' => 'Profil Nagari Koto Kaciak Barat',
                'description' => 'Nagari Koto Kaciak Barat berkomitmen menjadi nagari digital yang transparan.',
            ],
            'devices' => [
                'title' => 'Pejabat Utama dan Perangkat Nagari',
                'description' => 'Daftar pejabat utama dan perangkat nagari.',
            ],
            'news' => [
                'title' => 'Berita Terkini dan Pengumuman',
                'description' => 'Informasi terkini seputar kegiatan nagari.',
            ],
            'services' => [
                'title' => 'Layanan Nagari yang Mudah dan Terpercaya',
                'description' => 'Berbagai layanan publik yang tersedia.',
            ],
            'regulations' => [
                'title' => 'Dokumen Resmi Nagari',
                'description' => 'Akses mudah ke peraturan dan kebijakan nagari.',
            ],
            'contact' => [
                'title' => 'Temui Tim Nagari dan Dapatkan Bantuan',
                'description' => 'Kantor Nagari siap melayani aspirasi dan permohonan dokumen.',
            ],
        ];

        $data['buttons'] = $data['buttons'] ?? [
            'hero_primary' => [
                'text' => 'Baca Berita Terbaru',
                'link' => '#berita',
            ],
            'hero_secondary' => [
                'text' => 'Lihat Layanan Publik',
                'link' => '#layanan',
            ],
            'contact' => [
                'text' => 'Hubungi',
            ],
            'edit_profile' => [
                'text' => 'Edit Profil',
            ],
        ];

        return $data;
    }

private function loadApbnData(): array
    {
        $dataPath = public_path('data/apbn.json');
        $apbn = [];
        if (file_exists($dataPath)) {
            try {
                $json = file_get_contents($dataPath);
                $decoded = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
                if (is_array($decoded)) {
                    $apbn = $decoded;
                }
            } catch (\Throwable $e) {
                $apbn = [];
            }
        }

        return $apbn;
    }

    private function loadWargaStatistics(): array
    {
        $totalWarga = Warga::count();
        $totalWargaHidup = Warga::where('is_wafat', false)->count();
        $totalWargaWafat = Warga::where('is_wafat', true)->count();
        $totalKK = KartuKeluarga::count();
        $totalJorong = Jorong::count();

        // Per-jorong breakdown
        $perJorong = Jorong::withCount('wargas')->withCount('kartuKeluargas')
            ->orderBy('nama_jorong')
            ->get()
            ->map(function ($jorong) {
                return [
                    'nama' => $jorong->nama_jorong,
                    'jumlah_warga' => $jorong->wargas_count,
                    'jumlah_kk' => $jorong->kartu_keluargas_count,
                ];
            })->values()->toArray();

        // Gender breakdown (men/women)
        $lakiLaki = Warga::where('jenis_kelamin', 'Laki-laki')->count();
        $perempuan = Warga::where('jenis_kelamin', 'Perempuan')->count();

        return [
            'total_warga' => $totalWarga,
            'total_warga_hidup' => $totalWargaHidup,
            'total_warga_wafat' => $totalWargaWafat,
            'total_kk' => $totalKK,
            'total_jorong' => $totalJorong,
            'laki_laki' => $lakiLaki,
            'perempuan' => $perempuan,
            'per_jorong' => $perJorong,
        ];
    }

    private function loadProfileRawData(): array
    {
        $defaults = [
            'hero_title' => 'Membangun Nagari yang Ramah, Informasi Terupdate, dan Layanan Cepat.',
            'hero_subtitle' => 'Temukan berita nagari, layanan publik, peraturan daerah, dan profil pemerintahan dalam satu tampilan modern yang mudah digunakan oleh semua warga.',
            'stats_text' => "Warga|1.200+\nBerita|45\nLayanan|12",
            'devices_text' => "Reza Fahlevi, S.H., M.H.|Wali Nagari Koto Kaciak Barat|" . asset('images/walinagari.jpeg') . "\nAndres, S.T.|Sekretaris Nagari|" . asset('images/sekna.jpeg') . "\nDendi Handra, S.E.I.|Kasi Pemerintahan|" . asset('images/kasipem.jpeg') . "\nNingsi Fricilia|Kasi Kesra & Pelayanan|" . asset('images/kaskespel.jpeg') . "\nNike Ardila, S.H.I.|Kaur Keuangan|" . asset('images/kaurkeu.jpeg') . "\nNoor Liza, S. Pd.|Kaur Umum & Perencanaan|" . asset('images/kaurumper.jpeg') . "\nImelda|Staff Keuangan|" . asset('images/staffkeu.jpeg') . "\nSarullah|Wali Jorong Lungguk Batu|" . asset('images/wajoronglunggukbatu.jpeg') . "\nSuhardi|Wali Jorong Parik Gadang|" . asset('images/wajorongparikgadang.jpeg') . "\nReza Fahlevi|Wali Jorong Kampung Hangus|" . asset('images/wajorongkampunghangus.jpeg') . "\nDawardi|Wali Jorong Batu Hampar|" . asset('images/wajorongbatuhampar.jpeg') . "",
            'news_text' => "24 Juli 2026|Berita|Pelatihan UMKM Nagari Sukses|Dinas nagari menggelar pelatihan pemasaran digital untuk pelaku usaha kecil dan menengah.|https://images.unsplash.com/photo-1519337265831-281ec6cc8514?auto=format&fit=crop&w=800&q=80\n18 Juli 2026|Agenda|Festival Budaya Nagari|Ajang kebudayaan dan seni lokal hadir untuk mempromosikan tradisi dan kreativitas warga.|https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=800&q=80\n12 Juli 2026|Informasi|Perubahan Jadwal Pasar Mingguan|Pengumuman resmi jam operasional dan protokol kesehatan pasar nagari.|https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=800&q=80",
            'services_text' => "📄|Surat Keterangan|Proses cepat untuk surat keterangan domisili, usaha, dan administrasi lainnya.\n🗳|Pelayanan Desa|Informasi pendaftaran program pemerintah dan agenda musyawarah nagari.\n💬|Pengaduan Online|Laporkan keluhan dan saran langsung ke kantor nagari dengan mudah.\n📣|Informasi Publik|Akses data nagari, pengumuman, dan peraturan dalam satu halaman.",
            'regulations_text' => "Peraturan Nagari 2026|Aturan terbaru tentang tata ruang, lingkungan, dan pelayanan publik nagari.\nPanduan Layanan|Alur layanan administrasi dan syarat dokumen untuk warga nagari.\nSK Kepala Nagari|Keputusan terbaru kepala nagari tentang program pemberdayaan masyarakat.",
            'contact' => [
                'address' => 'Jalan Raya Nagari No.12, Koto Kaciak Barat, Kabupaten Pasaman, Sumatera Barat.',
                'phone' => '(0753) 20202, 20281',
                'email' => 'admin@nagari.go.id',
            ],
            'profile' => [
                'visi' => 'Nagari Sejahtera dan Inovatif',
                'misi' => 'Menyediakan layanan publik prima, membangun infrastruktur unggul, serta mendukung UMKM dan budaya lokal.',
                'nilai' => 'Mendorong kolaborasi warga, transparansi, dan pembangunan yang berkelanjutan di nagari.',
                'sejarah' => '',
                'wilayah' => '',
            ],
            'header' => [
                'site_name' => 'Nagari Koto Kaciak Barat',
                'site_subtitle' => 'Kec. Bonjol, Kab. Pasaman',
                'nav_items' => "Profil|#profil\nPerangkat|#perangkat\nPelayanan|#pelayanan\nBerita|#berita\nLayanan|#layanan\nPeraturan|#peraturan\nAPBN|#apbn\nData Warga|#data-warga\nKontak|#kontak\nPeta|#peta",
            ],
            'content_sections' => [
                'profile' => [
                    'title' => 'Profil Nagari Koto Kaciak Barat',
                    'description' => 'Nagari Koto Kaciak Barat berkomitmen menjadi nagari digital yang transparan, berdaya saing, dan memberikan layanan maksimal untuk semua lapisan masyarakat.',
                ],
                'devices' => [
                    'title' => 'Pejabat Utama dan Perangkat Nagari',
                    'description' => 'Daftar pejabat utama dan perangkat nagari yang memimpin pelayanan publik serta pembangunan di Koto Kaciak Barat.',
                ],
                'news' => [
                    'title' => 'Berita Terbaru',
                    'description' => 'Informasi terkini seputar kegiatan nagari, pengumuman resmi, dan berita penting untuk warga.',
                ],
                'services' => [
                    'title' => 'Layanan Publik',
                    'description' => 'Berbagai layanan publik yang tersedia untuk mempermudah administrasi warga nagari.',
                ],
                'regulations' => [
                    'title' => 'Peraturan Daerah',
                    'description' => 'Kumpulan peraturan dan kebijakan nagari untuk menciptakan ketertiban dan keadilan.',
                ],
                'contact' => [
                    'title' => 'Hubungi Kami',
                    'description' => 'Sampaikan pertanyaan, saran, atau keluhan Anda melalui kontak yang tersedia.',
                ],
            ],
            'buttons' => [
                'hero_primary' => [
                    'text' => 'Baca Berita Terbaru',
                    'link' => '#berita',
                ],
                'hero_secondary' => [
                    'text' => 'Lihat Layanan Publik',
                    'link' => '#layanan',
                ],
                'contact' => [
                    'text' => 'Hubungi',
                ],
                'edit_profile' => [
                    'text' => 'Edit Profil',
                ],
            ],
        ];

        $loaded = [];
        if (Storage::disk('local')->exists('profile_data.json')) {
            try {
                $raw = Storage::disk('local')->get('profile_data.json');
                $loaded = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
            } catch (\Throwable $exception) {
                $loaded = [];
            }
        }

        return array_merge($defaults, $loaded);
    }

    private function parseLines(string $text, int $fieldsPerLine, string $type = 'stat'): array
    {
        $text = trim($text);

        // Support legacy pipe-delimited lines and newer JSON arrays for news
        if ($type === 'news' && strlen($text) > 0 && ($text[0] === '[' || $text[0] === '{')) {
            try {
                $decoded = json_decode($text, true, 512, JSON_THROW_ON_ERROR);
                $result = array_map(function ($it) {
                    return [
                        'date' => $it['date'] ?? '',
                        'type' => $it['type'] ?? '',
                        'title' => $it['title'] ?? '',
                        'summary' => $it['summary'] ?? '',
                        'image' => $it['image'] ?? '',
                        'body' => $it['body'] ?? '',
                        'id' => $it['id'] ?? null,
                    ];
                }, is_array($decoded) ? $decoded : []);

                return $result;
            } catch (\Throwable $e) {
                // fall through to legacy parsing
            }
        }

        $lines = preg_split('/\r?\n/', $text);
        $result = [];

        foreach ($lines as $line) {
            $columns = array_map('trim', explode('|', $line));
            if (count($columns) < $fieldsPerLine) {
                continue;
            }

            if ($fieldsPerLine === 2 && $type === 'stat') {
                $result[] = ['label' => $columns[0], 'value' => $columns[1]];
            } elseif ($fieldsPerLine === 2 && $type === 'regulation') {
                $result[] = ['title' => $columns[0], 'description' => $columns[1]];
            } elseif ($fieldsPerLine === 3 && $type === 'device') {
                $result[] = ['name' => $columns[0], 'position' => $columns[1], 'image' => $columns[2]];
            } elseif ($fieldsPerLine === 3 && $type === 'service') {
                $result[] = ['icon' => $columns[0], 'title' => $columns[1], 'description' => $columns[2]];
            } elseif ($fieldsPerLine === 5) {
                $result[] = ['date' => $columns[0], 'type' => $columns[1], 'title' => $columns[2], 'summary' => $columns[3], 'image' => $columns[4], 'body' => ''];
            }
        }

        return $result;
    }

    public function newsPage()
    {
        // Fetch all news items ordered by date descending
        $allNews = \App\Models\News::orderBy('date', 'desc')->get();
        $paginator = \App\Models\News::orderBy('date', 'desc')->paginate(9);

        // Categories aggregation
        $categories = [];
        $categoryColors = [
            'Berita' => '#047857',
            'Agenda' => '#dc2626',
            'Informasi' => '#2563eb',
            'Pengumuman' => '#d97706',
            'Kegiatan' => '#7c3aed',
            'Umum' => '#64748b',
        ];
        foreach ($allNews as $item) {
            $type = $item->type ?? 'Umum';
            if (!isset($categories[$type])) {
                $categories[$type] = 0;
            }
            $categories[$type]++;
        }

        // Featured items (first 5)
        $featured = $allNews->take(5);

        // Trending (first 5 recent)
        $trending = $allNews->take(5);

        $newsCount = $allNews->count();

        return view('news_page', [
            'news' => $paginator->items(),
            'featured' => $featured,
            'paginator' => $paginator,
            'heroTitle' => 'Berita Nagari',
            'heroSubtitle' => 'Semua informasi terbaru, agenda, dan pengumuman nagari dalam satu halaman.',
            'categories' => $categories,
            'categoryColors' => $categoryColors,
            'trending' => $trending,
            'newsCount' => $newsCount,
        ]);

    }

    public function newsDetail($id)
    {
        // Retrieve the news item by its primary key (or abort 404)
        $item = \App\Models\News::findOrFail($id);

        // Recent news for sidebar or related section (latest 5)
        $recent = \App\Models\News::orderBy('date', 'desc')->take(5)->get();

        // Determine previous and next items based on date ordering
                // Determine previous and next items based on date ordering, handling possible null dates
        $prev = null;
        $next = null;
        if ($item->date) {
            $prevModel = \App\Models\News::where('date', '<', $item->date)
                ->orderBy('date', 'desc')
                ->first();
            $nextModel = \App\Models\News::where('date', '>', $item->date)
                ->orderBy('date', 'asc')
                ->first();
            $prev = $prevModel ? $prevModel->id : null;
            $next = $nextModel ? $nextModel->id : null;
        }

        return view('news_detail', [
            'item' => $item,
            'recent' => $recent,
            'prev' => $prev,
            'next' => $next,
        ]);
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'] ?? 'Pesan dari Kontak Kami',
            'message' => $validated['message'],
            'status' => 'unread',
        ]);

        return Redirect::back()->with('success', 'Pesan Anda berhasil dikirim ke Kantor Wali Nagari. Terima kasih!');
    }
}
