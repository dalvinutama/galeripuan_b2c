<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan Gallery Puan</title>
    <style>
        /* CSS Sederhana khusus untuk kertas PDF */
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #ddd; padding-bottom: 10px; }
        .header h2 { margin: 0; color: #d63384; /* Warna pink/merah khas Gallery Puan */ }
        .summary { margin-bottom: 20px; }
        .summary p { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f8f9fa; font-weight: bold; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Penjualan Gallery Puan</h2>
        <p>Periode: <strong>{{ \Carbon\Carbon::parse($startDate)->format('d M Y') }}</strong> s/d <strong>{{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</strong></p>
    </div>

    <div class="summary">
        <p><strong>Total Pesanan:</strong> {{ $totalOrders }} Pesanan</p>
        <p><strong>Total Pendapatan:</strong> Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>No. Invoice</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Metode Pembayaran</th>
                <th>Status</th>
                <th class="text-right">Total Belanja</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $index => $order)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $order->code }}</td>
                <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i') }}</td>
                <td>{{ $order->customer_first_name }} {{ $order->customer_last_name }}</td>
                <td>{{ strtoupper($order->payment_method ?? 'MIDTRANS') }}</td>
                <td>{{ $order->status }}</td>
                <td class="text-right">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data transaksi pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>