<?php

namespace Modules\Identity\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Identity\DTO\Auth\LoginDTO;
use Modules\Identity\Http\Requests\Auth\LoginRequest;
use Modules\Identity\Services\AuthService;


class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}


    public function login(LoginRequest $request)
    {
        $loginDTO = LoginDTO::fromRequest($request);


        return response()->json([
            'success' => true,
            'message' => __('messages.success.login'),
            'data'    => $loginDTO
        ]);
    }


    public function refreshToken(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'refresh_token' => 'required|string'
        ]);

        $result = $this->authService->refreshToken($request->refresh_token);

        return response()->json([
            'success' => true,
            'message' => 'Làm mới token thành công.',
            'data'    => $result
        ]);
    }


    public function logout(Request $request)
    {

        $this->authService->logout($request->user());

        return response()->json([
            'success' => true,
            'message' => __('messages.success.logout'),
        ]);
    }


    public function me(Request $request)
    {
        return response()->json([
            'success' => true,
            'data'    => $request->user()
        ]);
    }
}
