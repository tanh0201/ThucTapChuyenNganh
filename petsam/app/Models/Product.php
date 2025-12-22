<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'stock',
        'sku',
        'low_stock_threshold',
        'stock_status',
        'image',
        'status',
        'views',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'price' => 'integer',
        'stock' => 'integer',
        'low_stock_threshold' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: Product belongs to Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relationship: Product has many OrderItems
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Relationship: Product has many Ratings
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Scope: Get only active products
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope: Get products by category
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope: Get low stock products
     */
    public function scopeLowStock($query)
    {
        return $query->whereRaw('stock <= low_stock_threshold');
    }

    /**
     * Scope: Get out of stock products
     */
    public function scopeOutOfStock($query)
    {
        return $query->where('stock', '<=', 0);
    }

    /**
     * Check if product is available
     */
    public function isAvailable()
    {
        return $this->status === 'active' && $this->stock > 0;
    }

    /**
     * Check if has low stock
     */
    public function hasLowStock()
    {
        return $this->stock <= $this->low_stock_threshold && $this->stock > 0;
    }

    /**
     * Get stock status
     */
    public function getStockStatus()
    {
        if ($this->stock <= 0) {
            return 'out_of_stock';
        } elseif ($this->stock <= $this->low_stock_threshold) {
            return 'low_stock';
        }
        return 'in_stock';
    }

    /**
     * Update stock status (called after stock change)
     */
    public function updateStockStatus()
    {
        $this->stock_status = $this->getStockStatus();
        $this->save();
    }}