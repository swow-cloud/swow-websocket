<?php

declare(strict_types=1);
/**
 * This file is part of Swow-Chat.
 *
 * @link     https://xxx.com
 * @document https://xxx.wiki
 * @license  https://github.com/swow-cloud/swow-websocket/master/LICENSE
 */
namespace App\Component;

class Hash
{
    /**
     * Make a hash from the given plain data.
     */
    public static function make(string $plain): string
    {
        return password_hash($plain, PASSWORD_BCRYPT);
    }

    /**
     * Verify the given plain with the given hashed value.
     */
    public static function verify(string $plain, string $hashed): bool
    {
        return password_verify($plain, $hashed);
    }
}
