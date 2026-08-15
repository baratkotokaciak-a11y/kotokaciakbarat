<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class APBNController extends Controller
{
    /**
     * Show the public APBN transparency page.
     */
    public function index()
    {
        // Load APBN data from JSON file in public/data
        $dataPath = public_path('data/apbn.json');
        $apbn = [];
        if (file_exists($dataPath)) {
            $json = file_get_contents($dataPath);
            $apbn = json_decode($json, true);
        }
        // Pass data to the view
        return view('public.apbn', ['apbn' => $apbn]);
    }

    /**
     * Show the admin APBN input form.
     */
    public function edit()
    {
        $apbn = $this->loadApbnData();

        return view('apbn.edit', ['apbn' => $apbn]);
    }

    /**
     * Store the APBN data submitted from the admin form.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tahun' => ['required', 'string', 'max:20'],
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string', 'max:2000'],
            'total_anggaran' => ['required', 'numeric'],
            'total_realisasi' => ['required', 'numeric'],
        ]);

        $data = [
            'tahun' => $request->input('tahun'),
            'judul' => $request->input('judul'),
            'deskripsi' => $request->input('deskripsi'),
            'total_anggaran' => (int) round((float) $request->input('total_anggaran')),
            'total_realisasi' => (int) round((float) $request->input('total_realisasi')),
            'sumber_dana' => $this->collectRows($request, 'sumber_dana', ['nama', 'anggaran', 'realisasi']),
            'bidang' => $this->collectRows($request, 'bidang', ['nama', 'anggaran', 'realisasi']),
            'program' => $this->collectRows($request, 'program', ['nama', 'bidang', 'anggaran', 'realisasi', 'status', 'keterangan']),
            'jorong' => $this->collectRows($request, 'jorong', ['nama', 'anggaran', 'realisasi']),
        ];

        $this->saveApbnData($data);

        return redirect()->route('apbn.edit')->with('success', 'Data APBN berhasil disimpan.');
    }

    /**
     * Normalize a dynamic set of rows from the request.
     */
    private function collectRows(Request $request, string $key, array $fields): array
    {
        $rows = $request->input($key, []);
        $result = [];

        foreach ($rows as $row) {
            $item = [];
            foreach ($fields as $field) {
                $value = $row[$field] ?? '';
                if (in_array($field, ['anggaran', 'realisasi'], true)) {
                    $item[$field] = $value !== '' ? (int) round((float) $value) : 0;
                } else {
                    $item[$field] = trim((string) $value);
                }
            }

            // Skip completely empty rows
            $hasValue = false;
            foreach ($item as $val) {
                if ($val !== '' && $val !== 0 && $val !== null) {
                    $hasValue = true;
                    break;
                }
            }

            if ($hasValue) {
                $result[] = $item;
            }
        }

        return $result;
    }

    /**
     * Load APBN data from the JSON file.
     */
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

    /**
     * Save APBN data to the JSON file.
     */
    private function saveApbnData(array $data): void
    {
        $dataPath = public_path('data/apbn.json');
        $dir = dirname($dataPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        file_put_contents($dataPath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }
}
