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
        $localPartAndDomain = explode(EmailAddress::AT, $address, 2);

        return [$localPartAndDomain[0], strtolower($localPartAndDomain[1])];
    }
}
