<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $type
 * @property integer $price
 * @property string $datetime_start
 * @property string $datetime_end
 * @property integer $instructor_id
 * @property string $created_at
 * @property string $updated_at
 */
class Training extends Model
{
    use HasFactory;

    public const TABLE = 'trainings';

    protected $table = self::TABLE;

    protected $fillable = [
        'name',
        'description',
        'type',
        'price',
        'datetime_start',
        'datetime_end',
        'instructor_id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'type' => 'string',
        'price' => 'integer',
        'datetime_start' => 'datetime',
        'datetime_end' => 'datetime',
        'instructor_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'instructor_id',
            'id'
        );
    }
}
