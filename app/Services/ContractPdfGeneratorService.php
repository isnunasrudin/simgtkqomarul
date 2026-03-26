<?php

namespace App\Services;

use App\Models\GtkContract;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ContractPdfGeneratorService
{
    public function __construct(
        public ?string $nomor_sk = null,
        public ?string $tmt = null,
        public ?string $nama = null,
        public ?string $nigy = null,
        public ?string $tempat_lahir = null,
        public ?string $tanggal_lahir = null,
        public ?string $pendidikan = null,
        public ?string $jurusan = null,
        public ?string $jabatan = null,
        public ?string $diangkat_sebagai = null,
        public ?string $satker = null,
        public ?string $tmt_yayasan = null,
        public ?string $tmt_satker = null,
        public ?string $masa_kerja_tahun = null,
        public ?string $masa_kerja_bulan = null,
        public ?string $ditetapkan_tanggal = null,
        public string $ditetapkan_di = 'Trenggalek',
        public string $kepala_sekolah = 'Hj. ZUMROTUN NASIHAH',
        public ?string $nomor_reg = null,
        public bool $sudah_ttd = false
    ) {}

    public function generate(): DomPDFPDF
    {
        $data = [
            'nomor_sk' => $this->nomor_sk,
            'tmt' => $this->tmt,
            'nama' => $this->nama,
            'nigy' => $this->nigy,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'pendidikan' => $this->pendidikan,
            'jurusan' => $this->jurusan,
            'jabatan' => $this->jabatan,
            'diangkat_sebagai' => $this->diangkat_sebagai,
            'satker' => $this->satker,
            'tmt_yayasan' => $this->tmt_yayasan,
            'tmt_satker' => $this->tmt_satker,
            'masa_kerja_tahun' => $this->masa_kerja_tahun,
            'masa_kerja_bulan' => $this->masa_kerja_bulan,
            'ditetapkan_tanggal' => $this->ditetapkan_tanggal,
            'ditetapkan_di' => $this->ditetapkan_di,
            'kepala_sekolah' => $this->kepala_sekolah,
            'nomor_reg' => $this->nomor_reg,
            'sudah_ttd' => $this->sudah_ttd
        ];

        return Pdf::loadView('pdf.sk', $data)->setPaper([0, 0, 595.28, 935.43]);
    }

    public static function fromContract(GtkContract $contract, bool $sudah_ttd = false): self
    {
        return new self(
            nomor_sk: $contract->reference_number,
            tmt: Carbon::parse($contract->effective_date)->translatedFormat('d F Y'),
            nama: $contract->gtk->name,
            nigy: $contract->gtk->nigy,
            tempat_lahir: $contract->gtk->birth_place,
            tanggal_lahir: Carbon::parse($contract->gtk->birth_date)->translatedFormat('d F Y'),
            pendidikan: $contract->gtk->activeStudy?->level,
            jurusan: $contract->gtk->activeStudy?->major,
            jabatan: $contract->type == 'GURU' ? ('Guru ' . $contract->mapel) : 'Tenaga Kependidikan',
            diangkat_sebagai: $contract->type == 'GURU' ? 'Guru Tetap Yayasan' : 'Tenaga Pendidik Yayasan',
            satker: $contract->satuan_kerja->name,
            tmt_yayasan: Carbon::parse($contract->gtk->tmt_yayasan)->translatedFormat('d F Y'),
            tmt_satker: Carbon::parse($contract->gtk->tmt_satker)->translatedFormat('d F Y'),
            masa_kerja_tahun: (int)Carbon::parse($contract->gtk->tmt_yayasan)->diffInYears(),
            masa_kerja_bulan: Carbon::parse($contract->gtk->tmt_yayasan)->diffInMonths() % 12,
            ditetapkan_tanggal: Carbon::parse($contract->issued_date)->translatedFormat('d F Y'),
            nomor_reg: crc32($contract->id),
            sudah_ttd: $sudah_ttd
        );
    }

    public function store(GtkContract $contract): string
    {
        $pdf = $this->generate();
        $filename = ($this->sudah_ttd ? 'sk/' : 'sk_draft/') . crc32($contract->id) . '.pdf';
        Storage::disk('public')->put($filename, $pdf->output());

        return $filename;
    }
}
