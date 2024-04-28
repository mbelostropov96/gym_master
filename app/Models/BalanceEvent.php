<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property integer $client_id
 * @property integer $old_balance
 * @property integer $balance_change
 * @property string $description
 * @property string $created_at
 */
class BalanceEvent extends Model
{
    use HasFactory;

    public const TABLE = 'balance_events';

    protected $table = self::TABLE;

    protected $fillable = [
        'client_id',
        'old_balance',
        'balance_change',
        'description',
        'created_at',
    ];

    protected $casts = [
        'client_id' => 'integer',
        'old_balance' => 'integer',
        'balance_change' => 'integer',
        'description' => 'string',
        'created_at' => 'datetime',
    ];

    public static function boot(): void
    {
        parent::boot();

        static::creating(function (self $model) {
            $model->created_at = time();
        });
    }
}
