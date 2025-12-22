<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = ['user_id', 'product_id'];

    /**
     * Relationship: Favorite belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: Favorite belongs to Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
