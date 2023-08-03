<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class InventoryItem extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'inventory_id', 'quantity'];

    protected $guarded = [];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }


}
