<?php

namespace JeckelLab\MauticWebhookParser\Parser;

use DateTimeImmutable;
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
}
