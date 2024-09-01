<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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
    public function store(LoginRequest $request): RedirectResponse
    {
        // $request->authenticate();

        // $request->session()->regenerate();

        // return redirect()->intended(route('dashboard', absolute: false));

        $credentials = $request->only('email','password');

        Auth::logout();
        Auth::guard('manager')->logout();
        Auth::guard('admin')->logout();

        if(Auth::guard('web')->attempt($credentials)) {
            return redirect()->route('dashboard');
        }
        else if(Auth::guard('manager')->attempt($credentials)) {
            return redirect()->route('manager-dashboard');
        }
        else if(Auth::guard('admin')->attempt($credentials)){
            return redirect()->route('dashboardAdmin');
        }

        return redirect()->back()->withErrors([
            'email' => 'Credenciais não identificadas.',
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
