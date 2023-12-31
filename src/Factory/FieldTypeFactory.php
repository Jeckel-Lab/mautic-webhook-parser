<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 19/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser\Factory;

use JeckelLab\MauticWebhookParser\Identity\FieldTypeId;
use JeckelLab\MauticWebhookParser\ValueObject\FieldType;
use JeckelLab\MauticWebhookParser\ValueObject\FieldTypeGroup;
use JeckelLab\MauticWebhookParser\ValueObject\FieldTypeType;

class FieldTypeFactory
{
    /**
     * @var array<int, FieldType>
     */
    private array $fieldTypes = [];

    /**
     * @param array{alias: string, group: string, id: int, label: string, type: string} $fieldData
     * @return FieldType
     */
    public function constructFromJson(array $fieldData): FieldType
    {
        if (! isset($this->fieldTypes[$fieldData['id']])) {
            $this->fieldTypes[$fieldData['id']] = new FieldType(
                FieldTypeType::from($fieldData['type']),
                $fieldData['alias'],
                FieldTypeGroup::from($fieldData['group']),
                FieldTypeId::from($fieldData['id']),
                $fieldData['label']
            );
        }
        return $this->fieldTypes[$fieldData['id']];
    }
}
