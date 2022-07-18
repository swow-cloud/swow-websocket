<?php

declare(strict_types=1);
/**
 * This file is part of Swow-Chat.
 *
 * @link     https://xxx.com
 * @document https://xxx.wiki
 * @license  https://github.com/swow-cloud/websocket-server/master/LICENSE
 */
namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class RegisterRequest extends FormRequest
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
            'nickname' => 'required|max:20',
            'mobile' => 'required|phone',
            'password' => 'required|max:16',
            'sms_code' => 'required|digits:6',
            'platform' => 'required|in:h5,ios,windows,mac,web',
        ];
    }

    public function messages(): array
    {
        return [
            'nickname.required' => '用户名称不能为空',
            'mobile.required' => '手机不能为空',
            'password.required' => '密码不能为空',
            'sms_code.required' => '验证码不能为空',
        ];
    }
}
