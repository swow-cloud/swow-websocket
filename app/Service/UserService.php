<?php
declare(strict_types=1);

namespace App\Service;

use App\Component\Hash;
use App\Constants\HttpCode;
use App\Model\User;
use Fig\Http\Message\StatusCodeInterface;
use Hyperf\Database\Model\Model;
use Hyperf\HttpMessage\Exception\HttpException;
use Hyperf\Utils\Codec\Json;

class UserService
{
    /**
     * @param int $id
     * @return User|null
     */
    public static function get(int $id): null|User
    {
        return User::query()->where('id', '=', $id)->first();
    }

    /***
     * @param string $email
     * @param string $username
     * @param string $password
     * @return bool
     */
    public static function register(string $email, string $username, string $password): bool
    {
        if (User::query()->where('email', '=', $email)->first()) {
            throw new HttpException(StatusCodeInterface::STATUS_OK, Json::encode(['message' => '账号已被注册!', 'code' => HttpCode::FAIL]));
        }
        $userModel = new User();
        $userModel->email = $email;
        $userModel->username = $username;
        $userModel->password = Hash::make($password);
        try {
            $result = $userModel->save();
        } catch (\Exception) {
            $result = false;
        }
        return $result;
    }

    /**
     * @param string $email
     * @param string $password
     * @return User
     */
    public static function login(string $email, string $password): User
    {
        $userModel = User::query()->where('email', '=', $email)->first();
        if (!$userModel) {
            throw new HttpException(StatusCodeInterface::STATUS_OK, Json::encode(['message' => '邮箱或者密码不正确!', 'code' => HttpCode::FAIL]));
        }
        $check = Hash::verify($password, $userModel->password);
        if ($check === false) {
            throw new HttpException(StatusCodeInterface::STATUS_OK, Json::encode(['message' => '邮箱或者密码不正确!', 'code' => HttpCode::FAIL]));
        }
        return $userModel;
    }

}