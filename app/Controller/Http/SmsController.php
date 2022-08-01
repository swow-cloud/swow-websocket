<?php

declare(strict_types=1);
/**
 * This file is part of Swow-Chat.
 *
 * @link     https://xxx.com
 * @document https://xxx.wiki
 * @license  https://github.com/swow-cloud/swow-websocket/master/LICENSE
 */
namespace App\Controller\Http;

use App\Controller\Controller;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;

#[\Hyperf\HttpServer\Annotation\Controller(prefix: '/sms')]
class SmsController extends Controller
{
    #[Inject]
    protected ValidatorFactoryInterface $validationFactory;

    /**
     * @throws \HttpException
     */
    #[PostMapping(path: 'send')]
    public function send()
    {
        $params = $this->request->all();
        $validator = $this->validationFactory->make(
            $params,
            [
                'channel' => 'required|in:login,register,forget_account,change_account',
                'mobile' => 'required|phone',
            ]
        );

        // TODO 验证提交的数据，并且发送短信
        if ($validator->fails()) {
            throw new \HttpException('');
        }
    }
}
