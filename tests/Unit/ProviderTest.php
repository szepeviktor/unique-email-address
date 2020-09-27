<?php

use SzepeViktor\UniqueEmailAddress\Providers\EmailProvider;
use SzepeViktor\UniqueEmailAddress\Rules\RemoveTagRule;

test('provider setup with one rule', function () {
    $provider = (new EmailProvider(['maildomain.test']))
        ->addRule(RemoveTagRule::class, ['-']);

    expect($provider)->toBeInstanceOf(EmailProvider::class);
    expect(serialize($provider))->toEqual(pack('H*','4f3a35343a22537a65706556696b746f725c556e69717565456d61696c416464726573735c50726f7669646572735c456d61696c50726f7669646572223a323a7b733a31303a22002a00646f6d61696e73223b613a313a7b693a303b733a31353a226d61696c646f6d61696e2e74657374223b7d733a383a22002a0072756c6573223b613a313a7b693a303b4f3a35303a22537a65706556696b746f725c556e69717565456d61696c416464726573735c52756c65735c52656d6f766554616752756c65223a313a7b733a31323a22002a00736570617261746f72223b733a313a222d223b7d7d7d'));
});

test('provider setup failure without domain', function () {
    $provider = new EmailProvider();
})->throws(ArgumentCountError::class);

test('provider setup failure with zero domains', function () {
    $provider = new EmailProvider([]);
})->throws(Exception::class);

it('calls all public API methods', function () {
    $anymail = (new EmailProvider(['anymail.test', 'yourmail.test']))
        ->addRule(RemoveTagRule::class, ['-']);
    $address = 'johndoe-tag@yourmail.test';

    expect($anymail->isLocal($address))->toBeTrue();
    expect($anymail->normalize($address))->toBe('johndoe@anymail.test');
    expect($anymail->compare($address, 'johndoe-label@anymail.test'))->toBeTrue();
});
