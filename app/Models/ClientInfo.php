<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientInfo extends Model
{
    use HasFactory;

    public const TABLE = 'client_info';

    protected $table = self::TABLE;

    protected $fillable = [
        'client_id',
        'balance',
        'tariff_id',
    ];

    protected $casts = [
        'client_id' => 'integer',
        'balance' => 'integer',
        'tariff_id' => 'integer',
    ];
}
