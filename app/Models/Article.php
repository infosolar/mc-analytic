<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Article
 * @package App\Models
 *
 * @property int $id
 * @property string $url
 * @property string $name
 * @property int $views
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Article extends Model
{
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $fillable = [
        'url',
        'name',
        'views',
        'created_at',
        'updated_at',
    ];
}
