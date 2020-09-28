<?php

namespace SzepeViktor\UniqueEmailAddress\Providers;

use SzepeViktor\UniqueEmailAddress\Rules\LowercaseRule;
use SzepeViktor\UniqueEmailAddress\Rules\RemoveTagRule;

final class Hey extends EmailProvider implements EmailProviderInterface
{
    public function __construct()
    {
        $this->domains = ['hey.com'];
        $this->addRule(RemoveTagRule::class, ['+']);
        $this->addRule(LowercaseRule::class);
    }
}
