<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'sku', 'name', 'stock', 'min_stock', 'unit'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function mutations()
    {
        return $this->hasMany(StockMutation::class);
    }

    // Local Scope: Filter produk yang mengalami stok kritis
    public function scopeLowStock($query)
    {
        return $query->whereColumn('stock', '<=', 'min_stock');
    }
}
