<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use App\Models\Traits\Sortable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $type
 * @property integer $price
 * @property integer $energy_consumption
 * @property integer $max_clients
 * @property string $datetime_start
 * @property string $datetime_end
 * @property integer $instructor_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $instructor
 * @property Collection|Reservation[] $reservations
 * @property Collection|User[] $clients
 * @property Collection|Rating[] $ratings
 */
class Training extends Model
{
    use HasFactory;
    use Filterable;
    use Sortable;

    public const TABLE = 'trainings';

    protected $table = self::TABLE;

    protected $fillable = [
        'name',
        'description',
        'type',
        'price',
        'energy_consumption',
        'max_clients',
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
        'energy_consumption' => 'integer',
        'max_clients' => 'integer',
        'datetime_start' => 'string',
        'datetime_end' => 'string',
        'instructor_id' => 'integer',
        'created_at' => 'string',
        'updated_at' => 'string',
    ];

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'instructor_id',
            'id'
        );
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(
            Reservation::class,
            'training_id',
            'id'
        );
    }

    public function clients(): HasManyThrough
    {
        return $this->hasManyThrough(
            User::class,
            Reservation::class,
            'training_id',
            'id',
            'id',
            'client_id'
        );
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(
            Rating::class,
            'training_id',
            'id'
        );
    }
}
