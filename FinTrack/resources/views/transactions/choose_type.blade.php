@extends('layout')

@section('title', 'Pilih Jenis Transaksi')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card text-center">
            <div class="card-header">
                <h4>Pilih Jenis Transaksi</h4>
            </div>
            <div class="card-body">
                <p class="mb-4">Silakan pilih jenis transaksi yang ingin Anda tambahkan.</p>

                <a href="{{ route('transactions.create', ['type' => 'income']) }}" class="btn btn-success btn-lg me-2">
                    💰 Pemasukan
                </a>

                <a href="{{ route('transactions.create', ['type' => 'expense']) }}" class="btn btn-danger btn-lg">
                    💸 Pengeluaran
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
