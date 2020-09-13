<?php

namespace SzepeViktor\UniqueEmailAddress\Rules;

use SzepeViktor\UniqueEmailAddress\EmailAddress;
use function mb_strtolower;

class LowercaseRule implements RuleInterface
{
    /**
     * @param list<mixed> $arguments
     */
    public function __construct(array $arguments = [])
    {
        if ($arguments !== []) {
            throw new /*name*/ \Exception('This rule accepts no arguments.');
        }
    }

    public function apply(EmailAddress $emailAddress): EmailAddress
    {
        $emailAddress->setLocalPart(mb_strtolower($emailAddress->getLocalPart()));

        return $emailAddress;
    }
}
