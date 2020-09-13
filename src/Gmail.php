<?php

namespace SzepeViktor\UniqueEmailAddress;

use SzepeViktor\UniqueEmailAddress\Rules\RemoveMixedCaseRule;
use SzepeViktor\UniqueEmailAddress\Rules\RemoveSeparatorRule;
use SzepeViktor\UniqueEmailAddress\Rules\RemoveTagRule;

final class Gmail extends EmailProvider implements EmailProviderInterface
{
    public function __construct()
    {
        $this->domains = ['gmail.com', 'googlemail.com'];
        $this->addRule(RemoveTagRule::class, ['+']);
        $this->addRule(RemoveSeparatorRule::class, ['.']);
        $this->addRule(RemoveMixedCaseRule::class, []);
    }
}
