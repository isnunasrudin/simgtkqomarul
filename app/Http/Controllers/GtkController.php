<?php

namespace App\Http\Controllers;

use App\Models\Gtk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class GtkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Gtk::class);
        $allGtk = Gtk::with('satuanKerja', 'activeStudy', 'user')->orderBy('name', 'asc')->get();

        return view('gtk.index', compact('allGtk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Gtk::class);

        return view('gtk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Gtk::class);
        $data = $request->validate([
            'type' => 'required|string',
            'nik' => 'required|numeric',
            'name' => 'required|string',
            'gender' => 'required|in:L,P',
            'kawin' => 'required|in:Kawin,Belum Kawin,Cerai,Cerai Mati',
            'nuptk' => 'nullable|numeric',
            'nigy' => 'nullable|string',
            'birth_place' => 'required|string',
            'birth_date' => 'required|date',
            'tmt_yayasan' => 'required|date',
            'tmt_satker' => 'required|date',
            'rt' => 'required|numeric',
            'rw' => 'required|numeric',
            'dusun' => 'required|string',
            'desa' => 'required|string',
            'kecamatan' => 'required|string',
            'kabupaten' => 'required|string',
            'provinsi' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'satuan_kerja_id' => 'required|exists:satuan_kerja,id',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $gtk = Gtk::create($data);
        $request->merge([
            'gtk' => $gtk,
        ]);

        return redirect()->route('gtk.index')->with('success', 'GTK berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gtk $gtk)
    {
        Gate::authorize('view', $gtk);
        return view('gtk.edit', compact('gtk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gtk $gtk)
    {
        Gate::authorize('update', $gtk);
        return view('gtk.edit', compact('gtk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gtk $gtk)
    {
        Gate::authorize('update', $gtk);
        $data = $request->validate([
            'type' => 'required|string',
            'nik' => 'required|numeric',
            'name' => 'required|string',
            'gender' => 'required|in:L,P',
            'kawin' => 'required|in:Kawin,Belum Kawin,Cerai,Cerai Mati',
            'nuptk' => 'nullable|numeric',
            'nigy' => 'nullable|string',
            'birth_place' => 'required|string',
            'birth_date' => 'required|date',
            'tmt_yayasan' => 'required|date',
            'tmt_satker' => 'required|date',
            'rt' => 'required|numeric',
            'rw' => 'required|numeric',
            'dusun' => 'required|string',
            'desa' => 'required|string',
            'kecamatan' => 'required|string',
            'kabupaten' => 'required|string',
            'provinsi' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'satuan_kerja_id' => 'required|exists:satuan_kerja,id',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        DB::transaction(fn() => $gtk->update($data));

        return redirect()->route('gtk.index')->with('success', 'GTK berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gtk $gtk)
    {
        Gate::authorize('delete', $gtk);
        $gtk->delete();

        return redirect()->route('gtk.index')->with('success', 'GTK berhasil dihapus');
    }

    public function generateCredentials(Gtk $gtk)
    {
        Gate::authorize('update', $gtk);
        $password = Str::password(12);

        User::firstOrCreate([
            'email' => $gtk->nik . '@madrasah.web.id',
        ], [
            'name' => $gtk->name,
            'password' => bcrypt($password),
            'default_password' => $password,
            'gtk_id' => $gtk->id,
        ]);

        return redirect()->route('users.index')->with('success', 'Kredensial berhasil dibuat');
    }
}
