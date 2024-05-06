<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property integer $id
 * @property integer $client_id
 * @property integer $training_id
 * @property integer $instructor_id
 * @property integer $rating
 */
class Rating extends Model
{
    use HasFactory;

    public const TABLE = 'ratings';

    protected $table = self::TABLE;

    protected $fillable = [
        'client_id',
        'training_id',
        'instructor_id',
        'rating',
    ];

    protected $casts = [
        'id' => 'integer',
        'client_id' => 'integer',
        'training_id' => 'integer',
        'instructor_id' => 'integer',
        'rating' => 'integer',
    ];
}
