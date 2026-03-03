<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GtkCertification extends Model
{
    protected $fillable = [
        'nrg',
        'certificate_number',
        'study',
        'graduation_year',
        'institution',
        'gtk_id',
    ];

    public function gtk()
    {
        return $this->belongsTo(Gtk::class);
    }
}
