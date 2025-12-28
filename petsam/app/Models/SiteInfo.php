<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteInfo extends Model
{
    protected $table = 'site_infos';
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'youtube_url',
        'description',
    ];
}
