<?php
declare(strict_types=1);

namespace App\Controller\Http;

use App\Controller\Controller;
use App\Kernel\Token\Jws;
use Hyperf\HttpServer\Annotation\GetMapping;

#[\Hyperf\HttpServer\Annotation\Controller(prefix: 'test', server: 'http')]
class TestController extends Controller
{
    #[GetMapping(path: 'jws')]
    /**
     * @return void
     */
    public function jws()
    {
        $jws = make(Jws::class);

        $coreJws = $jws->create([
            'iat' => time(),
            'nbf' => time(),
            'exp' => time() + 3600,
            'iss' => 'My service',
            'aud' => 'Your application',
        ]);
        vd($jws->serialize($coreJws));
        $jwt = 'eyJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2NTgwMjc1NzYsIm5iZiI6MTY1ODAyNzU3NiwiZXhwIjoxNjU4MDMxMTc2LCJpc3MiOiJNeSBzZXJ2aWNlIiwiYXVkIjoiWW91ciBhcHBsaWNhdGlvbiJ9.SYMoay6n8JzxopRyazE6p8AJs176kHJtrRDzzmrhvbg';

        vd($jws->unserialize($jwt));
        vd($jws->verify($jwt));

    }
}