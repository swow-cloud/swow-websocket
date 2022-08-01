<?php

declare(strict_types=1);
/**
 * This file is part of Swow-Chat.
 *
 * @link     https://xxx.com
 * @document https://xxx.wiki
 * @license  https://github.com/swow-cloud/swow-websocket/master/LICENSE
 */
namespace App\Service;

use App\Component\Hash;
use App\Constants\HttpCode;
use App\Model\User;
use Fig\Http\Message\StatusCodeInterface;
use Hyperf\HttpMessage\Exception\HttpException;
use Hyperf\Utils\Codec\Json;

class UserService
{
    public static function get(int $id): null|User
    {
        return User::query()->where('id', '=', $id)->first();
    }

    /*
     * @param string $email
     * @param string $username
     * @param string $password
     * @return bool
     */
    public static function register(string $mobile, string $username, string $password): bool
    {
        if (User::query()->where('mobile', '=', $mobile)->first()) {
            throw new HttpException(StatusCodeInterface::STATUS_OK, Json::encode(['message' => '账号已被注册!', 'code' => HttpCode::FAIL]));
        }
        $userModel = new User();
        $userModel->mobile = $mobile;
        $userModel->nickname = $username;
        $userModel->password = Hash::make($password);
        try {
            $result = $userModel->save();
        } catch (\Exception) {
            $result = false;
        }
        return $result;
    }

    public static function login(string $mobile, string $password): User
    {
        $userModel = User::query()->where('mobile', '=', $mobile)->first();
        if (! $userModel) {
            throw new HttpException(StatusCodeInterface::STATUS_OK, Json::encode(['message' => '手机号或者密码不正确!', 'code' => HttpCode::FAIL]));
        }
        $check = Hash::verify($password, $userModel->password);
        if ($check === false) {
            throw new HttpException(StatusCodeInterface::STATUS_OK, Json::encode(['message' => '手机号或者密码不正确!', 'code' => HttpCode::FAIL]));
        }
        return $userModel;
    }
}
