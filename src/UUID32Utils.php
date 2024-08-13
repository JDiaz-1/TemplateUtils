<?php

namespace Agrocolor\Utils;

use Ramsey\Uuid\Uuid as RamseyUuid;
use InvalidArgumentException;

class UUID32Utils
{
    public static function generateString(): string
    {
        return str_replace("-", "", RamseyUuid::uuid4()->toString());
    }

    public static function toBinValue(string $value)
    {
        $converted = hex2bin($value);
        if ($converted === false) {
            throw new InvalidArgumentException("El valor de entrada $value no es hexadecimal al convertir a binario.");
        }
        return $converted;
    }

    public static function isAValidUuid(string $id): bool
    {
        if ((!ctype_xdigit($id)) || (strlen($id) != 32)) {
            return false;
        }
        return true;
    }


    public static function generateBinary16()
    {
        return hex2bin(UUID32Utils::generateString());
    }

    public static function hash(string $data) : string {
        return substr(hash('ripemd160', $data), 0, 32);
    }

}
