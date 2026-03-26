<?php

namespace App\Imports;

use App\Http\Controllers\GtkController;
use App\Models\Gtk;
use App\Models\Ref\TugasTambahan;
use App\Models\SatuanKerja;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStartRow;

class GtkImport implements ToModel, WithStartRow, WithCalculatedFormulas, WithMapping
{
    private $pass = 'QomarulJosJis';
    private $pass_hash;

    public function __construct()
    {
        $this->pass_hash = bcrypt($this->pass);
    }

    public function startRow(): int
    {
        return 8; // Data dimulai dari baris nomor 4
    }

    public function model(array $row)
    {
        if(!trim($row['nama'])) return null;
        
        $data = Gtk::create([
            'name' => $row['nama'],
            'type' => $row['status_pegawai'] == 'Tenaga Kependidikan' ? 'TU' : 'GURU',

            //ambil angka saja
            'nuptk' => preg_replace('/[^0-9]/', '', $row['nuptk']),
            'nigy' => preg_replace('/[^0-9]/', '', $row['nigy']),

            'birth_place' => ucwords(strtolower($row['tempat_lahir'])),
            'birth_date' => Carbon::create($row['thn_lahir'], $row['bln_lahir'], $row['tgl_lahir']),
            'tmt_yayasan' => Carbon::create($row['tmt_yay_thn'], $row['tmt_yay_bln'], $row['tmt_yay_tgl']),
            'tmt_satker' => Carbon::create($row['tmt_satker_thn'], $row['tmt_satker_bln'], $row['tmt_satker_tgl']),
            'satuan_kerja_id' => SatuanKerja::where('code', $this->_referensi($row['satker']))->first()->id,

            'tugas_tambahan_id' =>  $row['tugas_tambahan'] && $row['tugas_tambahan'] != '-' ? TugasTambahan::firstOrCreate([
                'name' => $row['tugas_tambahan']
            ], [
                'point' => preg_replace('/[^0-9]/', '', $row['ekuivalen']) ?: '0',
            ])->id : null,

            'mapel' => preg_replace('/guru\s?/i', '', $row['mengajar']),
            'mapel_point' => $row['jtm'],
            'duk' => $row['duk'],
        ]);

        $data->studies()->create([
            'level' => $this->_jenjang($row['jenjang']),
            'major' => $row['jurusan'],
            'graduation_year' => $row['tahun_lulus'],
            'is_primary' => true,
        ]);

        (new GtkController)->generateCredentials($data, $this->pass, $this->pass_hash);

        // dd($data->load('studies'));
    }

    private function _referensi($tingkat)
    {
        return match($tingkat) {
            'PAUD' => '01',
            'RA' => '02',
            'MI' => '03',
            'MTs' => '04',
            'MA' => '05',
            'SMK 1' => '06',
            'SMK 2' => '07',
            'MTM' => '08',
            'TPQ' => '09',
            'MTM 2' => '10',
        };
    }

    private function _jenjang($tingkat)
    {
        return match(strtoupper(preg_replace('/[^A-Z]/', '', $tingkat))) {
            'DI' => 'D1',
            'DII' => 'D2',
            'DIII' => 'D3',
            'DIV' => 'D4',
            default => $tingkat
        };
    }

    public function map($row): array
    {
        return ([
            'no'             => $row[0],  // A
            'satker'         => $row[1],  // B
            'duk'            => $row[3],  // D
            'status_pegawai' => $row[4],  // E
            'nama'           => $row[6],  // G
            'nigy'           => $row[7],  // H
            
            // TEMPAT TANGGAL LAHIR
            'tempat_lahir'   => $row[8],  // I (TEMPAT)
            'tgl_lahir'      => $row[9],  // J (TANGGAL)
            'bln_lahir'      => $row[10], // K (BULAN)
            'thn_lahir'      => $row[11], // L (TAHUN)
            
            // TMT YAYASAN
            'tmt_yay_tgl'    => $row[13], // N (Kolom M kosong/merged)
            'tmt_yay_bln'    => $row[14], // O
            'tmt_yay_thn'    => $row[15], // P
            
            // TMT SATKER
            'tmt_satker_tgl' => $row[16], // Q
            'tmt_satker_bln' => $row[17], // R
            'tmt_satker_thn' => $row[18], // S
            
            // MASA KERJA & PENDIDIKAN
            'jenjang'        => $row[23], // X
            'jurusan'        => $row[24], // Y
            'tahun_lulus'    => $row[25], // Z
            
            // INPASSING
            'inp_status'     => $row[26], // AA
            'inp_jabatan'    => $row[27], // AD
            'inp_pangkat'    => $row[28], // AF (Kolom AE kosong/merged)
            'inp_golongan'   => $row[29], // AI (Kolom AG & AH kosong/merged)
            
            // TUGAS UTAMA
            'mengajar'       => $row[30], // AJ
            'jtm'            => $row[31], // AM (Kolom AK & AL kosong/merged)
            'tugas_tambahan' => $row[32], // AO (Kolom AN kosong/merged)
            'ekuivalen'      => $row[33], // AQ (Kolom AP kosong/merged)
            'jml_beban'      => $row[34], // AS (Rumus penjumlahan)
            
            // SERTIFIKASI
            'sert_status'    => $row[35], // AT
            'sert_thn_lulus' => $row[36], // AU
            'nrg'            => $row[37], // AV
            'nuptk'          => $row[38], // AW
        ]);
    }
}
