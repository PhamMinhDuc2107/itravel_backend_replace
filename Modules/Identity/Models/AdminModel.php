<?php

namespace Modules\Identity\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Shared\Enums\AccountStatusEnum;
use Spatie\Permission\Traits\HasRoles;

class AdminModel extends Authenticatable
{
    use HasApiTokens, HasRoles, HasFactory, Notifiable;

    protected $table = 'admins';

    protected $guard_name = 'admin';


    protected $fillable = [
        'name',
        'email',
        'phone',
        'birthday',
        'avatar',
        'job_title',
        'status',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'birthday' => 'date',
        'status'   => AccountStatusEnum::class
    ];


    public function refreshTokens(): MorphMany
    {
        return $this->morphMany(RefreshTokenModel::class, 'tokenable');
    }


    public function isActive(): bool
    {
        return $this->status === AccountStatusEnum::Active->value;
    }

}
