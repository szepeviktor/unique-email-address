<?php

namespace SzepeViktor\UniqueEmailAddress;

interface EmailProviderInterface
{
    /**
     * @param string|EmailAddress $address
     */
    public function isLocal($address): bool;

    /**
     * @template AddressT
     * @param AddressT $address
     * @return AddressT
     */
    public function normalize($address);

    /**
     * @param string|EmailAddress $addressA
     * @param string|EmailAddress $addressB
     */
    public function compareAddresses($addressA, $addressB): bool;
}
