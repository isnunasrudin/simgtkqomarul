<?php

namespace App\Services;

use App\Models\Gtk;
use Carbon\Carbon;

class NigyGeneratorService
{
    public static function fromContract(Gtk $gtk)
    {
        //Kelahiran : Ymd
        //TMT Yayasan : Ym
        //Guru:01 TU:02
        //Kode Satker
        //Nomor Urut
        return sprintf(
            "%s%s%s%s%s",
            Carbon::parse($gtk->birth_date)->format('Ymd'),
            Carbon::parse($gtk->tmt_yayasan)->format('Ym'),
            $gtk->type == 'TU' ? '02' : '01',
            $gtk->satuanKerja->code,
            $gtk->duk ?? str($gtk->id)->padLeft(2, '0')
        );
    }
}
