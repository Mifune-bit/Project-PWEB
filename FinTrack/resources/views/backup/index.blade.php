@extends('layout')

@section('title', 'Backup & Restore')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Backup Transaksi</h5>
                <p class="card-text">Klik tombol di bawah untuk mengunduh backup data transaksi Anda.</p>
                <a href="{{ route('backup.download') }}" class="btn btn-primary">
                    <i class="fas fa-download"></i> Unduh Backup
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Restore Transaksi</h5>
                <p class="card-text">Unggah file backup (.json) untuk mengembalikan data transaksi Anda.</p>
                <form action="{{ route('backup.restore') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <input type="file" name="backup_file" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-upload"></i> Restore
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
