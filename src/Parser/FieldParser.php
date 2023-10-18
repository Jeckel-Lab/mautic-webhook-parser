<?php

namespace JeckelLab\MauticWebhookParser\Parser;

use DateTimeImmutable;
use JeckelLab\MauticWebhookParser\ValueObject\Email;
use LogicException;

use function JeckelLab\MauticWebhookParser\toNullableDateTime;

final readonly class FieldParser
{
    /**
     * @param array{alias: string, group: string, id: int, label: string, type: string, value: mixed} $fieldData
     * @return mixed
     */
    public function parseField(array $fieldData): mixed
    {
        return match($fieldData['type']) {
            'country', 'locale', 'lookup', 'region', 'select', 'tel', 'text', 'timezone', 'url' => $this->parseTextField($fieldData['value']),
            'number' => $this->parseNumberField($fieldData['value']),
            'datetime' => $this->parseDateTimeField($fieldData['value']),
            'boolean' => $this->parseBooleanField($fieldData['value']),
            'email' => $this->parseEmailField($fieldData['value']),
            'multiselect' => $this->parseMultiselectField($fieldData['value']),
            default => null
        };
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

    private function parseEmailField(mixed $value): ?Email
    {
        return is_string($value) ? new Email($value) : null;
    }

    /**
     * @return string[]|null
     */
    private function parseMultiselectField(mixed $value): ?array
    {
        return is_string($value) ? explode('|', $value) : null;
    }
}
