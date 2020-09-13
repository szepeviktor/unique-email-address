<?php

namespace SzepeViktor\UniqueEmailAddress;

class EmailAddress
{
    public const AT = '@';

    /** @var string */
    protected $localPart;

    /** @var string */
    protected $domain;

    public function __construct(string $address)
    {
        [$this->localPart, $this->domain] = Util::getParts($address);
    }

    public function getLocalPart(): string
    {
        return $this->localPart;
    }

    public function setLocalPart(string $localPart): self
    {
        //check
        $this->localPart = $localPart;

        return $this;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function setDomain(string $domain): self
    {
        //check
        $this->domain = $domain;

        return $this;
    }

    public function __toString(): string
    {
        return $this->localPart . self::AT . $this->domain;
    }
}
