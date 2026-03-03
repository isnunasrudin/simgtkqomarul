<?php

namespace App\Http\Controllers;

use App\Models\GtkContract;
use App\Services\ContractPdfGeneratorService;
use Illuminate\Http\Request;

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
        return view('contracts.index', compact('contracts', 'years'));
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

    public function generate(GtkContract $contract)
    {
        $pdf_draft = ContractPdfGeneratorService::fromContract($contract);
        $pdf = ContractPdfGeneratorService::fromContract($contract, true);

        $pdf_draft_path = $pdf_draft->store($contract);
        $pdf_path = $pdf->store($contract);

        $contract->update([
            'file_draft' => $pdf_draft_path,
            'file' => $pdf_path,
        ]);

        return redirect()->back()->with('success', 'PDF berhasil di generate');
    }
}
