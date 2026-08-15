<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Jorong;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'jorong_id',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function jorong()
    {
        return $this->belongsTo(Jorong::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isWaliJorong(): bool
    {
        return $this->role === 'wali_jorong';
    }

    public function isWaliNagari(): bool
    {
        return $this->role === 'wali_nagari';
    }

    public function isNewsEditor(): bool
    {
        return $this->role === 'news_editor';
    }

    public function hasAccessToJorong($jorongId): bool
    {
        if ($this->isAdmin() || $this->isWaliNagari()) {
            return true;
        }
        
        return $this->isWaliJorong() && $this->jorong_id == $jorongId;
    }

    public function getAccessibleJorongs()
    {
        if ($this->isAdmin() || $this->isWaliNagari()) {
            return Jorong::all();
        }
        
        return Jorong::where('id', $this->jorong_id)->get();
    }

    public function canViewActivityLogs(): bool
    {
        return $this->isAdmin() || $this->isWaliNagari();
    }

    public function canDeleteActivityLogs(): bool
    {
        return $this->isAdmin();
    }
}
