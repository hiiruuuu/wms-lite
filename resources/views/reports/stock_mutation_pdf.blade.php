<!DOCTYPE html>
<html>
<head>
    <title>Laporan Mutasi Stok - WMS Lite</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        .badge-in { color: green; font-weight: bold; }
        .badge-out { color: red; font-weight: bold; }
        .header { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN AUDIT MUTASI BARANG</h2>
        <p>Periode: {{ $startDate }} s/d {{ $endDate }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No. Referensi</th>
                <th>Tanggal</th>
                <th>Produk (SKU)</th>
                <th>Tipe</th>
                <th>Jumlah</th>
                <th>Petugas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mutations as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->reference_number }}</td>
                <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $item->product->name }} ({{ $item->product->sku }})</td>
                <td>
                    <span class="{{ $item->type == 'in' ? 'badge-in' : 'badge-out' }}">
                        {{ strtoupper($item->type) }}
                    </span>
                </td>
                <td>{{ $item->quantity }} {{ $item->product->unit }}</td>
                <td>{{ $item->user->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>