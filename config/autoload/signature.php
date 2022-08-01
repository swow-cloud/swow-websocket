<?php

declare(strict_types=1);
/**
 * This file is part of Swow-Chat.
 *
 * @link     https://xxx.com
 * @document https://xxx.wiki
 * @license  https://github.com/swow-cloud/swow-websocket/master/LICENSE
 */
return [
    // 签名密钥
    'signatureSecret' => env('SIGNATURE_SECRET', ''),
    // 签名key
    'signatureAppKey' => env('SIGNATURE_APP_KEY', ''),
    // 签名有效期限秒,默认30天
    'timestampValidity' => 3600 * 24 * 60 * 30,
];
