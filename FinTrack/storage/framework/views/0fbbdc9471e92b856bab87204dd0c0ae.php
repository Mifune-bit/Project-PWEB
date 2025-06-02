

<?php $__env->startSection('title', 'Backup & Restore'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Backup Transaksi</h5>
                <p class="card-text">Klik tombol di bawah untuk mengunduh backup data transaksi Anda.</p>
                <a href="<?php echo e(route('backup.download')); ?>" class="btn btn-primary">
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
                <form action="<?php echo e(route('backup.restore')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\financial_app\resources\views/backup/index.blade.php ENDPATH**/ ?>