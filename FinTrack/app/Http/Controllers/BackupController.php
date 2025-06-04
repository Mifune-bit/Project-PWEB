<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;


class BackupController extends Controller
{
    // Menampilkan halaman backup
    public function index()
    {
        return view('backup.index');
    }

    // Unduh file backup
    public function create()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $data = [
            'transactions' => $user->transactions()->get()->makeHidden(['id', 'user_id'])->toArray(),
            'backup_date' => now()->toDateTimeString()
        ];

        $fileName = 'backup-'.$user->id.'-'.date('YmdHis').'.json';

        return response()->streamDownload(
            function () use ($data) {
                echo json_encode($data, JSON_PRETTY_PRINT);
            },
            $fileName,
            ['Content-Type' => 'application/json']
        );
    }

    // Restore dari file backup
    public function restore(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|mimes:json|max:5120'
        ]);

        $file = $request->file('backup_file');
        $content = json_decode(file_get_contents($file->getRealPath()), true);

        if (!isset($content['transactions'])) {
            return back()->with('error', 'Format file backup tidak valid');
        }

        $user = Auth::user();

        \DB::beginTransaction();
        try {
            $user->transactions()->delete();

            foreach ($content['transactions'] as $transaction) {
                $user->transactions()->create([
                    'type' => $transaction['type'],
                    'amount' => $transaction['amount'],
                    'description' => $transaction['description'],
                    'date' => $transaction['date'],
                    'category' => $transaction['category'] ?? 'umum', 
                    'created_at' => $transaction['created_at'] ?? now(),
                    'updated_at' => $transaction['updated_at'] ?? now()
                ]);
            }

            \DB::commit();
            return back()->with('success', 'Berhasil restore '.count($content['transactions']).' transaksi');

        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->with('error', 'Gagal restore: '.$e->getMessage());
        }
    }
}
