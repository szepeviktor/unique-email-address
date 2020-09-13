<?php

namespace SzepeViktor\UniqueEmailAddress;

interface RuleInterface
{
    public function apply(EmailAddress $address): EmailAddress;
}
