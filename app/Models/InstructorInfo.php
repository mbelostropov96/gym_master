<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $instructor_id
 * @property integer $experience
 * @property string $qualification
 */
class InstructorInfo extends Model
{
    use HasFactory;

    public const TABLE = 'instructor_info';

    protected $table = self::TABLE;

    protected $fillable = [
        'instructor_id',
        'experience',
        'qualification',
    ];

    protected $casts = [
        'id' => 'integer',
        'instructor_id' => 'integer',
        'experience' => 'integer',
        'qualification' => 'string',
    ];
}
