<?php

namespace App\Http\Controllers\Ref;

use App\Http\Controllers\Controller;
use App\Models\Ref\TugasTambahan;
use Illuminate\Http\Request;

class TugasTambahanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allTugasTambahan = TugasTambahan::all();

        return view('ref.tugas_tambahan', compact('allTugasTambahan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'point' => 'required|numeric',
        ]);

        TugasTambahan::create($data);

        return redirect()->back()->with('success', 'Tugas Tambahan berhasil ditambahkan');
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
    public function update(Request $request, TugasTambahan $tugasTambahan)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'point' => 'required|numeric',
        ]);

        $tugasTambahan->update($data);

        return redirect()->back()->with('success', 'Tugas Tambahan berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TugasTambahan $tugasTambahan)
    {
        $tugasTambahan->delete();

        return redirect()->back()->with('success', 'Tugas Tambahan berhasil dihapus');
    }
}
