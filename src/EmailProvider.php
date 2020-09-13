<?php

namespace SzepeViktor\UniqueEmailAddress;

use function array_reduce;
use function class_exists;
use function in_array;

/**
 * @template RuleT of RuleInterface
 */
class EmailProvider implements EmailProviderInterface
{
    /** @var list<string> */
    protected $domains;

    /** @var list<RuleT> */
    protected $rules;

    /**
     * @param list<string> $domains
     */
    public function __construct(array $domains)
    {
        $this->domains = $domains;
    }

    /**
     * @param class-string<RuleT> $class
     * @param list<mixed> $arguments
     */
    public function addRule(string $class, array $arguments = []): self
    {
        if (! class_exists($class)) {
            throw new \Exception('Rule does not exist.');
        }

        $this->rules[] = new $class($arguments);

        return $this;
    }

    /**
     * @param string|EmailAddress $address
     */
    public function isLocal($address): bool
    {
        if (! $address instanceof EmailAddress) {
            $address = new EmailAddress($address);
        }

        return in_array($address->getDomain(), $this->domains, true);
    }

    /**
     * @template AddressT
     * @param AddressT $address
     * @return AddressT
     */
    public function normalize($address)
    {
        $isObject = $address instanceof EmailAddress;
        if (! $isObject) {
            $address = new EmailAddress($address);
        }

        if (! $this->isLocal($address)) {
            return $isObject
                ? $address
                : $address->toString();
        }

        return $isObject
            ? $this->applyRules($address)->setDomain($this->domains[0])
            : $this->applyRules($address)->setDomain($this->domains[0])->toString();
    }

    /**
     * @param string|EmailAddress $addressA
     * @param string|EmailAddress $addressB
     */
    public function compareAddresses($addressA, $addressB): bool
    {
        if (! $addressA instanceof EmailAddress) {
            $addressA = new EmailAddress($addressA);
        }
        if (! $addressB instanceof EmailAddress) {
            $addressB = new EmailAddress($addressB);
        }

        return $this->normalize($addressA)->toString() === $this->normalize($addressB)->toString();
    }

    protected function applyRules(EmailAddress $emailAddress): EmailAddress
    {
        return array_reduce(
            $this->rules,
            /**
             * @param RuleT $rule
             */
            static function (EmailAddress $emailAddress, RuleInterface $rule): EmailAddress {
                return $rule->apply($emailAddress);
            },
            $emailAddress
        );
    }
}
