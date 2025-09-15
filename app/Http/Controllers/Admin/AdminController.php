<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function dashboard()
    {
        // Double-check permissions
        if (!auth()->user()->isOrganizer()) {
            return redirect()->route('access.denied')->with('error', 'Access denied. Only organizers can access the admin panel.');
        }

        $users = User::all();
        return view('admin.dashboard', compact('users'));
    }

    /**
     * Show user management page
     */
    public function users()
    {
        // Double-check permissions
        if (!auth()->user()->isOrganizer()) {
            return redirect()->route('access.denied')->with('error', 'Access denied. Only organizers can manage users.');
        }

        $users = User::all();
        return view('admin.users', compact('users'));
    }

    /**
     * Promote a user to organizer
     */
    public function promoteUser(Request $request, User $user)
    {
        // Additional permission check
        if (!auth()->user()->isOrganizer()) {
            return back()->with('error', 'Access denied. Only organizers can promote users.');
        }

        if ($user->promoteToAdmin()) {
            return back()->with('success', 'User promoted to organizer successfully.');
        }
        
        return back()->with('error', 'Failed to promote user.');
    }

    /**
     * Demote a user to guest
     */
    public function demoteUser(Request $request, User $user)
    {
        // Additional permission check
        if (!auth()->user()->isOrganizer()) {
            return back()->with('error', 'Access denied. Only organizers can manage users.');
        }

        // Prevent self-demotion
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot demote yourself.');
        }

        // Prevent demoting the last organizer
        $organizerCount = User::where('role', User::ROLE_ORGANIZER)->count();
        if ($organizerCount <= 1 && $user->isOrganizer()) {
            return back()->with('error', 'Cannot demote the last organizer. At least one organizer must remain.');
        }

        if ($user->demoteToGuest()) {
            return back()->with('success', 'User demoted to guest successfully.');
        }
        
        return back()->with('error', 'Failed to demote user.');
    }
}