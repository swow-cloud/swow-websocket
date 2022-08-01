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

use App\Kernel\Http\Response;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

abstract class Controller
{
    protected Response $response;

    protected RequestInterface $request;

    public function __construct(protected ContainerInterface $container)
    {
        try {
            $this->response = $container->get(Response::class);
            $this->request = $container->get(RequestInterface::class);
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
        }
    }
}
