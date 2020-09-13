<?php

namespace SzepeViktor\UniqueEmailAddress;

interface UniqueEmailAddressInterface
{
    /**
     * @param string|EmailAddress $address
     */
    public function isLocal($address): bool;

    /**
     * @template AddressT1
     * @param AddressT1 $address
     * @return AddressT1
     */
    public function normalize($address);

    /**
     * @template AddressT2
     * @param AddressT2 $addressA
     * @param AddressT2 $addressB
     */
    public function compareAddresses($addressA, $addressB): bool;
}
