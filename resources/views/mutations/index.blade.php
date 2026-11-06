<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mutasi Stok - WMS-Lite</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-blue-600 text-white px-6 py-4 flex justify-between items-center shadow">
        <h1 class="text-xl font-bold"><a href="{{ route('dashboard') }}">WMS-Lite</a> / Mutasi Stok</h1>
        <a href="{{ route('dashboard') }}" class="bg-gray-700 px-3 py-1 rounded text-sm">Kembali ke Dashboard</a>
    </nav>

    <div class="container mx-auto px-6 py-8">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded shadow">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded shadow">{{ session('error') }}</div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Form Input Mutasi -->
            <div class="bg-white p-6 rounded-xl shadow h-fit">
                <h2 class="text-lg font-bold mb-4 text-gray-800">Catat Mutasi Barang</h2>
                <form action="{{ route('mutations.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="block text-sm font-bold mb-1">Pilih Produk</label>
                        <select name="product_id" required class="w-full px-3 py-2 border rounded text-sm">
                            <option value="">-- Pilih Produk --</option>
                            @foreach(\App\Models\Product::all() as $prod)
                                <option value="{{ $prod->id }}">{{ $prod->name }} (Stok: {{ $prod->stock }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="block text-sm font-bold mb-1">Tipe Mutasi</label>
                        <select name="type" required class="w-full px-3 py-2 border rounded text-sm">
                            <option value="in">Barang Masuk (IN)</option>
                            <option value="out">Barang Keluar (OUT)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="block text-sm font-bold mb-1">Jumlah (Quantity)</label>
                        <input type="number" name="quantity" min="1" required class="w-full px-3 py-2 border rounded text-sm">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-1">Catatan / Keterangan</label>
                        <textarea name="notes" rows="2" class="w-full px-3 py-2 border rounded text-sm"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded font-bold hover:bg-blue-700 text-sm">
                        Simpan Mutasi (Aman & Atomis)
                    </button>
                </form>
            </div>

            <!-- Tabel Riwayat Mutasi -->
            <div class="md:col-span-2 bg-white p-6 rounded-xl shadow">
                <h2 class="text-lg font-bold mb-4 text-gray-800">Riwayat Mutasi Stok</h2>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-left text-xs text-gray-600">
                                <th class="p-2 border">No. Ref</th>
                                <th class="p-2 border">Waktu</th>
                                <th class="p-2 border">Produk</th>
                                <th class="p-2 border">Tipe</th>
                                <th class="p-2 border">Jumlah</th>
                                <th class="p-2 border">Petugas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mutations as $item)
                            <tr class="text-xs hover:bg-gray-50">
                                <td class="p-2 border font-mono">{{ $item->reference_number }}</td>
                                <td class="p-2 border">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                <td class="p-2 border">{{ $item->product->name ?? '-' }}</td>
                                <td class="p-2 border font-bold {{ $item->type == 'in' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ strtoupper($item->type) }}
                                </td>
                                <td class="p-2 border">{{ $item->quantity }}</td>
                                <td class="p-2 border">{{ $item->user->name ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $mutations->links() }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>