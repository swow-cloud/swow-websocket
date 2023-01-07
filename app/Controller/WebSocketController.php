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
use Hyperf\Utils\ApplicationContext;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Swow\Psr7\Message\ServerRequest;
use Swow\Psr7\Server\ServerConnection;
use SwowCloud\WebSocket\ClientManager;
use SwowCloud\WebSocket\Sender;

class WebSocketController implements OnOpenInterface, OnMessageInterface, OnCloseInterface
{
    protected ClientManager $connectionClientManager;

    public function __construct(ContainerInterface $container)
    {
        try {
            $this->connectionClientManager = $container->get(ClientManager::class);
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
        }
    }

    public function onClose($server, int $fd, int $reactorId): void
    {
        vd(33333);
    }

    public function onMessage($server, $frame): void
    {
    }

    /**
     * @param ServerConnection $server
     * @param ServerRequest $request
     */
    public function onOpen($server, $request): void
    {
        $sender = make(Sender::class, ['container' => ApplicationContext::getContainer()]);
        $sender->broadcastMessage('呵呵');
    }
}
