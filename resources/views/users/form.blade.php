@csrf
<div class="form-group">
    <label for="name">Nama Pengguna <sup style="color: red;">*</sup></label>
    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" required>
</div>
<div class="form-group">
    <label for="email">Email <sup style="color: red;">*</sup></label>
    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required>
</div>

@if(!$user)
<div class="form-group">
    <label for="password">Password <sup style="color: red;">*</sup></label>
    <input type="password" class="form-control" id="password" name="password" required>
</div>
<div class="form-group">
    <label for="password_confirmation">Konfirmasi Password <sup style="color: red;">*</sup></label>
    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
</div>
@endif

<div class="form-group">
    <label for="gtk_id">Tautkan GTK</label>
    <select class="form-control select2" id="gtk_id" name="gtk_id" required style="width: 100%;">
        <option value="0">-- Jangan Tautkan --</option>
        @foreach (\App\Models\Gtk::all() as $gtk)
        <option value="{{ $gtk->id }}" @selected(old('gtk_id', data_get($user, 'gtk.id' , 0))==$gtk->id)>{{ $gtk->name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="role">Role <sup style="color: red;">*</sup></label>
    <select class="form-control select2" id="role" name="role" required style="width: 100%;">
        <option value="user" @selected(old('role', data_get($user, 'role' , 'user' ))=='user' )>User</option>
        <option value="admin" @selected(old('role', data_get($user, 'role' , 'user' ))=='admin' )>Admin</option>
    </select>
</div>