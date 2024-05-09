<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property integer $id
 * @property integer $instructor_id
 * @property string $experience
 * @property string $qualification
 * @property string|null $description
 * @property string|null $image
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
        'description',
        'image',
    ];

    protected $casts = [
        'id' => 'integer',
        'instructor_id' => 'integer',
        'experience' => 'string',
        'qualification' => 'string',
        'description' => 'string',
        'image' => 'string',
    ];
}
