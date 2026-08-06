<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCustomers = Customer::count();

        $totalCompanies = Customer::whereNotNull('company')
            ->where('company', '!=', '')
            ->distinct()
            ->count('company');

        $monthlyCustomers = Customer::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        $latestCustomers = Customer::latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalCustomers',
            'totalCompanies',
            'monthlyCustomers',
            'latestCustomers'
        ));
    }
}