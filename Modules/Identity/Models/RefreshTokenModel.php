<?php

namespace Modules\Identity\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class RefreshTokenModel extends Model
{
    protected $table = 'refresh_tokens';

    protected $fillable = [
        'token',
        'device_name',
        'expires_at',
        'access_token_id'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];


    public function tokenable(): MorphTo
    {
        return $this->morphTo();
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }
}
