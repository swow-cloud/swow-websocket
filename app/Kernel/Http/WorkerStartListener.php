<?php

declare(strict_types=1);
/**
 * This file is part of Swow-Chat.
 *
 * @link     https://xxx.com
 * @document https://xxx.wiki
 * @license  https://github.com/swow-cloud/swow-websocket/master/LICENSE
 */
namespace App\Kernel\Http;

use Hyperf\Framework\Logger\StdoutLogger;
use Hyperf\Server\Listener\AfterWorkerStartListener;
use Psr\Container\ContainerInterface;

class WorkerStartListener extends AfterWorkerStartListener
{
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container->get(StdoutLogger::class));
    }
}
