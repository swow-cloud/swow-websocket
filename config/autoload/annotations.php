<?php

declare(strict_types=1);
/**
 * This file is part of Swow-Chat.
 *
 * @link     https://xxx.com
 * @document https://xxx.wiki
 * @license  https://github.com/swow-cloud/swow-websocket/master/LICENSE
 */
return [
    'scan' => [
        'paths' => [
            BASE_PATH . '/app',
        ],
        'ignore_annotations' => [
            'mixin',
        ],
        'class_map' => [
            Hyperf\Utils\Coroutine::class => BASE_PATH . '/app/Kernel/ClassMap/Coroutine.php',
            Hyperf\Di\Resolver\ResolverDispatcher::class => BASE_PATH . '/app/Kernel/ClassMap/ResolverDispatcher.php',
        ],
    ],
];
