<?php

declare(strict_types=1);
/**
 * This file is part of Swow-Chat.
 *
 * @link     https://xxx.com
 * @document https://xxx.wiki
 * @license  https://github.com/swow-cloud/swow-websocket/master/LICENSE
 */
namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'mobile' => 'phone|required',
            'password' => 'required',
            'platform' => 'required|in:h5,ios,windows,mac,web',
        ];
    }

    public function messages(): array
    {
        return [
            'mobile.required' => '手机不能为空',
            'mobile.phone' => '手机格式不正确',
            'password.required' => '密码不能为空',
        ];
    }
}
