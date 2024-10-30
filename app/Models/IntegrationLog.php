<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class IntegrationLog
 * @package App\Models
 *
 * @property int $id
 * @property string $message
 * @property Carbon $sync_period_from
 * @property Carbon $sync_period_to
 * @property int $sync_offset
 * @property bool $sync_status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class IntegrationLog extends Model
{
    protected $casts = [
        'sync_period_from' => 'datetime',
        'sync_period_to' => 'datetime',
        'sync_status' => 'boolean',
    ];

    protected $fillable = [
        'message',
        'sync_period_from',
        'sync_period_to',
        'sync_offset',
        'sync_status',
        'created_at',
        'updated_at',
    ];
}
