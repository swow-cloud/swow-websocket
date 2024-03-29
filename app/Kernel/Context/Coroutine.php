<?php

declare(strict_types=1);
/**
 * This file is part of Swow-Chat.
 *
 * @link     https://xxx.com
 * @document https://xxx.wiki
 * @license  https://github.com/swow-cloud/swow-websocket/master/LICENSE
 */
namespace App\Kernel\Context;

use App\Kernel\Log\AppendRequestIdProcessor;
use Hyperf\Context\Context;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Engine\Coroutine as Co;
use Hyperf\Utils;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class Coroutine
{
    protected LoggerInterface $logger;

    public function __construct(protected ContainerInterface $container)
    {
        $this->logger = $container->get(StdoutLoggerInterface::class);
    }

    /**
     * @return int Returns the coroutine ID of the coroutine just created.
     *             Returns -1 when coroutine create failed.
     */
    public function create(callable $callable): int
    {
        $id = Utils\Coroutine::id();
        $coroutine = Co::create(function () use ($callable, $id) {
            try {
                // Shouldn't copy all contexts to avoid socket already been bound to another coroutine.
                Context::copy($id, [
                    AppendRequestIdProcessor::REQUEST_ID,
                    ServerRequestInterface::class,
                ]);
                call($callable);
            } catch (\Throwable $throwable) {
                $this->logger->warning((string) $throwable);
            }
        });

        try {
            return $coroutine->getId();
        } catch (\Throwable $throwable) {
            $this->logger->warning((string) $throwable);
            return -1;
        }
    }
}
