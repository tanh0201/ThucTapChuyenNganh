<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];

    /**
     * Relationship: Role has many Permissions
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions', 'role_id', 'permission_id')
                    ->select('permissions.id', 'permissions.name', 'permissions.display_name', 'permissions.description', 'permissions.created_at', 'permissions.updated_at');
    }

    /**
     * Relationship: Role has many Users
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
