<?php

namespace JeckelLab\MauticWebhookParser\ValueObject;

use Stringable;

final readonly class Email implements Stringable
{
    public function __construct(
        public string $email
    ) {}

    public function __toString()
    {
        return $this->email;
    }
}
