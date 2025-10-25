<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class additem extends Model
{
    use HasFactory;

    protected $table = 'additem';

    /**
     * The attributes that are mass assignable.
     * Updated to match database column names (snake_case)
     */
    protected $fillable = [
        'item_name',           // Changed from 'itemName'
        'requisition_id',
        'category',
        'category_type',
        'location',
        'quantity',
        'minimum_stock',       // Changed from 'minimumStock'
        'price',
        'issue',
        'supplier'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'category_type' => 'array', // This will handle JSON encoding/decoding
        'quantity' => 'integer',
        'minimum_stock' => 'integer',
        'price' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Auto-generate requisition_id when creating new items
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->requisition_id)) {
                // Generate requisition ID format: REQ + year + month + sequence number
                $year = date('Y');
                $month = date('m');
                
                // Get the count of items created this month
                $count = static::whereYear('created_at', $year)
                              ->whereMonth('created_at', $month)
                              ->count();
                
                $sequence = $count + 1;
                $model->requisition_id = sprintf('REQ%s%s%03d', $year, $month, $sequence);
            }
        });
    }

    /**
     * Scope for filtering by status
     */
    public function scopeInStock($query)
    {
        return $query->where('quantity', '>', 0)
                    ->whereRaw('quantity > minimum_stock');
    }

    public function scopeLowStock($query)
    {
        return $query->where('quantity', '>', 0)
                    ->whereRaw('quantity <= minimum_stock');
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('quantity', '<=', 0);
    }

    /**
     * Get the status attribute
     */
    public function getStatusAttribute()
    {
        if ($this->quantity <= 0) {
            return 'Out of Stock';
        } elseif ($this->quantity <= $this->minimum_stock) {
            return 'Low Stock';
        }
        return 'In Stock';
    }
}