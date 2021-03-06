#!/usr/bin/php
<?php

use Pdp\Rules as PdpRules;
use SzepeViktor\UniqueEmailAddress\Providers\EmailProvider;
use SzepeViktor\UniqueEmailAddress\Providers\Gmail;
use SzepeViktor\UniqueEmailAddress\Rules\LowercaseRule;
use SzepeViktor\UniqueEmailAddress\Rules\RemoveSeparatorRule;
use SzepeViktor\UniqueEmailAddress\Rules\RemoveSubdomainRule;
use SzepeViktor\UniqueEmailAddress\Rules\RemoveTagRule;

require_once __DIR__ . '/vendor/autoload.php';

/* Example 1 */
$anymail = (new EmailProvider(['anymail.com', '*.globalmail.com']))
    ->addRule(RemoveSubdomainRule::class, [PdpRules::createFromPath(__DIR__ . '/data/public_suffix_list.dat')])
    ->addRule(RemoveTagRule::class, ['+'])
    ->addRule(RemoveSeparatorRule::class, ['.'])
    ->addRule(LowercaseRule::class);
$address = 'szepe.viktor+tag@sub.globalmail.com';
var_export([
    'INPUT' => $address,
    'isLocal' => $anymail->isLocal($address),
    'normalized' => $anymail->normalize($address),
    'equal' => $anymail->compare($address, 'szepeviktor@anymail.com'),
]);

/* Example 2 */
$gmail = new Gmail();
$address = 'szepe.VIKtor+tag+more@gmail.com';
var_export([
    'INPUT' => $address,
    'isLocal' => $gmail->isLocal($address),
    'normalized' => $gmail->normalize($address),
    'equal' => $gmail->compare($address, 'szepeviktor@gmail.com'),
]);
