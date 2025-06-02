

<?php $__env->startSection('title', 'Tambah Transaksi'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Tambah Transaksi Baru</div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('transactions.store')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="row mb-3">
                        <label for="type" class="col-md-4 col-form-label">Jenis Transaksi</label>
                        <div class="col-md-8">
                            <div class="btn-group" role="group">
                                <input type="radio" class="btn-check" name="type" id="type-income" value="income" autocomplete="off" checked>
                                <label class="btn btn-outline-success" for="type-income">Pemasukan</label>

                                <input type="radio" class="btn-check" name="type" id="type-expense" value="expense" autocomplete="off">
                                <label class="btn btn-outline-danger" for="type-expense">Pengeluaran</label>
                            </div>
                            <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="amount" class="col-md-4 col-form-label">Jumlah</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="amount" name="amount" value="<?php echo e(old('amount')); ?>" required>
                                <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="category" class="col-md-4 col-form-label">Kategori</label>
                        <div class="col-md-8">
                            <select class="form-select <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="category" name="category" required>
                                <option value="">-- Pilih Kategori --</option>

                                <optgroup label="Pemasukan" id="category-income">
                                    <option value="Gaji" <?php echo e(old('category') == 'Gaji' ? 'selected' : ''); ?>>Gaji</option>
                                    <option value="Bonus" <?php echo e(old('category') == 'Bonus' ? 'selected' : ''); ?>>Bonus</option>
                                    <option value="Investasi" <?php echo e(old('category') == 'Investasi' ? 'selected' : ''); ?>>Investasi</option>
                                    <option value="Lainnya" <?php echo e(old('category') == 'Lainnya' ? 'selected' : ''); ?>>Lainnya</option>
                                </optgroup>

                                <optgroup label="Pengeluaran" id="category-expense" style="display: none;">
                                    <option value="Makanan" <?php echo e(old('category') == 'Makanan' ? 'selected' : ''); ?>>Makanan</option>
                                    <option value="Transportasi" <?php echo e(old('category') == 'Transportasi' ? 'selected' : ''); ?>>Transportasi</option>
                                    <option value="Tempat Tinggal" <?php echo e(old('category') == 'Tempat Tinggal' ? 'selected' : ''); ?>>Tempat Tinggal</option>
                                    <option value="Lainnya" <?php echo e(old('category') == 'Lainnya' ? 'selected' : ''); ?>>Lainnya</option>
                                </optgroup>
                            </select>
                            <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="date" class="col-md-4 col-form-label">Tanggal</label>
                        <div class="col-md-8">
                            <input type="date" class="form-control <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="date" name="date" value="<?php echo e(old('date', date('Y-m-d'))); ?>" required>
                            <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="description" class="col-md-4 col-form-label">Deskripsi</label>
                        <div class="col-md-8">
                            <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      id="description" name="description" rows="3"><?php echo e(old('description')); ?></textarea>
                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Simpan Transaksi
                            </button>
                            <a href="<?php echo e(route('transactions.index')); ?>" class="btn btn-secondary">
                                Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const incomeRadio = document.getElementById('type-income');
        const expenseRadio = document.getElementById('type-expense');
        const incomeGroup = document.getElementById('category-income');
        const expenseGroup = document.getElementById('category-expense');

        function updateCategoryVisibility() {
            if (incomeRadio.checked) {
                incomeGroup.style.display = 'block';
                expenseGroup.style.display = 'none';
            } else {
                incomeGroup.style.display = 'none';
                expenseGroup.style.display = 'block';
            }
        }

        incomeRadio.addEventListener('change', updateCategoryVisibility);
        expenseRadio.addEventListener('change', updateCategoryVisibility);

        // Panggil saat pertama kali
        updateCategoryVisibility();
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\financial_app\resources\views/transactions/create.blade.php ENDPATH**/ ?>