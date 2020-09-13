<?php

namespace SzepeViktor\UniqueEmailAddress\Rules;

use SzepeViktor\UniqueEmailAddress\EmailAddress;

interface RuleInterface
{
    public function apply(EmailAddress $address): EmailAddress;
}
