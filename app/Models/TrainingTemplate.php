<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $type
 * @property integer $price
 * @property integer $energy_consumption
 * @property integer $max_clients
 * @property integer $duration
 * @property string $created_at
 * @property string $updated_at
 */
class TrainingTemplate extends Model
{
    use HasFactory;

    public const TABLE = 'training_templates';

    protected $table = self::TABLE;

    protected $fillable = [
        'name',
        'description',
        'type',
        'price',
        'energy_consumption',
        'max_clients',
        'duration',
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
        'duration' => 'integer',
        'created_at' => 'string',
        'updated_at' => 'string',
    ];
}
