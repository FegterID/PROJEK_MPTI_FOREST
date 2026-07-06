<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 * Auth manual (bukan Breeze/Fortify) — port langsung dari logic
 * includes/auth.php + pages/login.php + pages/register.php pada
 * project PHP native, tapi memakai Auth facade & Hash facade bawaan
 * Laravel supaya session, hashing, dan proteksi tetap standar framework.
 */
class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    /**
     * Setara loginUser(): identifier boleh username ATAU email.
     * Dicoba sebagai username dulu, baru email kalau formatnya valid email.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'login_id' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login_id.required' => 'Email/username dan password harus diisi',
            'password.required' => 'Email/username dan password harus diisi',
        ]);

        $identifier = trim($credentials['login_id']);

        $user = User::where('username', $identifier)->first();

        if (! $user && filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $identifier)->first();
        }

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withErrors(['login_id' => 'Email/username atau password salah'])
                ->withInput($request->except('password'));
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // Admin -> dashboard, customer -> my-bookings.
        return $user->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('bookings.mine');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    /**
     * Setara registerCustomer(): nomor HP dipakai sebagai 'username'.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:25', 'unique:users,username'],
            'email' => ['required', 'email', 'max:120', 'unique:users,email'],
            'address' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'phone.unique' => 'Username sudah terdaftar',
            'email.unique' => 'Email sudah terdaftar',
            'password.confirmed' => 'Password tidak sesuai',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        $user = User::create([
            'username' => $validated['phone'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'customer',
            'name' => $validated['name'],
            'address' => $validated['address'],
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('bookings.mine');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
