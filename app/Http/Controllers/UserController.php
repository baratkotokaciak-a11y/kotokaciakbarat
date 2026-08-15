<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jorong;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    use LogsActivity;
    // Middleware applied at route level

    public function index()
    {
        $users = User::with('jorong')->orderBy('created_at', 'desc')->paginate(10);
        $jorongs = Jorong::active()->orderBy('nama_jorong')->get();
        
        return view('users.index', compact('users', 'jorongs'));
    }

    public function create()
    {
        $jorongs = Jorong::active()->orderBy('nama_jorong')->get();
        return view('users.create', compact('jorongs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,wali_jorong,wali_nagari,news_editor',
            'jorong_id' => 'nullable|exists:jorongs,id|required_if:role,wali_jorong',
            'phone' => 'nullable|string|max:20',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        
        // If role is wali_jorong but no jorong_id selected, use the user's jorong
        if ($validated['role'] === 'wali_jorong' && empty($validated['jorong_id'])) {
            unset($validated['jorong_id']);
        }

        $user = User::create($validated);

        // Log activity
        $this->logCreate($user, "Menambahkan user: {$user->name} ({$user->role})");

        return redirect()->route('users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        $user->load('jorong');
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $jorongs = Jorong::active()->orderBy('nama_jorong')->get();
        return view('users.edit', compact('user', 'jorongs'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,wali_jorong,wali_nagari,news_editor',
            'jorong_id' => 'nullable|exists:jorongs,id|required_if:role,wali_jorong',
            'phone' => 'nullable|string|max:20',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // If role is wali_jorong but no jorong_id selected, use the user's jorong
        if ($validated['role'] === 'wali_jorong' && empty($validated['jorong_id'])) {
            unset($validated['jorong_id']);
        }

        // If role is not wali_jorong, clear jorong_id
        if ($validated['role'] !== 'wali_jorong') {
            $validated['jorong_id'] = null;
        }

        $oldValues = $user->toArray();
        $user->update($validated);

        // Log activity
        $this->logUpdate($user, $oldValues, "Memperbarui user: {$user->name}");

        return redirect()->route('users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        // Prevent deleting the last admin
        if ($user->isAdmin() && User::where('role', 'admin')->count() <= 1) {
            return back()->with('error', 'Tidak dapat menghapus admin terakhir.');
        }

        // Prevent self-deletion
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        // Log activity
        $this->logDelete($user, "Menghapus user: {$user->name}");

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }

    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            $this->logLogin();
            
            $user = auth()->user();

            // After successful authentication, redirect based on role
            if ($user->isAdmin()) {
                return redirect()->route('warga.index');
            }
            if ($user->isWaliNagari()) {
                return redirect()->route('wali-nagari.dashboard');
            }
            if ($user->isNewsEditor()) {
                return redirect()->route('news.index');
            }
            return redirect()->intended(route('warga.index'));
        }

        return back()->with('error', 'Email atau password salah.');
    }

    public function logout(Request $request)
    {
        $this->logLogout();
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login');
    }
}
