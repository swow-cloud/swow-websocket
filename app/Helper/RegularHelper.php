<?php
declare(strict_types=1);

namespace App\Helper;

/**
 * @\App\Helper\RegularHelper
 */
class RegularHelper
{
    public const REG_PHONE = '/^1[3456789][0-9]{9}$/';

    public const REG_IDS = '/^\d+(\,\d+)*$/';

    public const REG_MAP = [
        'phone' => self::REG_PHONE,
        'ids' => self::REG_IDS,
    ];


    public static function getAliasRegular(string $regular): string
    {
        return self::REG_MAP[$regular];
    }

    public static function verify(string $regular, int|string $value): bool
    {
        return (bool)preg_match(self::getAliasRegular($regular), $value);
    }
}
