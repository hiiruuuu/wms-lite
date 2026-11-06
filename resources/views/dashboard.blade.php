<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - WMS-Lite</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-blue-600 text-white px-6 py-4 flex justify-between items-center shadow">
        <h1 class="text-xl font-bold">WMS-Lite Dashboard</h1>
        <div class="flex items-center gap-4">
            <span class="text-sm">Halo, <strong>{{ auth()->user()->name }}</strong>
                ({{ auth()->user()->getRoleNames()->implode(', ') }})</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="bg-red-500 px-3 py-1 rounded text-sm hover:bg-red-600 transition">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-8">

        <!-- Statistik Kartu Ringkasan (Metric Cards) -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow border-l-4 border-blue-500">
                <p class="text-sm text-gray-500 font-medium">Total Produk</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ \App\Models\Product::count() }}</h3>
            </div>
            <div class="bg-white p-6 rounded-xl shadow border-l-4 border-green-500">
                <p class="text-sm text-gray-500 font-medium">Total Kategori</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ \App\Models\Category::count() }}</h3>
            </div>
            <div class="bg-white p-6 rounded-xl shadow border-l-4 border-red-500">
                <p class="text-sm text-gray-500 font-medium">Stok Kritis</p>
                <h3 class="text-2xl font-bold text-red-600 mt-1">{{ $lowStockProducts->count() }}</h3>
            </div>
            <div class="bg-white p-6 rounded-xl shadow border-l-4 border-purple-500">
                <p class="text-sm text-gray-500 font-medium">Total Mutasi Tercatat</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ \App\Models\StockMutation::count() }}</h3>
            </div>
        </div>

        <!-- Menu / Tombol Aksi Cepat -->
        <!-- Ganti bagian Menu & Navigasi Cepat menjadi seperti ini -->
        <div class="bg-white p-6 rounded-xl shadow mb-8">
            <h2 class="text-md font-bold text-gray-700 mb-4">Menu & Navigasi Cepat</h2>
            <div class="flex flex-wrap gap-4">
                <!-- Tombol Mutasi Stok (Terbuka untuk semua user logged-in) -->
                <a href="{{ route('mutations.index') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 text-sm font-medium transition flex items-center gap-2">
                    📦 Kelola Mutasi Stok
                </a>

                @canany(['admin', 'manager'])
                    <a href="{{ route('reports.export-pdf') }}"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700 text-sm font-medium transition flex items-center gap-2">
                        📄 Download Laporan PDF
                    </a>
                @endcanany
            </div>
        </div>

        <!-- Restock Alert Section -->
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-bold text-red-600 mb-4 flex items-center gap-2">
                ⚠️ Peringatan Stok Kritis (Restock Alert)
            </h2>

            @if ($lowStockProducts->isEmpty())
                <p class="text-gray-500 text-sm">Semua stok produk aman di atas batas minimum.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-left text-sm text-gray-600">
                                <th class="p-3 border">SKU</th>
                                <th class="p-3 border">Nama Produk</th>
                                <th class="p-3 border">Stok Saat Ini</th>
                                <th class="p-3 border">Batas Min. Stok</th>
                                <th class="p-3 border">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lowStockProducts as $product)
                                <tr class="text-sm hover:bg-gray-50">
                                    <td class="p-3 border font-mono">{{ $product->sku }}</td>
                                    <td class="p-3 border font-medium">{{ $product->name }}</td>
                                    <td class="p-3 border text-red-600 font-bold">{{ $product->stock }}
                                        {{ $product->unit }}</td>
                                    <td class="p-3 border">{{ $product->min_stock }} {{ $product->unit }}</td>
                                    <td class="p-3 border">
                                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-bold">Perlu
                                            Restock</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</body>

</html>
