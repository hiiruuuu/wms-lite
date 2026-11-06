<?php

namespace App\Services;

use App\Models\Product;
use App\Models\StockMutation;
use Illuminate\Support\Facades\DB;
use Exception;

class StockMutationService
{
    /**
     * Memproses Mutasi Stok secara atomis menggunakan DB Transaction dan Pessimistic Locking.
     */
    public function executeMutation(array $data, int $userId): StockMutation
    {
        return DB::transaction(function () use ($data, $userId) {
            // 1. Lock record produk menggunakan lockForUpdate() untuk mencegah Race Condition
            $product = Product::where('id', $data['product_id'])
                ->lockForUpdate()
                ->firstOrFail();

            $type = $data['type']; // 'in' atau 'out'
            $quantity = (int) $data['quantity'];

            // 2. Validasi Stok jika Barang Keluar
            if ($type === 'out' && $product->stock < $quantity) {
                throw new Exception("Gagal! Stok barang '{$product->name}' tidak mencukupi. Stok tersedia: {$product->stock} {$product->unit}.");
            }

            // 3. Kalkulasi Stok Baru
            $newStock = ($type === 'in') 
                ? $product->stock + $quantity 
                : $product->stock - $quantity;

            // 4. Update Stok di Tabel Product
            $product->update(['stock' => $newStock]);

            // 5. Buat Log Mutasi di Tabel StockMutation
            $refPrefix = ($type === 'in') ? 'MUT-IN' : 'MUT-OUT';
            $referenceNumber = $refPrefix . '-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));

            return StockMutation::create([
                'user_id'          => $userId,
                'product_id'       => $product->id,
                'supplier_id'      => $data['supplier_id'] ?? null,
                'type'             => $type,
                'quantity'         => $quantity,
                'reference_number' => $referenceNumber,
                'notes'            => $data['notes'] ?? null,
            ]);
        });
    }
}