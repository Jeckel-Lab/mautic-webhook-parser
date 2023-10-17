<?php

namespace JeckelLab\MauticWebhookParser\ValueObject;

final readonly class Email
{
    public function __construct(
        public string $email
    ) {}
}
