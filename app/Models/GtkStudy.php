<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GtkStudy extends Model
{
    protected $fillable = [
        'level',
        'institution',
        'major',
        'graduation_year',
        'certificate_number',
        'gtk_id',
        'file',
        'is_primary'
    ];

    public function gtk()
    {
        return $this->belongsTo(Gtk::class);
    }
}
