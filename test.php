#!/usr/bin/php
<?php

use SzepeViktor\UniqueEmailAddress\Rules\RemoveSeparatorRule;
use SzepeViktor\UniqueEmailAddress\Rules\RemoveTagRule;
use SzepeViktor\UniqueEmailAddress\EmailProvider;

require_once __DIR__ . '/vendor/autoload.php';

$gmail = (new EmailProvider(['gmail.com', 'googlemail.com']))
    ->addRule(RemoveTagRule::class, ['+'])
    ->addRule(RemoveSeparatorRule::class, ['.']);

$a1 = 'szepe.viktor+tag@googlemail.com';
var_dump([
    'INPUT' => $a1,
    'isLocal' => $gmail->isLocal($a1),
    'normalized' => $gmail->normalize($a1),
    'equal' => $gmail->compareAddresses($a1, 'szepeviktor@gmail.com')
]);
