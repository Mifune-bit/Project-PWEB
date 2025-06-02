<?php
// app/Http/Controllers/TransactionController.php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransactionController extends Controller
{
    protected $incomeCategories = ['Gaji', 'Bonus', 'Investasi', 'Lainnya'];
    protected $expenseCategories = ['Makanan', 'Transportasi', 'Tempat Tinggal', 'Lainnya'];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Auth::user()->transactions();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('month')) {
            try {
                $month = Carbon::createFromFormat('Y-m', $request->month);
                $query->whereYear('date', $month->year)->whereMonth('date', $month->month);
            } catch (\Exception $e) {
                // Abaikan jika format bulan tidak valid
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('category', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('amount', 'like', "%{$search}%");
            });
        }

        $transactions = $query->latest()->paginate(10);

        $totalIncome = Auth::user()->transactions()->where('type', 'income')->sum('amount');
        $totalExpense = Auth::user()->transactions()->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        return view('transactions.index', compact('transactions', 'totalIncome', 'totalExpense', 'balance'));
    }

    public function create()
    {
        return view('transactions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'category' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    $validCategories = $request->type === 'income'
                        ? $this->incomeCategories
                        : $this->expenseCategories;

                    if (!in_array($value, $validCategories)) {
                        $fail("Kategori '$value' tidak valid untuk tipe transaksi " . $request->type . '.');
                    }
                },
            ],
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        Auth::user()->transactions()->create($validated);

        return redirect()->route('transactions.index')->with('success', 'Transaction added successfully');
    }

    public function edit($id)
    {
        $transaction = Auth::user()->transactions()->findOrFail($id);
        return view('transactions.edit', compact('transaction'));
    }

    public function update(Request $request, $id)
    {
        $transaction = Auth::user()->transactions()->findOrFail($id);

        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'category' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    $validCategories = $request->type === 'income'
                        ? $this->incomeCategories
                        : $this->expenseCategories;

                    if (!in_array($value, $validCategories)) {
                        $fail("Kategori '$value' tidak valid untuk tipe transaksi " . $request->type . '.');
                    }
                },
            ],
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $transaction->update($validated);

        return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully');
    }

    public function destroy($id)
    {
        $transaction = Auth::user()->transactions()->findOrFail($id);
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully');
    }
}
