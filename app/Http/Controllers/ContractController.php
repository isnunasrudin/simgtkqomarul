<?php

namespace App\Http\Controllers;

use App\Models\Gtk;
use App\Models\GtkContract;
use App\Models\SatuanKerja;
use App\Services\ContractPdfGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ContractController extends Controller
{
    private function getYears()
    {
        $years = GtkContract::selectRaw('EXTRACT(YEAR FROM issued_date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
        if (!$years->contains(date('Y'))) {
            $years->push(date('Y'));
            $years = $years->sortDesc();
        }
        return $years;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $years = $this->getYears();

        if (!$request->input('year')) {
            return redirect()->route('contracts.index', ['year' => date('Y')]);
        };

        $contracts = GtkContract::whereYear('issued_date', $request->input('year'))->whereHas('gtk')->with('gtk.contracts', 'gtk.activeContract', 'gtk')->get();
        $gtks = Gtk::with('satuanKerja')->get()->groupBy('satuanKerja.name');
        $satker = SatuanKerja::all();
        return view('contracts.index', compact('contracts', 'years', 'gtks', 'satker'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function generate(Request $request, GtkContract $contract)
    {
        $pdf_draft = ContractPdfGeneratorService::fromContract($contract);
        $pdf = ContractPdfGeneratorService::fromContract($contract, true);

        $pdf_draft_path = $pdf_draft->store($contract);
        $pdf_path = $pdf->store($contract);

        $contract->update([
            'file_draft' => $pdf_draft_path,
            'file' => $pdf_path,
        ]);

        if($request->expectsJson()) {
            return response()->noContent();
        }

        return redirect()->back()->with('success', 'PDF berhasil di generate');
    }

    public function generateBatch(Request $request)
    {
        Gate::authorize('generate-batch-contract');

        // dd($request->all());

        $data = $request->validate([
            'year' => 'required|date_format:Y',
            'select_by' => 'required|in:satker,gtk',
            
            'satker_ids' => 'required_if:select_by,satker|array',
            'satker_ids.*' => 'exists:satuan_kerja,id',

            'gtk_ids' => 'required_if:select_by,gtk|array',
            'gtks_ids.*' => 'exists:gtk,id',

            'issued_date' => 'required',
            'effective_date' => 'required',
            'expired_date' => 'nullable',
        ]);

        // DB::beginTransaction();

        $gtks = Gtk::query();

        if ($data['select_by'] == 'satker') {
            $gtks->whereIn('satuan_kerja_id', $data['satker_ids']);
        } elseif ($data['select_by'] == 'gtk') {
            $gtks->whereIn('id', $data['gtk_ids']);
        }

        $gtks = $gtks->get();

        $contracts = [];

        foreach ($gtks as $gtk) {
            $no_sk = sprintf("YPP.QH/KP.01.%s/%s/%s", $gtk->satuanKerja->code, str($gtk->id)->padLeft(3, '0'), $data['year']);
            
            $contract = GtkContract::firstOrCreate([
                'reference_number' => $no_sk,
            ], [
                'type' => $gtk->type,
                'satuan_kerja_id' => $gtk->satuan_kerja_id,
                'gtk_id' => $gtk->id,
                'issued_date' => $data['issued_date'],
                'effective_date' => $data['effective_date'],
                'expired_date' => $data['expired_date'],
                'mapel' => $gtk->mapel,
                'mapel_point' => $gtk->mapel_point,
                'secondary_job' => $gtk->tugasTambahan?->name,
                'secondary_job_point' => $gtk->tugasTambahan?->point,
            ]);

            $contracts[] = $contract->id;

            // $this->generate($contract);
        }

        // DB::commit();

        return response()->json([
            'contracts' => $contracts,
        ]);
    }
}
