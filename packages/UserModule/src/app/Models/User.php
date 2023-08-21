<?php

namespace UserModule\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'is_admin',
        'is_active',
    ];

    /**
     * Scope a query to only include popular users.
     */
    public function scopeFilterByUsername($query, $username)
    {
        return $query->where('username', 'like', '%' . $username . '%');
    }

    public function scopeFilterByEmail($query, $email)
    {
        return $query->where('email', 'like', '%' . $email . '%');
    }

    public function scopeFilterByName($query, $name)
    {
        return $query->where(function ($query) use ($name) {
            $query->where('first_name', 'like', '%' . $name . '%')
                ->orWhere('last_name', 'like', '%' . $name . '%');
        });
    }

    public function scopeFilterByIsActive($query, $isActive)
    {
        return $query->where('is_active', (int)$isActive);
    }

    public function scopeFilterByIsAdmin($query, $isAdmin)
    {
        return $query->where('is_admin', (int)$isAdmin);
    }

    /**
     * @return string[]
     */
    public function getFillable(): array
    {
        return $this->fillable;
    }

    /**
     * @param string[] $fillable
     */
    public function setFillable(array $fillable): void
    {
        $this->fillable = $fillable;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected $dates = ['deleted_at'];


    protected $appends = ['full_name', 'address'];

    public function getFullNameAttribute()
    {
        return $this->first_name . '_' . $this->last_name;
    }

    public function getAddressAttribute()
    {
        if ($this->addresses()->exists()) {
            return $this->addresses()->first();
        }
        return null;
    }

//    public function addresses()
//    {
//        return $this->hasMany(Address::class, 'addressable_id');
//    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'addressable_id');
    }
}
