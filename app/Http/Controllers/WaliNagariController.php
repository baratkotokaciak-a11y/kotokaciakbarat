<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\KartuKeluarga;
use App\Models\Jorong;
use App\Models\ContactMessage;
use App\Models\ActivityLog;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class WaliNagariController extends Controller
{
    use LogsActivity;

    public function dashboard()
    {
        // 1. Core Population Stats
        $totalWarga = Warga::count();
        $wargaHidup = Warga::hidup()->count();
        $wargaWafat = Warga::wafat()->count();
        
        $totalKK = KartuKeluarga::count();
        $totalJorong = Jorong::count();

        // 2. Residency Stats
        $wargaTetap = Warga::tetap()->count();
        $wargaSementara = Warga::temporary()->count();

        // 3. Gender Stats
        $lakiLaki = Warga::where('jenis_kelamin', 'Laki-laki')->orWhere('jenis_kelamin', 'L')->count();
        $perempuan = Warga::where('jenis_kelamin', 'Perempuan')->orWhere('jenis_kelamin', 'P')->count();

        // 4. Per-Jorong Stats Breakdown
        $jorongStats = Jorong::withCount(['kartuKeluargas'])->get()->map(function ($jorong) use ($totalWarga) {
            $countWarga = Warga::whereHas('kartuKeluarga', function ($q) use ($jorong) {
                $q->where('jorong_id', $jorong->id);
            })->count();

            $percentage = $totalWarga > 0 ? round(($countWarga / $totalWarga) * 100, 1) : 0;

            return [
                'id' => $jorong->id,
                'nama' => $jorong->nama_jorong,
                'kode' => $jorong->kode_jorong,
                'kk_count' => $jorong->kartu_keluargas_count,
                'warga_count' => $countWarga,
                'percentage' => $percentage,
            ];
        });

        // 5. Contact Messages Overview
        $totalMessages = ContactMessage::count();
        $unreadMessagesCount = ContactMessage::unread()->count();
        $readMessagesCount = ContactMessage::read()->count();
        $repliedMessagesCount = ContactMessage::replied()->count();

        $recentMessages = ContactMessage::latest()->take(5)->get();

        // 6. Executive Activity Log (Recent 8 logs)
        $recentActivities = ActivityLog::with('user')->latest()->take(8)->get();

        // 7. Executive Summary Text Synthesis
        $summaryBrief = [
            'total_penduduk' => $totalWarga,
            'total_kk' => $totalKK,
            'persentase_tetap' => $totalWarga > 0 ? round(($wargaTetap / $totalWarga) * 100, 1) : 100,
            'jorong_terbanyak' => $jorongStats->sortByDesc('warga_count')->first()['nama'] ?? 'Utama',
            'pesan_perlu_tindakan' => $unreadMessagesCount,
        ];

        return view('wali-nagari.index', compact(
            'totalWarga',
            'wargaHidup',
            'wargaWafat',
            'totalKK',
            'totalJorong',
            'wargaTetap',
            'wargaSementara',
            'lakiLaki',
            'perempuan',
            'jorongStats',
            'totalMessages',
            'unreadMessagesCount',
            'readMessagesCount',
            'repliedMessagesCount',
            'recentMessages',
            'recentActivities',
            'summaryBrief'
        ));
    }

    public function messages(Request $request)
    {
        $query = ContactMessage::query();

        // Search filter
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Status filter
        $status = $request->input('status');
        if ($status && in_array($status, ['unread', 'read', 'replied'], true)) {
            $query->where('status', $status);
        }

        $messages = $query->latest()->paginate(10)->withQueryString();

        $totalCount = ContactMessage::count();
        $unreadCount = ContactMessage::unread()->count();
        $readCount = ContactMessage::read()->count();
        $repliedCount = ContactMessage::replied()->count();

        return view('wali-nagari.messages', compact(
            'messages',
            'totalCount',
            'unreadCount',
            'readCount',
            'repliedCount',
            'search',
            'status'
        ));
    }

    public function showMessage(ContactMessage $message)
    {
        if ($message->isUnread()) {
            $message->markAsRead();
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'formatted_date' => $message->created_at->format('d M Y H:i'),
        ]);
    }

    public function toggleRead(ContactMessage $message)
    {
        if ($message->status === 'unread') {
            $message->update([
                'status' => 'read',
                'read_at' => now(),
            ]);
            $msg = 'Pesan ditandai sebagai sudah dibaca.';
        } else {
            $message->update([
                'status' => 'unread',
                'read_at' => null,
            ]);
            $msg = 'Pesan ditandai sebagai belum dibaca.';
        }

        return redirect()->back()->with('success', $msg);
    }

    public function replyMessage(Request $request, ContactMessage $message)
    {
        $validated = $request->validate([
            'reply_notes' => 'required|string|max:2000',
        ]);

        $message->update([
            'reply_notes' => $validated['reply_notes'],
            'status' => 'replied',
            'replied_at' => now(),
        ]);

        $this->logUpdate($message, [], "Membalas/menindaklanjuti pesan kontak dari: {$message->name}");

        return redirect()->back()->with('success', 'Catatan balasan/tindak lanjut berhasil disimpan.');
    }

    public function destroyMessage(ContactMessage $message)
    {
        $senderName = $message->name;
        $message->delete();

        $this->logDelete($message, "Menghapus pesan kontak publik dari: {$senderName}");

        return redirect()->back()->with('success', 'Pesan kontak berhasil dihapus.');
    }
}
