<?php

namespace App\Http\Controllers;

use App\Models\Gtk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', User::class);

        $users = User::with('gtk')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', User::class);

        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'gtk_id' => 'nullable|numeric',
            'role' => 'required|in:user,admin',
        ]);

        $user = User::create($data);
        if ($request->gtk_id && $gtk = Gtk::find($request->gtk_id)) {
            $gtk->update([
                'user_id' => $user->id,
            ]);
        }

        return redirect()->route('users.index')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        Gate::authorize('update', $user);

        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'gtk_id' => 'nullable|numeric',
            'role' => 'required|in:user,admin',
        ]);

        $user->update($data);

        Gtk::where('user_id', $user->id)->update([
            'user_id' => null,
        ]);

        if ($request->gtk_id && $gtk = Gtk::find($request->gtk_id)) {
            $gtk->update([
                'user_id' => $user->id,
            ]);
        }

        return redirect()->route('users.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        Gate::authorize('delete', $user);

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Data berhasil dihapus');
    }

    public function resetPassword(User $user)
    {
        Gate::authorize('update', $user);

        $password = Str::password(12);

        $user->update([
            'password' => bcrypt($password),
            'default_password' => $password,
        ]);

        return redirect()->route('users.index')->with('success', 'Password berhasil direset');
    }
}
