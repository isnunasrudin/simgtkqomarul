<?php

namespace App\Models\Ref;

use Illuminate\Database\Eloquent\Model;

class TugasTambahan extends Model
{
    protected $table = 'tugas_tambahan';

    protected $fillable = [
        'name',
        'point',
    ];
}
