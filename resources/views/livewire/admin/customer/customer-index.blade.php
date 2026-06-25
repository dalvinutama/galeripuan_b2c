<div>
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">Report</div>
                    <h2 class="page-title">Data Konsumen</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <!-- Segmentasi Cards -->
            <div class="row row-cards mb-4">
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-primary text-white avatar"><i class="bx bx-group"></i></span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">Total Konsumen</div>
                                    <div class="text-muted">{{ $totalCustomers }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-success text-white avatar"><i class="bx bx-user-plus"></i></span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">Baru (30 Hari)</div>
                                    <div class="text-muted">{{ $newCustomers }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-info text-white avatar"><i class="bx bx-cart"></i></span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">Aktif (3 Bulan)</div>
                                    <div class="text-muted">{{ $activeCustomers }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-warning text-white avatar"><i class="bx bx-crown"></i></span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">Loyal (>3 Pesanan)</div>
                                    <div class="text-muted">{{ $loyalCustomers }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Daftar Konsumen -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Daftar Konsumen</h3>
                    <div>
                        <select wire:model.live="segment" class="form-select form-select-sm d-inline-block w-auto">
                            <option value="all">Semua Konsumen</option>
                            <option value="new">Pelanggan Baru</option>
                            <option value="active">Pelanggan Aktif</option>
                            <option value="loyal">Pelanggan Loyal</option>
                            <option value="inactive">Pelanggan Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap datatable">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Bergabung Sejak</th>
                                <th>Total Pesanan</th>
                                <th>Status Segmentasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers as $customer)
                                <tr>
                                    <td>
                                        <div class="d-flex py-1 align-items-center">
                                            <span class="avatar me-2" style="background-image: url('{{ asset('static/avatars/000m.jpg') }}')">{{ strtoupper(substr($customer->name, 0, 1)) }}</span>
                                            <div class="flex-fill">
                                                <div class="font-weight-medium">{{ $customer->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-secondary">{{ $customer->email }}</div>
                                    </td>
                                    <td>
                                        {{ $customer->created_at->format('d M Y') }}
                                    </td>
                                    <td>
                                        {{ $customer->orders_count }} Pesanan
                                    </td>
                                    <td>
                                        @if($customer->orders_count > 3)
                                            <span class="badge bg-warning text-white">Loyal</span>
                                        @elseif($customer->created_at >= now()->subDays(30))
                                            <span class="badge bg-success text-white">Baru</span>
                                        @elseif($customer->orders()->where('created_at', '>=', now()->subMonths(3))->exists())
                                            <span class="badge bg-info text-white">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary text-white">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ url('admin/customers/' . $customer->id) }}" class="btn btn-sm btn-primary" wire:navigate>
                                            <i class="bx bx-show me-1"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">Belum ada data konsumen.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($customers->hasPages())
                    <div class="card-footer d-flex align-items-center">
                        {{ $customers->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
