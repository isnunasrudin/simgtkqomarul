<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GtkInpassing extends Model
{
    protected $fillable = [
        'sk_number',
        'sk_date',
        'rank_group',
        'credit_score',
        'tmt_inpassing',
        'file',
        'gtk_id',
    ];

    public function gtk()
    {
        return $this->belongsTo(Gtk::class);
    }
}
