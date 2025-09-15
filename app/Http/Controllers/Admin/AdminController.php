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
        $users = User::all();
        return view('admin.dashboard', compact('users'));
    }

    /**
     * Show user management page
     */
    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    /**
     * Promote a user to admin
     */
    public function promoteUser(Request $request, User $user)
    {
        if ($user->promoteToAdmin()) {
            return back()->with('success', 'User promoted to admin successfully.');
        }
        
        return back()->with('error', 'Failed to promote user.');
    }

    /**
     * Demote a user to guest
     */
    public function demoteUser(Request $request, User $user)
    {
        // Prevent demoting the last admin
        $adminCount = User::where('role', User::ROLE_ADMIN)->count();
        if ($adminCount <= 1 && $user->isAdmin()) {
            return back()->with('error', 'Cannot demote the last admin user.');
        }

        if ($user->demoteToGuest()) {
            return back()->with('success', 'User demoted to guest successfully.');
        }
        
        return back()->with('error', 'Failed to demote user.');
    }
}