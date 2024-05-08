<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property integer $id
 * @property integer $client_id
 * @property integer $balance
 * @property integer $tariff_id
 */
class ClientInfo extends Model
{
    use HasFactory;

    public const TABLE = 'client_info';

    protected $table = self::TABLE;

    protected $fillable = [
        'client_id',
        'balance',
        'tariff_id',
        'gender',
        'weight',
        'height',
        'age',
    ];

    protected $casts = [
        'id' => 'integer',
        'client_id' => 'integer',
        'balance' => 'integer',
        'tariff_id' => 'integer',
        'gender' => 'string',
        'weight' => 'float',
        'height' => 'float',
        'age' => 'float',
    ];
}
