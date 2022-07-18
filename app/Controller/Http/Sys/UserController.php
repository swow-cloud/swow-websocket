<?php

declare(strict_types=1);
/**
 * This file is part of Swow-Chat.
 *
 * @link     https://xxx.com
 * @document https://xxx.wiki
 * @license  https://github.com/swow-cloud/websocket-server/master/LICENSE
 */
namespace App\Controller\Http\Sys;

use App\Constants\HttpCode;
use App\Controller\Controller;
use App\Kernel\Token\Jws;
use App\Request\LoginRequest;
use App\Request\RegisterRequest;
use App\Service\UserService;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;

#[\Hyperf\HttpServer\Annotation\Controller(prefix: '/sys/user', server: 'http')]
class UserController extends Controller
{
    protected Jws $jws;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->jws = $this->container->get(Jws::class);
        parent::__construct($container);
    }

    #[RequestMapping(path: 'register', methods: ['POST'])]
    public function register(RegisterRequest $request): ResponseInterface
    {
        $requestData = $request->validated();
        $register = UserService::register($requestData['mobile'], $requestData['username'], $requestData['password']);
        if ($register) {
            return $this->response->success('注册成功!');
        }
        return $this->response->fail(HttpCode::FAIL, '注册失败,请稍后再试!');
    }

    #[PostMapping(path: 'login')]
    public function login(LoginRequest $request): ResponseInterface
    {
        $requestData = $request->validated();
        $user = UserService::login($requestData['mobile'], $requestData['password']);
        $coreJws = $this->jws->create([
            'iat' => time(),
            'nbf' => time(),
            'exp' => time() + config('jws.exp'),
            'iss' => 'Swow Service',
            'aud' => 'Swow-Chat',
            'uid' => $user->id,
        ]);
        $jwt = $this->jws->serialize($coreJws);
        return $this->response->success([
            'token' => $jwt,
            'expire_in' => time() + config('jws.exp'),
        ]);
    }
}
