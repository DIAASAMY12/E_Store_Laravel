<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'city_id', 'phone', 'is_active'];

    // Define the relationship with the Vendor model (Many-to-One)
    protected $guarded = [];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function inventoryItems()
    {
        return $this->hasone(InventoryItem::class);
    }

}
