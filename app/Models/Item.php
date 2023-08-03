<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'brand_id', 'is_active', 'price', 'total_purchases', 'total_sales', 'stop_purchasing'];

    protected $guarded = [];

    public function scopeByTotalQuantity($query, $threshold = 50)
    {
        return $query->whereHas('inventoryItems', function ($query) use ($threshold) {
            $query->selectRaw('item_id, sum(quantity) as total_quantity')
                ->groupBy('item_id')
                ->havingRaw('total_quantity > ?', [$threshold]);
        });
    }


    public function scopeByBrand($query, $brandId)
    {
        return $query->where('brand_id', $brandId);
    }

//    public function scopeByVendor($query, $vendorId)
//    {
//        return $query->whereHas('vendors', function ($query) use ($vendorId) {
//            $query->where('vendor_id', $vendorId);
//        });
//    }

    public function scopeByVendor($query, $vendorId)
    {
        return $query->join('vendor_items', 'items.id', '=', 'vendor_items.item_id')
            ->where('vendor_items.vendor_id', $vendorId)
            ->select('items.*');
    }


    public function scopeByInventory($query, $inventoryId)
    {
        return $query->whereHas('inventories', function ($query) use ($inventoryId) {
            $query->where('inventory_id', $inventoryId);
        });
    }

    public function scopeByInventoryItem($query, $inventoryId)
    {
        return $query->whereHas('inventoryItems', function ($query) use ($inventoryId) {
            $query->where('inventory_id', $inventoryId);
        });
    }

    public function scopeTotalQuantityExceeds($query, $quantity)
    {
        return $query->whereHas('inventoryItems', function ($query) use ($quantity) {
            $query->groupBy('item_id')
                ->havingRaw('SUM(quantity) > ?', [$quantity]);
        });
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

//    public function inventoryItems()
//    {
//        return $this->hasMany(InventoryItem::class);
//    }

    public function vendorItems()
    {
        return $this->hasone(VendorItem::class);
    }

    public function inventoryItems()
    {
        return $this->hasone(InventoryItem::class);
    }

    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'vendor_items', 'item_id', 'vendor_id')
            ->withPivot('quantity');
    }

    public function vendor(): BelongsToMany
    {
        return $this->belongsToMany(Vendor::class, 'vendor_items', 'item_id', 'vendor_id')
            ->withPivot('quantity');
    }

    public function inventories()
    {
        return $this->belongsToMany(Inventory::class, 'inventory_items', 'item_id', 'inventory_id')
            ->withPivot('quantity');
    }

//    public function inventoryItems()
//    {
//        return $this->belongsTo(Inventory::class, 'inventory_items', 'item_id', 'inventory_id')
//            ->withPivot('quantity');
//    }

    public function addQuantityToInventory($quantity)
    {
        $this->total_purchases += $quantity;
        $this->save();
    }


}
