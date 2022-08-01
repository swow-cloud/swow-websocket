<?php

declare(strict_types=1);
/**
 * This file is part of Swow-Chat.
 *
 * @link     https://xxx.com
 * @document https://xxx.wiki
 * @license  https://github.com/swow-cloud/swow-websocket/master/LICENSE
 */
namespace App\Constants;

/**
 * @\App\Constants\UserStatus
 */
enum UserStatus: int
{
    case ONLINE = 1;
    case OUT = 0;
}
