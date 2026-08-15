<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\KartuKeluarga;
use App\Models\Jorong;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class DataNagariController extends Controller
{
    /**
     * Display the admin data-nagari dashboard.
     */
    public function index()
    {
        // Basic statistics for the Nagari
        $totalWarga = Warga::count();
        $totalKK = KartuKeluarga::count();
        $totalJorong = Jorong::count();

        // Recent contact messages for admin overview
        $messages = ContactMessage::orderBy('created_at', 'desc')->take(10)->get();

        return view('data-nagari.index', compact('totalWarga', 'totalKK', 'totalJorong', 'messages'));
    }
}
