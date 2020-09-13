<?php

namespace SzepeViktor\UniqueEmailAddress\Rules;

use Pdp\Rules as PdpRules;
use SzepeViktor\UniqueEmailAddress\EmailAddress;
use function dirname;
use function str_replace;

class RemoveSubdomainRule implements RuleInterface
{
    /** @var \Pdp\Rules */
    protected $domainParser;

    /**
     * @param list<mixed> $arguments Domain parser instance in an array.
     */
    public function __construct(array $arguments)
    {
        if ($arguments === [] || ! $arguments[0] instanceof PdpRules) {
            throw new /*name*/ \Exception('This rules needs a domain parser.');
        }

        $this->domainParser = $arguments[0];
    }

    public function apply(EmailAddress $emailAddress): EmailAddress
    {
        $domain = $this->domainParser->getICANNDomain($emailAddress->getDomain());
        $registrableDomain = $domain->getRegistrableDomain();
        if ($registrableDomain === null) {
            throw new /*name*/ \Exception('This is not a registrable domain.');
        }

        $emailAddress->setDomain($registrableDomain);

        return $emailAddress;
    }
}
