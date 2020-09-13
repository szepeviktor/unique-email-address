<?php

namespace SzepeViktor\UniqueEmailAddress;

use function str_replace;

class RemoveSeparatorRule implements RuleInterface
{
    /** @var string */
    protected $separator;

    /**
     * @param list<mixed> $arguments Tag separator in an array.
     */
    public function __construct(array $arguments)
    {
        if ($arguments === [] || mb_strlen($arguments[0]) !== 1) {
            throw new /*name*/ \Exception('Separator must be exactly 1 character long.');
        }

        $this->separator = $arguments[0];
    }

    public function apply(EmailAddress $emailAddress): EmailAddress
    {
        $emailAddress->setLocalPart(str_replace($this->separator, '', $emailAddress->getLocalPart()));

        return $emailAddress;
    }
}
