

<?php $__env->startSection('title', 'Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Admin Dashboard</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Statistik Pengguna -->
                    <div class="col-md-4 mb-4">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Total Users</h6>
                                        <h2 class="mb-0"><?php echo e($totalUsers); ?></h2>
                                    </div>
                                    <i class="bi bi-people-fill" style="font-size: 2.5rem;"></i>
                                </div>
                                <a href="<?php echo e(route('admin.users')); ?>" class="text-white stretched-link"></a>
                            </div>
                        </div>
                    </div>

                    <!-- Statistik Transaksi -->
                    <div class="col-md-4 mb-4">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Total Transactions</h6>
                                        <h2 class="mb-0"><?php echo e($totalTransactions); ?></h2>
                                    </div>
                                    <i class="bi bi-cash-stack" style="font-size: 2.5rem;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistik Saldo -->
                    <div class="col-md-4 mb-4">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">System Balance</h6>
                                        <h2 class="mb-0">Rp <?php echo e(number_format($systemBalance, 0, ',', '.')); ?></h2>
                                    </div>
                                    <i class="bi bi-graph-up" style="font-size: 2.5rem;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grafik Aktivitas (Placeholder) -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6>Monthly Activity</h6>
                            </div>
                            <div class="card-body">
                                <div id="activityChart" style="height: 300px;">
                                    <!-- Chart akan diisi oleh JavaScript -->
                                    <canvas id="monthlyActivityChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Daftar Pengguna Terbaru -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6>Recent Users</h6>
                                <a href="<?php echo e(route('admin.users')); ?>" class="btn btn-sm btn-primary">
                                    View All Users <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                            <div class="card-body">
                                <?php if($recentUsers->count() > 0): ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Registered At</th>
                                                    <th>Transactions</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $recentUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($loop->iteration); ?></td>
                                                        <td><?php echo e($user->name); ?></td>
                                                        <td><?php echo e($user->email); ?></td>
                                                        <td><?php echo e($user->created_at->format('d M Y H:i')); ?></td>
                                                        <td><?php echo e($user->transactions_count); ?></td>
                                                        <td>
                                                            <a href="<?php echo e(route('admin.users.show', $user->id)); ?>" 
                                                               class="btn btn-sm btn-outline-primary">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-info">
                                        No users registered yet.
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data untuk chart (contoh)
        const ctx = document.getElementById('monthlyActivityChart').getContext('2d');
        
        // Data dari controller bisa dimasukkan di sini
        const monthlyData = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            datasets: [{
                label: 'New Users',
                data: [12, 19, 15, 25, 22, 30, 28],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                tension: 0.1
            }, {
                label: 'Transactions',
                data: [42, 55, 60, 78, 85, 95, 110],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                tension: 0.1
            }]
        };

        new Chart(ctx, {
            type: 'line',
            data: monthlyData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\financial_app\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>