<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // Mengizinkan semua kolom diisi (atau tentukan kolom tertentu)
    protected $guarded = [];

    // Jika kamu ingin mendefinisikan relasi ke User (Opsional tapi bagus untuk kedepannya)
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
