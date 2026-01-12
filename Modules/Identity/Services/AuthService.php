<?php
namespace Modules\Identity\Services;

use Illuminate\Support\Facades\Hash;
use Modules\Identity\DTO\Auth\LoginDTO;
use Modules\Identity\Models\AdminModel;

use Modules\Identity\Repositories\RefreshTokenRepository;
use Modules\Shared\Enums\AccountStatusEnum;
use Moodule\Shared\Http\Exceptions\BusinessException;

class AuthService
{
    public function __construct(
        protected RefreshTokenRepository $refreshTokenRepo
    ) {}


    public function login(LoginDTO $loginDTO): array
    {
        $modelClass = match ($loginDTO->type) {
            'admin'    => AdminModel::class,
//            'partner'  => Partner::class,
//            'customer' => Customer::class,
            default    => throw new BusinessException('Loại tài khoản không hỗ trợ.')
        };

        $user = $modelClass::where('email', $loginDTO->email)->first();

        if (!$user || !Hash::check($loginDTO->password, $user->password)) {
            throw new BusinessException(__('auth.failed'), [], 401);
        }


        if (!$user->isActivate()) {
            throw new BusinessException('Tài khoản của bạn đã bị khóa hoặc chưa kích hoạt.', [], 403);
        }


        $tokenName = "{$loginDTO->type}-{api}";
        $sanctumToken = $user->createToken($tokenName);

        $refreshToken = $this->refreshTokenRepo->createRefreshToken(
            $user,
            $loginDTO->deviceName,
            $sanctumToken->accessToken->id
        );

        return [
            'access_token'  => $sanctumToken->plainTextToken,
            'refresh_token' => $refreshToken->token,
            'token_type'    => 'Bearer',
            'expires_in'    => config('sanctum.expiration', 60) * 60,
            'role_type'     => $loginDTO->type,
            'user_info'     => $user,
        ];
    }


    public function refreshToken(string $oldRefreshToken)
    {
        $record = $this->refreshTokenRepo->findValidToken($oldRefreshToken);

        if (!$record) {
            throw new BusinessException('Refresh Token không hợp lệ hoặc đã hết hạn.', [], 401);
        }

        $user = $record->tokenable;

        if (!$user) {
            $record->delete();
            throw new BusinessException('Người dùng không tồn tại.', [], 401);
        }

        if ($user->status !== AccountStatusEnum::ACTIVE) {
            throw new BusinessException('Tài khoản đã bị khóa.', [], 403);
        }

        $record->delete();
        if ($record->access_token_id) {
            $user->tokens()->where('id', $record->access_token_id)->delete();
        }

        $deviceName = $record->device_name ?? 'Unknown Device';
        $newSanctumToken = $user->createToken($deviceName);

        $newRefreshToken = $this->refreshTokenRepo->createRefreshToken(
            $user,
            $deviceName,
            $newSanctumToken->accessToken->id
        );

        return [
            'access_token'  => $newSanctumToken->plainTextToken,
            'refresh_token' => $newRefreshToken->token,
            'token_type'    => 'Bearer',
            'expires_in'    => config('sanctum.expiration', 60) * 60
        ];
    }


    public function logout($user)
    {
        if ($user) {
            $user->currentAccessToken()->delete();

            // TODO: Nếu muốn logout khỏi thiết bị này hoàn toàn,
            // có thể tìm và xóa luôn RefreshToken tương ứng với device_name hoặc access_token_id
        }
    }
}
