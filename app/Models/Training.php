<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $type
 * @property Carbon $date
 * @property integer $duration
 * @property integer $instructor_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
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
        'date',
        'duration',
        'instructor_id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'type' => 'string',
        'date' => 'datetime',
        'duration' => 'integer',
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
