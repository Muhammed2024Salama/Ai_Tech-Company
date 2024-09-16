<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * @var string
     */
    protected $table = 'settings';

    /**
     * @var string[]
     */
    protected $fillable = [
        'logo',
        'favicon',
        'app_name',
        'app_status',
        'social_media',
        'email',
        'phone',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'app_status' => 'boolean',
    ];
}
