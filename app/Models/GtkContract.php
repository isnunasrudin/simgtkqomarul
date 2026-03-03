<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GtkContract extends Model
{

    protected $fillable = [
        'reference_number',
        'issued_date',
        'effective_date',
        'expired_date',
        'file',
        'gtk_id',

        'mapel',
        'mapel_point',
        'secondary_job',
        'secondary_job_point',

        'is_primary',
        'type',
        'satuan_kerja_id',
        'is_trusted',
        'file_draft',
    ];

    protected static function booted()
    {
        static::updating(function ($model) {
            if ($model->isDirty('mapel')) {
                $model->mapel = preg_replace('/^guru\s?/i', '', $model->mapel);
            }
        });
    }

    public function gtk()
    {
        return $this->belongsTo(Gtk::class);
    }

    public function satuan_kerja()
    {
        return $this->belongsTo(SatuanKerja::class);
    }
}
