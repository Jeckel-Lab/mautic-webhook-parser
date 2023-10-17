<?php

namespace JeckelLab\MauticWebhookParser\ValueObject;

final readonly class Country
{
    public function __construct(
        public string $country
    ) {}
}
