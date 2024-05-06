<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property integer $id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $role
 * @property string $remember_token
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ClientInfo $clientInfo
 * @property InstructorInfo $instructorInfo
 * @property Collection|BalanceEvent[] $balanceEvents
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    public const TABLE = 'users';

    protected $table = self::TABLE;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'password',
        'role',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'id' => 'integer',
        'first_name' => 'string',
        'middle_name' => 'string',
        'last_name' => 'string',
        'email' => 'string',
        'password' => 'hashed',
        'role' => 'string',
        'remember_token' => 'string',
        'created_at' => 'string',
        'updated_at' => 'string',
    ];

    public static function boot(): void
    {
        parent::boot();

        static::creating(function (self $model) {
            if ($model->id !== 1) {
                $model->role = UserRole::CLIENT->value;
            }
        });
    }

    public function clientInfo(): HasOne
    {
        return $this->hasOne(
            ClientInfo::class,
            'client_id',
            'id'
        );
    }

    public function instructorInfo(): HasOne
    {
        return $this->hasOne(
            InstructorInfo::class,
            'instructor_id',
            'id'
        );
    }

    public function balanceEvents(): HasMany
    {
        return $this->hasMany(
            BalanceEvent::class,
            'client_id',
            'id'
        )->orderByDesc('created_at');
    }

    // TODO use \App\Helpers\UserHelper::getFullName
    public function getFullName(): string
    {
        return sprintf(
            '%s %s %s',
            $this->last_name,
            $this->first_name,
            $this->middle_name
        );
    }
}
