<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Notifications\SaldoMenipis;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $transactions = Transaction::with('category')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        // TOTAL PENGELUARAN
        $totalPengeluaran = $transactions->sum(function ($t) {
            return $t->amount * $t->quantity;
        });

        // 💰 SALDO SEKARANG (REAL)
        $saldoSekarang = $user->balance;

        // 🔥 STATUS
        if ($saldoSekarang <= 0) {
            $status = "BAHAYA";
            $color = "red";
        } elseif ($saldoSekarang < 50000) {
            $status = "WASPADA";
            $color = "orange";
        } else {
            $status = "AMAN";
            $color = "green";
        }

        // 🔔 NOTIFIKASI SALDO MENIPIS (ANTI SPAM)
        $hasUnread = $user->unreadNotifications()
            ->where('type', SaldoMenipis::class)
            ->exists();

        if ($saldoSekarang < 50000 && !$hasUnread) {
            $user->notify(new SaldoMenipis());
        }

        // 📊 PERSENTASE (estimasi dari total uang masuk)
        $totalTopUp = $saldoSekarang + $totalPengeluaran;

        $percentage = $totalTopUp > 0
            ? ($saldoSekarang / $totalTopUp) * 100
            : 0;

        $percentage = min(100, max(0, round($percentage)));

        // TRANSAKSI TERBARU
        $latestTransactions = $transactions->take(3);

        // PENGELUARAN TERBESAR
        $maxTransaction = $transactions->sortByDesc(function ($t) {
            return $t->amount * $t->quantity;
        })->first();

        return view('dashboard', compact(
            'saldoSekarang',
            'totalPengeluaran',
            'status',
            'color',
            'latestTransactions',
            'maxTransaction',
            'percentage'
        ));
    }

    // 💰 TOP UP
    public function updateBalance(Request $request)
    {
        $request->validate([
            'balance' => 'required|numeric|min:1'
        ]);

        $user = Auth::user();

        // tambah saldo
        $user->balance += $request->balance;
        $user->save();

        return back()->with('success', 'Top up berhasil!');
    }
}