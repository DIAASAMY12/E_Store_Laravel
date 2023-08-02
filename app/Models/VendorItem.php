<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorItem extends Model
{
    use HasFactory;

    protected $fillable = ['vendor_id','item_id', 'quantity'];

    protected $guarded = [];

    public $incrementing = false;

    protected $table = 'vendor_items';
    protected $primaryKey = ['vendor_id', 'item_id'];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

}
