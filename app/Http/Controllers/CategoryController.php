<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
{
    $transactions = \App\Models\Transaction::with('category')
        ->where('user_id', \Auth::id())
        ->get();

    // 🔹 GROUP PER KATEGORI
    $categories = $transactions->groupBy(function ($t) {
        return $t->category->name ?? 'Tanpa Kategori';
    });

    // 🔹 DATA UNTUK PIE CHART
    $chartLabels = [];
    $chartData = [];

    foreach ($categories as $name => $items) {
        $total = $items->sum(function ($t) {
            return $t->amount * $t->quantity;
        });

        $chartLabels[] = $name;
        $chartData[] = $total;
    }

    // 🔹 DATA UNTUK BAR CHART (BULANAN)
    $monthly = $transactions->groupBy(function ($t) {
        return \Carbon\Carbon::parse($t->date)->format('M');
    });

    $monthLabels = [];
    $monthData = [];

    foreach ($monthly as $month => $items) {
        $monthLabels[] = $month;
        $monthData[] = $items->sum(function ($t) {
            return $t->amount * $t->quantity;
        });
    }

    return view('categories.index', compact(
        'categories',
        'chartLabels',
        'chartData',
        'monthLabels',
        'monthData'
    ));
}
}