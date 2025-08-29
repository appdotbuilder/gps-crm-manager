<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\InventoryItem
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $sku
 * @property string|null $serial_number
 * @property int $stock_level
 * @property int $minimum_stock
 * @property string $purchase_cost
 * @property string $selling_price
 * @property string|null $vendor
 * @property string|null $vendor_details
 * @property int|null $warranty_months
 * @property string|null $warehouse_location
 * @property string|null $description
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem whereMinimumStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem wherePurchaseCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem whereSellingPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem whereSerialNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem whereStockLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem whereVendor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem whereVendorDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem whereWarehouseLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem whereWarrantyMonths($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem lowStock()
 * @method static \Database\Factories\InventoryItemFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class InventoryItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'type',
        'sku',
        'serial_number',
        'stock_level',
        'minimum_stock',
        'purchase_cost',
        'selling_price',
        'vendor',
        'vendor_details',
        'warranty_months',
        'warehouse_location',
        'description',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'stock_level' => 'integer',
        'minimum_stock' => 'integer',
        'purchase_cost' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'warranty_months' => 'integer',
    ];

    /**
     * Scope a query to only include low stock items.
     */
    public function scopeLowStock($query)
    {
        return $query->whereRaw('stock_level <= minimum_stock');
    }
}