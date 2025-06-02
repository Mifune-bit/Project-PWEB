@extends('layout')

@section('title', 'Edit Transaksi')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Edit Transaksi</div>
            <div class="card-body">
                <form method="POST" action="{{ route('transactions.update', $transaction->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <label for="type" class="col-md-4 col-form-label">Jenis Transaksi</label>
                        <div class="col-md-8">
                            <div class="btn-group" role="group">
                                <input type="radio" class="btn-check" name="type" id="type-income" value="income" 
                                    autocomplete="off" {{ $transaction->type === 'income' ? 'checked' : '' }}>
                                <label class="btn btn-outline-success" for="type-income">Pemasukan</label>

                                <input type="radio" class="btn-check" name="type" id="type-expense" value="expense" 
                                    autocomplete="off" {{ $transaction->type === 'expense' ? 'checked' : '' }}>
                                <label class="btn btn-outline-danger" for="type-expense">Pengeluaran</label>
                            </div>
                            @error('type')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="amount" class="col-md-4 col-form-label">Jumlah</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('amount') is-invalid @enderror" 
                                       id="amount" name="amount" value="{{ old('amount', $transaction->amount) }}" required>
                                @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="category" class="col-md-4 col-form-label">Kategori</label>
                        <div class="col-md-8">
                            <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                <option value="">-- Pilih Kategori --</option>

                                <optgroup label="Pemasukan" data-type="income">
                                    <option value="Gaji" {{ old('category', $transaction->category) == 'Gaji' ? 'selected' : '' }}>Gaji</option>
                                    <option value="Bonus" {{ old('category', $transaction->category) == 'Bonus' ? 'selected' : '' }}>Bonus</option>
                                    <option value="Investasi" {{ old('category', $transaction->category) == 'Investasi' ? 'selected' : '' }}>Investasi</option>
                                    <option value="Lainnya" {{ old('category', $transaction->category) == 'Lainnya' && $transaction->type == 'income' ? 'selected' : '' }}>Lainnya</option>
                                </optgroup>

                                <optgroup label="Pengeluaran" data-type="expense">
                                    <option value="Makanan" {{ old('category', $transaction->category) == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                                    <option value="Transportasi" {{ old('category', $transaction->category) == 'Transportasi' ? 'selected' : '' }}>Transportasi</option>
                                    <option value="Tempat Tinggal" {{ old('category', $transaction->category) == 'Tempat Tinggal' ? 'selected' : '' }}>Tempat Tinggal</option>
                                    <option value="Lainnya" {{ old('category', $transaction->category) == 'Lainnya' && $transaction->type == 'expense' ? 'selected' : '' }}>Lainnya</option>
                                </optgroup>
                            </select>
                            @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="date" class="col-md-4 col-form-label">Tanggal</label>
                        <div class="col-md-8">
                            <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                   id="date" name="date" value="{{ old('date', $transaction->date->format('Y-m-d')) }}" required>
                            @error('date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="description" class="col-md-4 col-form-label">Deskripsi</label>
                        <div class="col-md-8">
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description', $transaction->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Perbarui Transaksi
                            </button>
                            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                                Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Script untuk menyaring kategori berdasarkan jenis transaksi --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeRadios = document.querySelectorAll('input[name="type"]');
        const categorySelect = document.getElementById('category');
        const optgroups = categorySelect.querySelectorAll('optgroup');

        function filterCategories(type) {
            optgroups.forEach(group => {
                group.style.display = group.dataset.type === type ? 'block' : 'none';
            });
        }

        typeRadios.forEach(radio => {
            radio.addEventListener('change', function () {
                if (this.checked) {
                    filterCategories(this.value);
                }
            });
        });

        // Jalankan filter awal berdasarkan nilai default
        const checkedType = document.querySelector('input[name="type"]:checked').value;
        filterCategories(checkedType);
    });
</script>
@endsection
