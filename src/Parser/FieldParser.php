<?php

namespace JeckelLab\MauticWebhookParser\Parser;

use JeckelLab\MauticWebhookParser\Factory\FieldTypeFactory;
use JeckelLab\MauticWebhookParser\ValueObject\Email;
use JeckelLab\MauticWebhookParser\ValueObject\Field\ArrayField;
use JeckelLab\MauticWebhookParser\ValueObject\Field\BoolField;
use JeckelLab\MauticWebhookParser\ValueObject\Field\DateTimeField;
use JeckelLab\MauticWebhookParser\ValueObject\Field\EmailField;
use JeckelLab\MauticWebhookParser\ValueObject\Field\Field;
use JeckelLab\MauticWebhookParser\ValueObject\Field\IntField;
use JeckelLab\MauticWebhookParser\ValueObject\Field\LocaleField;
use JeckelLab\MauticWebhookParser\ValueObject\Field\StringField;
use JeckelLab\MauticWebhookParser\ValueObject\FieldType;
use JeckelLab\MauticWebhookParser\ValueObject\Locale;

use function JeckelLab\MauticWebhookParser\toNullableDateTime;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
final readonly class FieldParser
{
    private FieldTypeFactory $fieldTypeFactory;

    public function __construct(
        ?FieldTypeFactory $fieldTypeFactory = null
    ) {
        $this->fieldTypeFactory = $fieldTypeFactory ?? new FieldTypeFactory();
    }

    /**
     * @param array{alias: string, group: string, id: int, label: string, type: string, value: mixed} $fieldData
     * @return Field|null
     */
    public function parseFieldValue(array $fieldData): ?Field
    {
        $fieldType = $this->fieldTypeFactory->constructFromJson($fieldData);
        return match($fieldData['type']) {
            'country', 'lookup', 'region', 'select', 'tel', 'text', 'timezone', 'url' => $this->parseTextField($fieldData['value'], $fieldType),
            'number' => $this->parseNumberField($fieldData['value'], $fieldType),
            'datetime' => $this->parseDateTimeField($fieldData['value'], $fieldType),
            'boolean' => $this->parseBooleanField($fieldData['value'], $fieldType),
            'email' => $this->parseEmailField($fieldData['value'], $fieldType),
            'multiselect' => $this->parseMultiselectField($fieldData['value'], $fieldType),
            'locale' => $this->parseLocaleField($fieldData['value'], $fieldType),
            default => null
        };
    }

    private function parseTextField(mixed $value, FieldType $fieldType): ?StringField
    {
        return is_string($value) ? new StringField($fieldType, $value) : null;
    }

    private function parseNumberField(mixed $value, FieldType $fieldType): ?IntField
    {
        return is_int($value) ? new IntField($fieldType, $value) : null;
    }

    private function parseDateTimeField(mixed $value, FieldType $fieldType): ?DateTimeField
    {
        $dateTime = toNullableDateTime($value);
        return $dateTime !== null ? new DateTimeField($fieldType, $dateTime) : null;
    }

    private function parseBooleanField(mixed $value, FieldType $fieldType): ?BoolField
    {
        return is_bool($value) ? new BoolField($fieldType, $value) : null;
    }

    private function parseEmailField(mixed $value, FieldType $fieldType): ?EmailField
    {
        return is_string($value) ? new EmailField($fieldType, new Email($value)) : null;
    }

    private function parseMultiselectField(mixed $value, FieldType $fieldType): ?ArrayField
    {
        return is_string($value) ? new ArrayField($fieldType, explode('|', $value)) : null;
    }

    private function parseLocaleField(mixed $value, FieldType $fieldType): ?LocaleField
    {
        return is_string($value) ? new LocaleField($fieldType, new Locale($value)) : null;
    }
}
