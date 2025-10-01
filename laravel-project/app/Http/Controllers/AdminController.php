<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminUser;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function dashboard()
    {
        $user = Auth::guard('admin')->user();
        $totalUsers = AdminUser::count();
        $recentUsers = AdminUser::select('id', 'name', 'username', 'area', 'role', 'active', 'created_at')
                               ->orderBy('created_at', 'desc')
                               ->limit(5)
                               ->get();
        
        return view('admin.dashboard', compact('user', 'totalUsers', 'recentUsers'));
    }
}
