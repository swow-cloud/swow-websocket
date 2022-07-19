<?php
declare(strict_types=1);

namespace App\Controller;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\RequestInterface;

#[\Hyperf\HttpServer\Annotation\Controller(prefix: '/sms')]
class SmsController extends Controller
{
    #[Inject]
    protected ValidatorFactoryInterface $validationFactory;

    #[PostMapping(path: 'send')]
    public function send()
    {
        $params = $this->request->all();
        $validator = $this->validationFactory->make(
            $params,
            [
                'channel' => "required|in:login,register,forget_account,change_account",
                'mobile' => "required|phone"
            ]
        );


        //TODO 验证提交的数据，并且发送短信
        if ($validator->fails()) {
            throw new \HttpException();
        }
    }
}