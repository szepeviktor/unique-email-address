#!/usr/bin/php
<?php

use SzepeViktor\UniqueEmailAddress\Rules\RemoveSeparatorRule;
use SzepeViktor\UniqueEmailAddress\Rules\RemoveTagRule;
use SzepeViktor\UniqueEmailAddress\EmailProvider;
use SzepeViktor\UniqueEmailAddress\Gmail;

require_once __DIR__ . '/vendor/autoload.php';

$anymail = (new EmailProvider(['gmail.com', 'googlemail.com']))
    ->addRule(RemoveTagRule::class, ['+'])
    ->addRule(RemoveSeparatorRule::class, ['.']);
$address = 'szepe.viktor+tag@googlemail.com';
var_export([
    'INPUT' => $address,
    'isLocal' => $anymail->isLocal($address),
    'normalized' => $anymail->normalize($address),
    'equal' => $anymail->compare($address, 'szepeviktor@gmail.com')
]);

$gmail = new Gmail();
$address = 'szepe.viktor+tag+more@gmail.com';
var_export([
    'INPUT' => $address,
    'isLocal' => $gmail->isLocal($address),
    'normalized' => $gmail->normalize($address),
    'equal' => $gmail->compare($address, 'szepeviktor@gmail.com')
]);
