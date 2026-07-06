<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function edit(): View
    {
        return view('account.edit', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Setara updateCustomerProfile() di includes/auth.php lama.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:120', 'unique:users,email,'.$user->id],
            'phone' => ['required', 'string', 'max:50', 'unique:users,username,'.$user->id],
            'address' => ['required', 'string'],
        ], [
            'email.unique' => 'Email sudah terdaftar',
            'phone.unique' => 'No HP/Username sudah terdaftar',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['phone'],
            'address' => $validated['address'],
        ]);

        return redirect()->route('account.edit')->with('success', 'Profil berhasil diperbarui');
    }

    /**
     * Setara updateCustomerPassword() di includes/auth.php lama.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:6'],
            'confirm_password' => ['required', 'string', 'same:new_password'],
        ], [
            'new_password.min' => 'Password minimal 6 karakter',
            'confirm_password.same' => 'Password baru tidak sama',
        ]);

        if (! Hash::check($validated['current_password'], $user->password)) {
            return redirect()->route('account.edit')->withErrors([
                'current_password' => 'Password lama tidak sesuai',
            ]);
        }

        $user->update(['password' => Hash::make($validated['new_password'])]);

        return redirect()->route('account.edit')->with('success', 'Password berhasil diperbarui');
    }
}
