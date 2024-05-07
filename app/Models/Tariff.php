<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property integer $id
 * @property string $name
 * @property integer $number_of_trainings
 * @property integer $discount
 */
class Tariff extends Model
{
    use HasFactory;

    public const TABLE = 'tariffs';

    protected $table = self::TABLE;

    protected $fillable = [
        'name',
        'number_of_trainings',
        'discount',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'number_of_trainings' => 'integer',
        'discount' => 'integer',
    ];
}
