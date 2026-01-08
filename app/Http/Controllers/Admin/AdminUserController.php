<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminUserController extends Controller
{
    /**
     * Display a listing of admin users.
     */
    public function index()
    {
        $admins = User::where('is_admin', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('admin.users.index', compact('admins'));
    }

    /**
     * Show the form for creating a new admin user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created admin user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => true,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Administrador creado exitosamente.');
    }

    /**
     * Show the form for editing the specified admin user.
     */
    public function edit(User $user)
    {
        // Only allow editing admin users
        if (!$user->isAdmin()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Solo se pueden editar usuarios administradores.');
        }

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified admin user.
     */
    public function update(Request $request, User $user)
    {
        // Only allow updating admin users
        if (!$user->isAdmin()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Solo se pueden editar usuarios administradores.');
        }

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ];

        // Password is optional on update
        if ($request->filled('password')) {
            $rules['password'] = ['confirmed', Rules\Password::defaults()];
        }

        $request->validate($rules);

        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'Administrador actualizado exitosamente.');
    }

    /**
     * Remove the specified admin user.
     */
    public function destroy(User $user)
    {
        // Only allow deleting admin users
        if (!$user->isAdmin()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Solo se pueden eliminar usuarios administradores.');
        }

        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        // Check if this is the last admin
        $adminCount = User::where('is_admin', true)->count();
        if ($adminCount <= 1) {
            return redirect()->route('admin.users.index')
                ->with('error', 'No se puede eliminar el último administrador del sistema.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Administrador eliminado exitosamente.');
    }
}
