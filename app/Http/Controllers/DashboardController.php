<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    $transactions = Transaction::where('user_id', Auth::id())->get();

    // TOTAL 
    $total = $transactions->sum(function ($t) {
        return $t->amount * $t->quantity;
    });

    $saldo = Auth::user()->balance;
    $sisa = $saldo - $total;

    // STATUS 
    if ($sisa <= 0) {
        $status = "BAHAYA";
        $color = "red";
    } elseif ($sisa < $saldo * 0.3) {
        $status = "WASPADA";
        $color = "orange";
    } else {
        $status = "AMAN";
        $color = "green";
    }

    // HARI INI
    $todayTotal = $transactions->filter(function ($t) {
        return \Carbon\Carbon::parse($t->date)->isToday();
    })->sum(function ($t) {
        return $t->amount * $t->quantity;
    });

    // 🔥 BULAN INI
    $monthlyTotal = $transactions->filter(function ($t) {
        return \Carbon\Carbon::parse($t->date)->isCurrentMonth();
    })->sum(function ($t) {
        return $t->amount * $t->quantity;
    });

    // RULE 80%
    $warnings = [];

    foreach ($transactions->groupBy('category_id') as $catId => $items) {
        $totalCat = $items->sum(function ($t) {
            return $t->amount * $t->quantity;
        });

        $category = Category::find($catId);

        if ($category && $totalCat >= 0.8 * $category->budget_limit) {
            $warnings[] = [
                'category' => $category->name,
                'total' => $totalCat,
                'limit' => $category->budget_limit
            ];
        }
    }

    // PROGRESS
    $categoryProgress = [];

    foreach ($transactions->groupBy('category_id') as $catId => $items) {
        $category = Category::find($catId);
        if (!$category) continue;

        $totalCat = $items->sum(function ($t) {
            return $t->amount * $t->quantity;
        });

        $percent = $category->budget_limit > 0
            ? ($totalCat / $category->budget_limit) * 100
            : 0;

        $categoryProgress[] = [
            'name' => $category->name,
            'percent' => $percent
        ];
    }

    return view('dashboard', compact(
        'total',
        'status',
        'color',
        'todayTotal',
        'monthlyTotal',
        'warnings',
        'categoryProgress'
    ));
}
    public function updateBalance(Request $request)
    {
        $request->validate([
            'balance' => 'required|numeric|min:0'
        ]);

        $user = Auth::user();
        $user->balance = $request->balance;
        $user->save();

        return back()->with('success', 'Saldo berhasil diperbarui!');
    }
}