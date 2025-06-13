<?php
// app/Http/Controllers/TransactionController.php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
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

    public function selectType()
{
    return view('transactions.choose_type');
}


    public function create(Request $request)
{
    $type = $request->query('type');

    if (!in_array($type, ['income', 'expense'])) {
        return redirect()->route('transactions.choose_type')->with('error', 'Silakan pilih jenis transaksi terlebih dahulu.');
    }

    $categories = Category::where('user_id', auth()->id())
        ->where('type', $type)
        ->get();

    return view('transactions.create', [
        'type' => $type,
        'incomeCategories' => $type === 'income' ? $categories : collect(),
        'expenseCategories' => $type === 'expense' ? $categories : collect(),
    ]);
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
                    $user = Auth::user();
                    $exists = Category::where('user_id', $user->id)
                        ->where('type', $request->type)
                        ->where('name', $value)
                        ->exists();

                    if (!$exists) {
                        $fail("Kategori '$value' tidak valid untuk tipe transaksi " . $request->type . ".");
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

    $incomeCategories = Category::where('user_id', auth()->id())
        ->where('type', 'income')
        ->get();

    $expenseCategories = Category::where('user_id', auth()->id())
        ->where('type', 'expense')
        ->get();

    return view('transactions.edit', compact('transaction', 'incomeCategories', 'expenseCategories'));
}


    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'type' => 'required|in:income,expense',
        'amount' => 'required|numeric|min:0',
        'category' => [
            'required',
            'string',
            function ($attribute, $value, $fail) use ($request) {
                $user = Auth::user();
                $exists = Category::where('user_id', $user->id)
                    ->where('type', $request->type)
                    ->where('name', $value)
                    ->exists();

                if (!$exists) {
                    $fail("Kategori '$value' tidak valid untuk tipe transaksi " . $request->type . ".");
                }
            },
        ],
        'description' => 'nullable|string',
        'date' => 'required|date',
    ]);

    $transaction = Auth::user()->transactions()->findOrFail($id);
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
