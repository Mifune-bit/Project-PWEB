

<?php $__env->startSection('title', 'Dasbor'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <h2>Selamat datang, <?php echo e(auth()->user()->name); ?></h2>
        <p>Ini adalah dasbor pribadi Anda.</p>
        
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Pemasukan</h5>
                        <p class="card-text h4">Rp <?php echo e(number_format($totalIncome, 0, ',', '.')); ?></p>
                        <a href="<?php echo e(route('transactions.index', ['type' => 'income'])); ?>" class="text-white">Lihat Detail</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Pengeluaran</h5>
                        <p class="card-text h4">Rp <?php echo e(number_format($totalExpense, 0, ',', '.')); ?></p>
                        <a href="<?php echo e(route('transactions.index', ['type' => 'expense'])); ?>" class="text-white">Lihat Detail</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Saldo Saat Ini</h5>
                        <p class="card-text h4">Rp <?php echo e(number_format($balance, 0, ',', '.')); ?></p>
                        <a href="<?php echo e(route('transactions.index')); ?>" class="text-white">Lihat Semua Transaksi</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <h5>Transaksi Terbaru</h5>
            </div>
            <div class="card-body">
                <?php if($recentTransactions->count() > 0): ?>
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
                            <?php $__currentLoopData = $recentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($transaction->date->format('d M Y')); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo e($transaction->type === 'income' ? 'success' : 'danger'); ?>">
                                            <?php echo e($transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran'); ?>

                                        </span>
                                    </td>
                                    <td><?php echo e($transaction->category); ?></td>
                                    <td class="<?php echo e($transaction->type === 'income' ? 'text-success' : 'text-danger'); ?>">
                                        Rp <?php echo e(number_format($transaction->amount, 0, ',', '.')); ?>

                                    </td>
                                    <td><?php echo e($transaction->description ?? '-'); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <a href="<?php echo e(route('transactions.index')); ?>" class="btn btn-primary">Lihat Semua Transaksi</a>
                <?php else: ?>
                    <p>Belum ada transaksi. <a href="<?php echo e(route('transactions.create')); ?>">Tambahkan transaksi pertama Anda</a></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\financial_app\resources\views/dashboard.blade.php ENDPATH**/ ?>