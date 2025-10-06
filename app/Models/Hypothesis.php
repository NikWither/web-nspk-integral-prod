<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hypothesis extends Model
{
    use HasFactory;

    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_RESOLVED = 'resolved';

    /** @var array<int, string> */
    protected $fillable = [
        'user_id',
        'user_location',
        'date_range',
        'hypothesis',
        'mcc_code',
        'status',
    ];

    protected $attributes = [
        'status' => self::STATUS_IN_PROGRESS,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

