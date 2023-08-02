<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = ['email','first_name','last_name','is_active', 'phone'];

    // Define the many-to-many relationship with the Inventory model
    protected $casts = [
        'is_active' => 'boolean',
    ];

//    public function scopeFilterByName($query, $name)
//    {
//        return $query->where('name', 'like', '%' . $name . '%');
//    }
//
//    public function scopeFilterByEmail($query, $email)
//    {
//        return $query->where('email', 'like', '%' . $email . '%');
//    }

    protected $guarded = ['is_active'];

    public function addresses()
    {
        return $this->hasMany(Address::class, 'addressable_id');
    }

    public function vendorItems()
    {
        return $this->hasone(VendorItem::class);
    }

}
