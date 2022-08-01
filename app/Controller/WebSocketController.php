<?php

declare(strict_types=1);
/**
 * This file is part of Swow-Chat.
 *
 * @link     https://xxx.com
 * @document https://xxx.wiki
 * @license  https://github.com/swow-cloud/swow-websocket/master/LICENSE
 */
namespace App\Controller;

use Hyperf\Contract\OnCloseInterface;
use Hyperf\Contract\OnMessageInterface;
use Hyperf\Contract\OnOpenInterface;

class WebSocketController implements OnOpenInterface, OnMessageInterface, OnCloseInterface
{
    public function onClose($server, int $fd, int $reactorId): void
    {
        vd(3333);
    }

    public function onMessage($server, $frame): void
    {
        vd(2222);
        // TODO: Implement onMessage() method.
    }

    public function onOpen($server, $request): void
    {
        vd(1111);
    }
}
