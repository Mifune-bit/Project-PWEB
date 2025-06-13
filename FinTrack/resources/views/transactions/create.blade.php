@extends('layout')

@section('title', 'Tambah Transaksi')

@section('content')
<style>
    .custom-dropdown { position: relative; }
    .dropdown-list {
        position: absolute;
        z-index: 1000;
        background: white;
        border: 1px solid #ccc;
        border-radius: 4px;
        max-height: 250px;
        overflow-y: auto;
        width: 100%;
        display: none;
    }
    .dropdown-item {
        padding: 8px 12px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .dropdown-item:hover {
        background-color: #f8f9fa;
    }
    .remove-btn {
        font-size: 12px;
        color: red;
        cursor: pointer;
        margin-left: 8px;
    }
</style>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Tambah Transaksi Baru</div>
            <div class="card-body">
                <form method="POST" action="{{ route('transactions.store') }}">
                    @csrf

                    {{-- Jenis Transaksi --}}
                <input type="hidden" name="type" value="{{ $type }}">


                    {{-- Jumlah --}}
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label">Jumlah</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" name="amount" required>
                            </div>
                        </div>
                    </div>

                    {{-- Kategori --}}
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label">Kategori</label>
                        <div class="col-md-8">
                            <div class="custom-dropdown">
                                <input type="hidden" name="category" id="category-hidden" required>
                                <button type="button" class="form-control text-start" id="dropdownToggle">-- Pilih Kategori --</button>
                                
                                <div class="dropdown-list" id="dropdownList">
                                    {{-- Default Kategori Income --}}
                                    <div class="dropdown-group" data-type="income">
                                        @foreach ($incomeCategories as $category)
                                            <div class="dropdown-item" data-value="{{ $category->name }}" data-id="{{ $category->id }}">
                                                <span>{{ $category->name }}</span>
                                                <span class="remove-btn" data-id="{{ $category->id }}" data-name="{{ $category->name }}">🗑️</span>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- Default Kategori Expense --}}
                                    <div class="dropdown-group" data-type="expense" style="display: none;">
                                        @foreach ($expenseCategories as $category)
                                            <div class="dropdown-item" data-value="{{ $category->name }}" data-id="{{ $category->id }}">
                                                <span>{{ $category->name }}</span>
                                                <span class="remove-btn" data-id="{{ $category->id }}" data-name="{{ $category->name }}">🗑️</span>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- Kategori Tambahan --}}
                                    <div class="dropdown-group dropdown-custom" id="customGroup"></div>

                                    {{-- Tambah Kategori Baru --}}
                                    <div class="dropdown-footer">
                                        <input type="text" class="form-control form-control-sm" id="newCategoryInput" placeholder="Kategori baru...">
                                        <button type="button" class="btn btn-sm btn-primary mt-1 w-100" id="addCategoryBtn">+ Tambah Kategori</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tanggal --}}
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label">Tanggal</label>
                        <div class="col-md-8">
                            <input type="date" class="form-control" name="date" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label">Deskripsi</label>
                        <div class="col-md-8">
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript --}}
<script>
    const dropdownToggle = document.getElementById('dropdownToggle');
    const dropdownList = document.getElementById('dropdownList');
    const categoryHidden = document.getElementById('category-hidden');
    const incomeRadio = document.getElementById('incomeRadio');
    const expenseRadio = document.getElementById('expenseRadio');
    const newCategoryInput = document.getElementById('newCategoryInput');
    const addCategoryBtn = document.getElementById('addCategoryBtn');
    const customGroup = document.getElementById('customGroup');
    document.querySelectorAll('.dropdown-group[data-type]').forEach(group => {
    group.style.display = group.dataset.type === '{{ $type }}' ? 'block' : 'none';
});

    // Tampilkan/sembunyikan dropdown
    dropdownToggle.addEventListener('click', () => {
        dropdownList.style.display = dropdownList.style.display === 'block' ? 'none' : 'block';
    });

    // Pilih kategori
    dropdownList.addEventListener('click', e => {
        if (!e.target.classList.contains('remove-btn')) {
            const item = e.target.closest('.dropdown-item');
            if (item) {
                const value = item.dataset.value;
                categoryHidden.value = value;
                dropdownToggle.textContent = value;
                dropdownList.style.display = 'none';
            }
        }
    });

    // Tambah kategori baru
    addCategoryBtn.addEventListener('click', () => {
        const name = newCategoryInput.value.trim();
        if (!name) return;

        const type = incomeRadio.checked ? 'income' : 'expense';

        fetch('/categories', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ name, type })
        })
        .then(async res => {
            if (res.ok) return res.json();
            if (res.status === 422) {
                const error = await res.json();
                alert(error.errors.name?.[0] || 'Validasi gagal.');
            } else {
                throw new Error();
            }
        })
        .then(data => {
            if (!data) return;

            const div = document.createElement('div');
            div.className = 'dropdown-item';
            div.dataset.value = data.name;
            div.dataset.id = data.id;
            div.innerHTML = `<span>${data.name}</span><span class="remove-btn" data-id="${data.id}" data-name="${data.name}">🗑️</span>`;
            const targetGroup = document.querySelector(`.dropdown-group[data-type="${type}"]`);
            if (targetGroup) {
            targetGroup.appendChild(div);
            }

            newCategoryInput.value = '';
        })
        .catch(() => alert('Terjadi kesalahan saat menambahkan kategori.'));

    });

    // Hapus kategori
    dropdownList.addEventListener('click', e => {
        if (e.target.classList.contains('remove-btn')) {
            e.stopPropagation();
            const id = e.target.dataset.id;
            const name = e.target.dataset.name;

            if (!confirm(`Hapus kategori "${name}"?`)) return;

            fetch(`/categories/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    e.target.closest('.dropdown-item').remove();
                    if (categoryHidden.value === name) {
                        categoryHidden.value = '';
                        dropdownToggle.textContent = '-- Pilih Kategori --';
                    }
                } else {
                    alert("Gagal menghapus kategori.");
                }
            })
            .catch(() => alert("Terjadi kesalahan saat menghapus kategori."));
        }
    });
</script>
@endsection
