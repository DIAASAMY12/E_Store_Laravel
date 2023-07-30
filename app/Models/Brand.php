<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'notes', 'icon'];

    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(Item::class);
    }




}
