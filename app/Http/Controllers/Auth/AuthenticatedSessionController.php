<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        // Autentikasi pengguna
        $request->authenticate();

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;


        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user,
            ], 200);
        }

        // Jika permintaan berasal dari aplikasi web (browser)
        return redirect()->intended(RouteServiceProvider::HOME);
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        // Hapus semua token autentikasi pengguna
        $user = $request->user();

        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Logout successful',
            ], 200);
        }
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect('/');
    }
}
