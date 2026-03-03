<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WizardController extends Controller
{
    public function index()
    {
        return view('wizard');
    }

    public function store(Request $request)
    {
        $callBack = (new GtkController)->store($request);
        $gtk = $callBack->getRequest()->gtk;

        $gtk->update([
            'user_id' => Auth::user()->id,
        ]);

        if ($callBack) {
            return redirect()->route('gtk.studies.index', ['gtk' => $gtk]);
        }

        return redirect()->back()->with('error', 'Gagal menyimpan data');
    }
}
