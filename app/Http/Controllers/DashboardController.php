<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Rice;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'ricesCount' => Rice::count(),
            'ordersCount' => Auth::user()->orders->count(),
            'unpaidCount' => Payment::whereHas('order', function ($query) {
                $query->where('user_id', Auth::id());
            })->where('status', 'unpaid')->count(),
            'totalRevenue' => Payment::whereHas('order', function ($query) {
                $query->where('user_id', Auth::id());
            })->where('status', 'paid')->sum('amount'),
        ]);
    }
}
