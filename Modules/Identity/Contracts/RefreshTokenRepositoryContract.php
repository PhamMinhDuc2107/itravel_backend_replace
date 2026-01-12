
<?php

use Illuminate\Database\Eloquent\Model;

interface RefreshTokenRepositoryContract
{
    /**
     * @param $user
     * @param string $deviceName
     * @param int|null $accessTokenId
     * @return Model|null
     */
    public function createRefreshToken($user, string $deviceName, int $accessTokenId = null): ?Model;

    /**
     * @param string $token
     * @return Model|null
     */
    public function findValidToken(string $token): ?Model;
}
