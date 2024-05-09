<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property integer $id
 * @property integer $client_id
 * @property integer $training_id
 * @property integer $price
 *
 * @property Training $training
 */
class Reservation extends Model
{
    use HasFactory;

    public const TABLE = 'reservations';

    protected $table = self::TABLE;

    protected $fillable = [
        'client_id',
        'training_id',
        'price',
    ];

    protected $casts = [
        'id' => 'integer',
        'client_id' => 'integer',
        'training_id' => 'integer',
        'price' => 'integer',
    ];

    public function training(): BelongsTo
    {
        return $this->belongsTo(
            Training::class,
            'training_id',
            'id'
        );
    }
}
