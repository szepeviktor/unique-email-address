<?php

namespace SzepeViktor\UniqueEmailAddress;

use SzepeViktor\UniqueEmailAddress\Rules\RuleInterface;
use function array_reduce;
use function class_exists;
use function fnmatch;
use function in_array;
use function is_subclass_of;
use function substr;

/**
 * @template TRule of \SzepeViktor\UniqueEmailAddress\Rules\RuleInterface
 */
class EmailProvider implements EmailProviderInterface
{
    /** @var list<string> */
    protected $domains;

    /** @var list<TRule> */
    protected $rules;

    /**
     * @param list<string> $domains
     */
    public function __construct(array $domains)
    {
        $this->domains = $domains;
    }

    /**
     * @param class-string<TRule> $class
     * @param list<mixed> $arguments
     * @return self
     */
    public function addRule(string $class, array $arguments = [])
    {
        if (! class_exists($class)) {
            throw new \Exception('Rule does not exist.');
        }
        if (! is_subclass_of($class, RuleInterface::class)) {
            throw new \Exception('The given class is not a rule.');
        }

        $this->rules[] = new $class($arguments);

        return $this;
    }

    /**
     * @param string|\SzepeViktor\UniqueEmailAddress\EmailAddress $address
     */
    public function isLocal($address): bool
    {
        if (! $address instanceof EmailAddress) {
            $address = new EmailAddress($address);
        }

        return $this->domainMatch($address->getDomain());
    }

    /**
     * @template TAddress
     * @param TAddress $address
     * @return TAddress
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
                : $address->__toString();
        }

        return $isObject
            ? $this->applyRules($address)->setDomain($this->domains[0])
            : $this->applyRules($address)->setDomain($this->domains[0])->__toString();
    }

    /**
     * @param string|EmailAddress $addressA
     * @param string|EmailAddress $addressB
     */
    public function compare($addressA, $addressB): bool
    {
        if (! $addressA instanceof EmailAddress) {
            $addressA = new EmailAddress($addressA);
        }
        if (! $addressB instanceof EmailAddress) {
            $addressB = new EmailAddress($addressB);
        }

        return $this->normalize($addressA)->__toString() === $this->normalize($addressB)->__toString();
    }

    protected function domainMatch(string $domain): bool
    {
        foreach($this->domains as $providerDomain) {
            if (substr($providerDomain, 0, 2) === '*.' && fnmatch($providerDomain, $domain)) {
                return true;
            }
            if ($providerDomain === $domain) {
                return true;
            }
        }

        return false;
    }

    protected function applyRules(EmailAddress $emailAddress): EmailAddress
    {
        return array_reduce(
            $this->rules,
            static function (EmailAddress $emailAddress, RuleInterface $rule): EmailAddress {
                return $rule->apply($emailAddress);
            },
            $emailAddress
        );
    }
}
