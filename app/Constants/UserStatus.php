<?php
declare(strict_types=1);

namespace App\Constants;
/**
 * @\App\Constants\UserStatus
 */
enum UserStatus: int
{
    case ONLINE = 1;
    case OUT = 0;
}
