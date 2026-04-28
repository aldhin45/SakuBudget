<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopUpController extends Controller
{
    public function index()
    {
        return view('topup');
    }

    public function store(Request $request)
    {
        $amount = $request->amount ?? $request->custom_amount;
        $amount = (int) $amount;

        if (!$amount || $amount < 10000) {
            return back()->with('error', 'Minimal top up Rp 10.000');
        }

        $user = Auth::user();

        // langsung tambah saldo
        $user->balance += $amount;
        $user->save();

        return back()->with('success', 'Top up berhasil!');
    }
}