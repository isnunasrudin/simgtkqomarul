<?php

namespace App\Http\Controllers;

use App\Models\Gtk;
use App\Models\GtkContract;
use App\Models\Ref\TugasTambahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GtkContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Gtk $gtk)
    {
        $contracts = $gtk->contracts()->latest()->get();
        return view('gtkContract.index', compact('gtk', 'contracts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Gtk $gtk)
    {
        //
        $data = $request->validate([
            'type' => 'required|in:GURU,TU',
            'reference_number' => 'required',
            'issued_date' => 'required',
            'effective_date' => 'required',
            'expired_date' => 'nullable',
            'mapel' => 'nullable',
            'mapel_point' => 'nullable',
            'secondary_job_id' => 'nullable|exists:tugas_tambahan,id',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'is_primary' => 'nullable',
        ]);

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('contracts', 'public');
        }

        if ($request->secondary_job_id) {
            $secondaryJob = TugasTambahan::find($request->secondary_job_id);
            $data['secondary_job'] = $secondaryJob->name;
            $data['secondary_job_point'] = $secondaryJob->point;
        }

        $data['satuan_kerja_id'] = $gtk->satuan_kerja_id;

        $gtk->contracts()->create($data);

        return redirect()->back()->with('success', 'Kontrak berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gtk $gtk, GtkContract $contract)
    {
        return response()->json([
            'gtk' => $gtk,
            'contract' => $contract,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gtk $gtk, GtkContract $contract)
    {
        //
        $data = $request->validate([
            'type' => 'required|in:GURU,TU',
            'reference_number' => 'required',
            'issued_date' => 'required',
            'effective_date' => 'required',
            'expired_date' => 'nullable',
            'mapel' => 'nullable',
            'mapel_point' => 'nullable',
            'secondary_job' => 'nullable',
            'secondary_job_point' => 'nullable',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'is_primary' => 'nullable',
        ]);

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('contracts', 'public');
        }

        if ($request->secondary_job_id) {
            $secondaryJob = TugasTambahan::find($request->secondary_job_id);
            $data['secondary_job'] = $secondaryJob->name;
            $data['secondary_job_point'] = $secondaryJob->point;
        }

        $data['satuan_kerja_id'] = $gtk->satuan_kerja_id;

        $contract->update($data);

        return redirect()->back()->with('success', 'Kontrak berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gtk $gtk, GtkContract $contract)
    {
        $contract->delete();
        return redirect()->back()->with('success', 'Kontrak berhasil dihapus');
    }

    public function activate(Gtk $gtk, GtkContract $contract)
    {
        $gtk->contracts()->whereNot('id', $contract->id)->update([
            'is_primary' => false,
        ]);
        $contract->update([
            'is_primary' => true,
        ]);
        return redirect()->back()->with('success', 'Kontrak berhasil diaktifkan');
    }
}
