@extends('layout')

@section('title', 'Admin Dashboard')

@section('content')
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
                                        <h2 class="mb-0">{{ $totalUsers }}</h2>
                                    </div>
                                    <i class="bi bi-people-fill" style="font-size: 2.5rem;"></i>
                                </div>
                                <a href="{{ route('admin.users') }}" class="text-white stretched-link"></a>
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
                                        <h2 class="mb-0">{{ $totalTransactions }}</h2>
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
                                        <h2 class="mb-0">Rp {{ number_format($systemBalance, 0, ',', '.') }}</h2>
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
                                <a href="{{ route('admin.users') }}" class="btn btn-sm btn-primary">
                                    View All Users <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                            <div class="card-body">
                                @if($recentUsers->count() > 0)
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
                                                @foreach($recentUsers as $user)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>{{ $user->created_at->format('d M Y H:i') }}</td>
                                                        <td>{{ $user->transactions_count }}</td>
                                                        <td>
                                                            <a href="{{ route('admin.users.show', $user->id) }}" 
                                                               class="btn btn-sm btn-outline-primary">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="alert alert-info">
                                        No users registered yet.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
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
@endsection