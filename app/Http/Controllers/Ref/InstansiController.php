<?php

namespace App\Http\Controllers\Ref;

use App\Http\Controllers\Controller;
use App\Models\SatuanKerja;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class InstansiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instansi = SatuanKerja::withCount('gtk')->orderBy('code', 'asc')->get();
        return view('ref.instansi', compact('instansi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|unique:satuan_kerja,code',
            'name' => 'required|unique:satuan_kerja,name',
        ]);

        SatuanKerja::create($data);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(SatuanKerja $instansi)
    {
        return response()->json($instansi);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SatuanKerja $instansi)
    {
        $instansi->update($request->all());
        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SatuanKerja $instansi)
    {
        if($instansi->gtk()->count() > 0){
            throw ValidationException::withMessages([
                'code' => 'Data tidak bisa dihapus karena masih memiliki GTK',
            ]);
        }
        $instansi->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
