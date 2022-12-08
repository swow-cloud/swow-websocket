<?php

declare(strict_types=1);
/**
 * This file is part of Swow-Chat.
 *
 * @link     https://xxx.com
 * @document https://xxx.wiki
 * @license  https://github.com/swow-cloud/swow-websocket/master/LICENSE
 */
namespace App\Exception\Handler;

use App\Exception\BusinessException;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\ExceptionHandler\Formatter\FormatterInterface;
use Psr\Http\Message\ResponseInterface;

class RPCExceptionHandler extends ExceptionHandler
{
    public function __construct(protected StdoutLoggerInterface $logger, protected FormatterInterface $formatter)
    {
    }

    public function handle(\Throwable $throwable, ResponseInterface $response): ResponseInterface
    {
        if ($throwable instanceof BusinessException) {
            $this->logger->warning($this->formatter->format($throwable));
        } else {
            $this->logger->error($this->formatter->format($throwable));
        }

        return $response;
    }

    public function isValid(\Throwable $throwable): bool
    {
        return true;
    }
}
