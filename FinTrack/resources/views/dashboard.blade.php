@extends('layout')

@section('title', 'Dasbor')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2>Selamat datang, {{ auth()->user()->name }}</h2>
        <p>Ini adalah dasbor pribadi Anda.</p>
        
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Pemasukan</h5>
                        <p class="card-text h4">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
                        <a href="{{ route('transactions.index', ['type' => 'income']) }}" class="text-white">Lihat Detail</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Pengeluaran</h5>
                        <p class="card-text h4">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
                        <a href="{{ route('transactions.index', ['type' => 'expense']) }}" class="text-white">Lihat Detail</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Saldo Saat Ini</h5>
                        <p class="card-text h4">Rp {{ number_format($balance, 0, ',', '.') }}</p>
                        <a href="{{ route('transactions.index') }}" class="text-white">Lihat Semua Transaksi</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <h5>Transaksi Terbaru</h5>
            </div>
            <div class="card-body">
                @if($recentTransactions->count() > 0)
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Kategori</th>
                                <th>Jumlah</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentTransactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->date->format('d M Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $transaction->type === 'income' ? 'success' : 'danger' }}">
                                            {{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                        </span>
                                    </td>
                                    <td>{{ $transaction->category }}</td>
                                    <td class="{{ $transaction->type === 'income' ? 'text-success' : 'text-danger' }}">
                                        Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </td>
                                    <td>{{ $transaction->description ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('transactions.index') }}" class="btn btn-primary">Lihat Semua Transaksi</a>
                @else
                    <p>Belum ada transaksi. <a href="{{ route('transactions.selectType') }}">Tambahkan transaksi pertama Anda</a></p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
