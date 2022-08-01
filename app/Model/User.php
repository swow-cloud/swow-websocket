<?php

declare(strict_types=1);
/**
 * This file is part of Swow-Chat.
 *
 * @link     https://xxx.com
 * @document https://xxx.wiki
 * @license  https://github.com/swow-cloud/swow-websocket/master/LICENSE
 */
namespace App\Model;

/**
 * @property int $id
 * @property string $mobile
 * @property string $nickname
 * @property string $avatar
 * @property int $gender
 * @property string $password
 * @property string $motto
 * @property string $email
 * @property int $is_robot
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class User extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'user';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'mobile', 'nickname', 'avatar', 'gender', 'password', 'motto', 'email', 'is_robot', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'gender' => 'integer', 'is_robot' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
