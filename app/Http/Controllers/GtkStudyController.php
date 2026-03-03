<?php

namespace App\Http\Controllers;

use App\Models\Gtk;
use App\Models\GtkStudy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GtkStudyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Gtk $gtk)
    {
        $gtkStudies = $gtk->studies()->orderBy('graduation_year', 'desc')->get();
        return view('gtkStudy.index', compact('gtk', 'gtkStudies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Gtk $gtk)
    {
        $data = $request->validate([
            'level' => 'required|in:SD,SLTP,SLTA,D1,D2,D3,D4,S1,S2,S3',
            'jurusan' => 'nullable|string',
            'graduation_year' => 'required|date_format:Y',
            'certificate_number' => 'required|string',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'institution' => 'required|string',
        ]);

        if($request->file('file')) {
            $data['file'] = $request->file('file')->store('gtk-studies', 'public');
        }

        $gtk->studies()->create($data);

        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gtk $gtk, GtkStudy $study)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gtk $gtk, GtkStudy $study)
    {
        $study->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function activate(Gtk $gtk, GtkStudy $study)
    {
        DB::transaction(function () use ($gtk, $study) {
            $gtk->studies()->whereNot('id', $study->id)->update([
                'is_primary' => false,
            ]);
            $study->update([
                'is_primary' => true,
            ]);
        });

        return redirect()->back()->with('success', 'Data berhasil diaktifkan');
    }
}
