<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name', 'description', 'slug'];
    protected $casts = ['created_at' => 'datetime', 'updated_at' => 'datetime'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }
}
