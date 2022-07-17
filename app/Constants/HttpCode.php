<?php
declare(strict_types=1);

namespace App\Constants;

enum HttpCode: int
{
    case SUCCESS = 0;
    case FAIL = -1;
}