<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /* Cek Middleware */
    public function role() {
        return $this->belongsTo(Role::class, 'role_id');
    }

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
        'jabatan',
        'nim_nip',
        'divisi',
        'avatar',
    ];

    // ── Jabatan urutan TTD ───────────────────────────────────────────────────
    // Menentukan di langkah ke berapa user ini bisa TTD proposal
    const TTD_ORDER = [
        'ketua_panitia'   => 1,
        'sekretaris'      => 2,
        'ketua_hmse'      => 3,
        'pembina'         => 4,
        'kaprodi'         => 5,
    ];

    /** Apakah user ini bisa TTD proposal? */
    public function canSign(): bool
    {
        return array_key_exists($this->jabatan, self::TTD_ORDER);
    }

    /** Urutan TTD user ini (null jika tidak bisa TTD) */
    public function ttdOrder(): ?int
    {
        return self::TTD_ORDER[$this->jabatan] ?? null;
    }

    /** Label jabatan yang ditampilkan ke user */
    public function jabatanLabel(): string
    {
        return match($this->jabatan) {
            'ketua_hmse'      => 'Ketua HMSE',
            'wakil_ketua_hmse'=> 'Wakil Ketua HMSE',
            'sekretaris'      => 'Sekretaris HMSE',
            'bendahara'       => 'Bendahara HMSE',
            'ketua_panitia'   => 'Ketua Panitia',
            'head_divisi'     => 'Head of Division',
            'staff'           => 'Staff',
            'pembina'         => 'Pembina HMSE',
            'kaprodi'         => 'Kaprodi RPL',
            default           => ucfirst(str_replace('_', ' ', $this->jabatan ?? 'Pengurus')),
        };
    }

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

    /**
     * Get all proposals created by this user
     */
    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }
}
