<?php

namespace SzepeViktor\UniqueEmailAddress;

use function explode;
use function strtolower;

class Util
{
    /**
     * @return array{string, string} Local part and domain.
     */
    public static function getParts(string $address): array
    {
        $parts = explode(EmailAddress::AT, $address, 2);

        return [$parts[0], strtolower($parts[1])];
    }
}
