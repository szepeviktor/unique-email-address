<?php

namespace SzepeViktor\UniqueEmailAddress;

/**
 * @template TRule of \SzepeViktor\UniqueEmailAddress\Rules\RuleInterface
 */
interface EmailProviderInterface
{
    /**
     * @param class-string<TRule> $class
     * @param list<mixed> $arguments
     * @return self
     */
    public function addRule(string $class, array $arguments = []);

    /**
     * @param string|\SzepeViktor\UniqueEmailAddress\EmailAddress $address
     */
    public function isLocal($address): bool;

    /**
     * @template TAddress
     * @param TAddress $address
     * @return TAddress
     */
    public function normalize($address);

    /**
     * @param string|\SzepeViktor\UniqueEmailAddress\EmailAddress $addressA
     * @param string|\SzepeViktor\UniqueEmailAddress\EmailAddress $addressB
     */
    public function compare($addressA, $addressB): bool;
}
