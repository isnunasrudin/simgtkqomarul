<?php

namespace App\Models;

use App\Models\Ref\TugasTambahan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gtk extends Model
{
    use SoftDeletes;

    protected $table = 'gtk';

    protected $fillable = [
        'type',
        'nik',
        'name',
        'gender',
        'kawin',
        'duk',
        'nuptk',
        'nigy',
        'birth_place',
        'birth_date',
        'tmt_yayasan',
        'tmt_satker',
        'rt',
        'rw',
        'dusun',
        'desa',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'photo',
        'satuan_kerja_id',
        'user_id',
        'tugas_tambahan_id',
        'mapel',
        'mapel_point',
    ];

    protected static function boot()
    {
        parent::boot();

        static::updated(function ($gtk) {
            if ($gtk->isDirty('name') || $gtk->isDirty('user_id')) {
                $gtk->user->name = $gtk->name;
                $gtk->user->save();
            }
        });
    }

    public function satuanKerja()
    {
        return $this->belongsTo(SatuanKerja::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function inpassings()
    {
        return $this->hasMany(GtkInpassing::class);
    }

    public function studies()
    {
        return $this->hasMany(GtkStudy::class);
    }

    public function activeStudy()
    {
        return $this->hasOne(GtkStudy::class)->where('is_primary', true);
    }

    public function certifications()
    {
        return $this->hasMany(GtkCertification::class);
    }

    public function contracts()
    {
        return $this->hasMany(GtkContract::class);
    }

    public function activeContract()
    {
        return $this->hasOne(GtkContract::class)->where('is_primary', true);
    }

    public function tugasTambahan()
    {
        return $this->belongsTo(TugasTambahan::class);
    }
}
