<?php

namespace Database\Seeders;

use App\Models\SatuanKerja;
use Illuminate\Database\Seeder;

class SatuanKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'PAUD Qomarul Hidayah',
                'code' => '01'
            ],
            [
                'name' => 'RA Qomarul Hidayah',
                'code' => '02'
            ],
            [
                'name' => 'MIS Qomarul Hidayah',
                'code' => '03'
            ],
            [
                'name' => 'MTsS Qomarul Hidayah',
                'code' => '04'
            ],
            [
                'name' => 'MAS Qomarul Hidayah',
                'code' => '05'
            ],
            [
                'name' => 'SMKS Qomarul Hidayah 1',
                'code' => '06'
            ],
            [
                'name' => 'SMKS Qomarul Hidayah 2',
                'code' => '07'
            ],
            [
                'name' => 'MTM Qomarul Hidayah 1',
                'code' => '08'
            ],
            [
                'name' => 'TPQ Qomarul Hidayah',
                'code' => '09'
            ],
            [
                'name' => 'MTM Qomarul Hidayah 2',
                'code' => '10'
            ]
        ];

        foreach ($data as $item) {
            SatuanKerja::create($item);
        }
    }
}
