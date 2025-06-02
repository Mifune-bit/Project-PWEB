

<?php $__env->startSection('title', 'User Transactions'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Transactions for <?php echo e($user->name); ?></h5>
                <div>
                    <a href="<?php echo e(route('admin.users')); ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to Users
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card bg-success text-white">
                            <div class="card-body p-3">
                                <h6 class="card-title">Total Income</h6>
                                <p class="card-text h4">Rp <?php echo e(number_format($totalIncome, 0, ',', '.')); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-danger text-white">
                            <div class="card-body p-3">
                                <h6 class="card-title">Total Expense</h6>
                                <p class="card-text h4">Rp <?php echo e(number_format($totalExpense, 0, ',', '.')); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-primary text-white">
                            <div class="card-body p-3">
                                <h6 class="card-title">Balance</h6>
                                <p class="card-text h4">Rp <?php echo e(number_format($balance, 0, ',', '.')); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if($transactions->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($transaction->date->format('d M Y')); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo e($transaction->type === 'income' ? 'success' : 'danger'); ?>">
                                                <?php echo e(ucfirst($transaction->type)); ?>

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
                    </div>
                    <div class="mt-3">
                        <?php echo e($transactions->links()); ?>

                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        No transactions found for this user.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\financial_app\resources\views/admin/user_transactions.blade.php ENDPATH**/ ?>