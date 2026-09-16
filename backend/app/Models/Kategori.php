<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $fillable = [
        'nama_kategori'
    ];

    public function alat(): HasMany {
        return $this->hasMany(Alat::class);
    }
}
