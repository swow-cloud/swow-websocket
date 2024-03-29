<?php

declare(strict_types=1);
/**
 * This file is part of Swow-Chat.
 *
 * @link     https://xxx.com
 * @document https://xxx.wiki
 * @license  https://github.com/swow-cloud/swow-websocket/master/LICENSE
 */
use App\Exception\Handler\ValidationExceptionHandler;

return [
    'handler' => [
        'http' => [
            App\Exception\Handler\BusinessExceptionHandler::class,
            ValidationExceptionHandler::class,
        ],
    ],
];
