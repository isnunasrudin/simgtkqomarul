<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SatuanKerja extends Model
{
    protected $table = 'satuan_kerja';

    protected $fillable = [
        'name',
        'code',
        'picture',
    ];

    public function gtk()
    {
        return $this->hasMany(Gtk::class);
    }
}
