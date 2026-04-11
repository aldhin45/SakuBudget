<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::where('user_id', Auth::id())
            ->with('category');

        // SEARCH
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('note', 'like', '%' . $request->search . '%')
                  ->orWhere('amount', 'like', '%' . $request->search . '%');
            });
        }

        // FILTER KATEGORI
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // FILTER TANGGAL
        if ($request->date) {
            $query->whereDate('date', $request->date);
        }

        $transactions = $query->latest()->get();
        $categories = Category::all();

        return view('transactions.index', compact('transactions', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('transactions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'category_id' => 'required',
            'date' => 'required|date'
        ]);

        Transaction::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'quantity' => $request->quantity,
            'date' => \Carbon\Carbon::parse($request->date),
            'note' => $request->note,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Berhasil tambah transaksi!');
    }

    public function edit($id)
    {
        $transaction = Transaction::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $categories = Category::where('is_active', true)->get();

        return view('transactions.edit', compact('transaction', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'category_id' => 'required',
            'date' => 'required|date'
        ]);

        $transaction = Transaction::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $transaction->update([
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'quantity' => $request->quantity,
            'date' => \Carbon\Carbon::parse($request->date),
            'note' => $request->note,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Berhasil update!');
    }

    public function destroy($id)
    {
        Transaction::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return back()->with('success', 'Data dihapus');
    }

    public function export()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->with('category')
            ->get();

        $response = new StreamedResponse(function () use ($transactions) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Jumlah', 'Kategori', 'Tanggal', 'Catatan']);

            foreach ($transactions as $t) {
                fputcsv($handle, [
                    $t->amount,
                    $t->category->name,
                    $t->date,
                    $t->note
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="transactions.csv"');

        return $response;
    }

    public function exportPdf()
    {
        $user = Auth::user();
        $transactions = Transaction::where('user_id', Auth::id())
            ->with('category')
            ->get();

        $pdf = Pdf::loadView('transactions.pdf', compact('transactions','user'));

        return $pdf->download('transactions.pdf');
    }
}