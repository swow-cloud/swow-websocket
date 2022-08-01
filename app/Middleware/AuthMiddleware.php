<?php

declare(strict_types=1);
/**
 * This file is part of Swow-Chat.
 *
 * @link     https://xxx.com
 * @document https://xxx.wiki
 * @license  https://github.com/swow-cloud/swow-websocket/master/LICENSE
 */
namespace App\Middleware;

use App\Exception\TokenValidException;
use App\Kernel\Http\Response;
use App\Kernel\Token\Jws;
use App\Service\UserService;
use Hyperf\Context\Context;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\Codec\Json;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthMiddleware implements MiddlewareInterface
{
    protected string $prefix = 'Bearer';

    protected Response $response;

    protected Jws $jws;

    public function __construct(StdoutLoggerInterface $stdoutLogger, Response $response, Jws $jws)
    {
        $this->response = $response;
        $this->jws = $jws;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $token = $request->getHeader('Authorization')[0] ?? '';
            if (empty($token)) {
                $token = $this->prefix . ' ' . ($request->getQueryParams()['token'] ?? '');
            }
            $token = ucfirst($token);
            $arr = explode($this->prefix . ' ', $token);
            $token = $arr[1] ?? '';

            if (($token !== '') && $this->checkToken($token)) {
                $request = $this->setRequestContext($token);
                return $handler->handle($request);
            }
            return $this->response->response()->withHeader('Server', 'Swow-Chat')->withStatus(403)->withBody(new SwooleStream('无权限访问!'));
        } catch (TokenValidException) {
            return $this->response->response()->withHeader('Server', 'Swow-Chat')->withStatus(401)->withBody(new SwooleStream('Token authentication does not pass'));
        } catch (\Throwable $exception) {
            if (env('APP_ENV') === 'dev') {
                return $this->response->response()->withHeader('Server', 'Swow-Chat')->withStatus(500)->withBody(new SwooleStream(Json::encode([
                    'msg' => $exception->getMessage(),
                    'trace' => $exception->getTrace(),
                    'line' => $exception->getLine(),
                    'file' => $exception->getFile(),
                ])));
            }
            return $this->response->response()->withHeader('Server', 'Swow-Chat')->withStatus(500)->withBody(new SwooleStream('服务端错误!'));
        }
    }

    protected function checkToken(string $token): bool
    {
        return $this->jws->verify($token);
    }

    protected function setRequestContext(string $token): ServerRequestInterface
    {
        $uid = (int) ($this->jws->unserialize($token)->getPayload()['uid'] ?? 0);
        $user = UserService::get($uid);
        $request = Context::get(ServerRequestInterface::class);
        $request = $request->withAttribute('user', $user);
        Context::set(ServerRequestInterface::class, $request);
        return $request;
    }
}
