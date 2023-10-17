<?php

namespace JeckelLab\MauticWebhookParser\Parser;

use DateTimeImmutable;
use JeckelLab\MauticWebhookParser\ValueObject\Country;
use JeckelLab\MauticWebhookParser\ValueObject\Email;
use function JeckelLab\MauticWebhookParser\toNullableDateTime;

final readonly class FieldParser
{
    /**
     * @param array{alias: string, group: string, id: int, label: string, type: string, value: mixed} $fieldData
     * @return mixed
     */
    public function parseField(array $fieldData): mixed
    {
        $field = match($fieldData['type']) {
            'text' => $this->parseTextField($fieldData['value']),
            'number' => $this->parseNumberField($fieldData['value']),
            'datetime' => $this->parseDateTimeField($fieldData['value']),
            'boolean' => $this->parseBooleanField($fieldData['value']),
            'country' => $this->parseCountryField($fieldData['value']),
            'email' => $this->parseEmailField($fieldData['value']),
            default => null
        };
        return $field;
    }

    private function parseTextField(mixed $value): ?string
    {
        return is_string($value) ? $value : null;
    }

    private function parseNumberField(mixed $value): ?int
    {
        return is_int($value) ? $value : null;
    }

    private function parseDateTimeField(mixed $value): ?DateTimeImmutable
    {
        return toNullableDateTime($value);
    }

    private function parseBooleanField(mixed $value): ?bool
    {
        return is_bool($value) ? $value : null;
    }

    private function parseCountryField(mixed $value): ?Country
    {
        return is_string($value) ? new Country($value): null;
    }

    private function parseEmailField(mixed $value): ?Email
    {
        return is_string($value) ? new Email($value) : null;
    }
}
