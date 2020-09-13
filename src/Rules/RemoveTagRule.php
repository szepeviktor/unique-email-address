<?php

namespace SzepeViktor\UniqueEmailAddress\Rules;

use SzepeViktor\UniqueEmailAddress\EmailAddress;
use function explode;

class RemoveTagRule implements RuleInterface
{
    /** @var string */
    protected $separator;

    /**
     * @param list<mixed> $arguments Tag separator in an array.
     */
    public function __construct(array $arguments)
    {
        if ($arguments === [] || mb_strlen($arguments[0]) !== 1) {
            throw new /*name*/ \Exception('Tag separator must be exactly 1 character long.');
        }

        $this->separator = $arguments[0];
    }

    public function apply(EmailAddress $emailAddress): EmailAddress
    {
        /** @var list<string> $localPartAndTag */
        $localPartAndTag = explode($this->separator, $emailAddress->getLocalPart(), 2);
        $emailAddress->setLocalPart($localPartAndTag[0]);

        return $emailAddress;
    }
}
