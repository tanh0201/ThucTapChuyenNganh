<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role_id',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: User belongs to Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relationship: User has many Orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Relationship: User has many Permissions (direct assignment)
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permissions');
    }

    /**
     * Relationship: User has many CustomerCare tickets
     */
    public function customerCareTickets()
    {
        return $this->hasMany(CustomerCare::class);
    }

    /**
     * Relationship: User has many Ratings
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
