<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
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
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();

        Auth::logoutOtherDevices($request->password);

            if ($user->hasRole('admin')) {
                return redirect()->route('performance.total-leads');
            } elseif ($user->hasRole('manager')) {
                return redirect()->route('performance.total-leads');
            } elseif ($user->hasRole('team_leader')) {
                return redirect()->route('performance.total-leads-for-tl');
            } elseif ($user->hasRole('agent')) {
                return redirect()->route('attend.dashboard');
            } elseif ($user->hasRole('s_team_leader')) {
                return redirect()->route('leads.index');
            }

            // Default fallback redirection
            //return redirect()->route('dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
