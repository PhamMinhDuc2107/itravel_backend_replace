<?php

namespace Modules\Identity\Repositories;

use Illuminate\Database\Eloquent\Model;
use Modules\Identity\Models\RefreshTokenModel;
use Modules\Shared\Repositories\BaseRepository;
use Illuminate\Support\Str;
use Carbon\Carbon;
use RefreshTokenRepositoryContract;

class RefreshTokenRepository extends BaseRepository implements RefreshTokenRepositoryContract
{
    public function getModel(): string
    {
        return RefreshTokenModel::class;
    }


    public function createRefreshToken($user, string $deviceName, int $accessTokenId = null): ?Model
    {
        return $this->query()->create([
            'token'           => Str::random(64),
            'tokenable_id'    => $user->id,
            'tokenable_type'  => get_class($user),
            'device_name'     => $deviceName,
            'access_token_id' => $accessTokenId,
            'expires_at'      => Carbon::now()->addDays(30)
        ]);
    }


    public function findValidToken(string $token): ?Model
    {
        return $this->query()
            ->where('token', $token)
            ->where('expires_at', '>', Carbon::now())
            ->first();
    }
}
