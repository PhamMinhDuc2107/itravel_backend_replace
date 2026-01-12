<?php

namespace Modules\Identity\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Identity\Enums\AccountTypeEnum;

class LoginRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'device_name' => $this->input('device_name')
                ?? $this->input('deviceName')
                    ?? $this->header('User-Agent')
                    ?? 'Unknown Device',
        ]);
    }

    public function rules(): array
    {
        return [
            'email'       => ['required', 'email', 'max:255'],
            'password'    => ['required', 'string', 'min:6'],
            'type'        => ['required', Rule::enum(AccountTypeEnum::class)],
            'deviceName'  => ['required', 'string'],
        ];
    }


    public function attributes(): array
    {
        return [
            'email'       => 'địa chỉ email',
            'password'    => 'mật khẩu',
            'device_name' => 'tên thiết bị',
            'type'        => 'loại tài khoản',
        ];
    }


    public function messages(): array
    {
        return [
            'type.in' => 'Loại tài khoản không hợp lệ (chỉ chấp nhận admin, partner, customer).',
        ];
    }
}
