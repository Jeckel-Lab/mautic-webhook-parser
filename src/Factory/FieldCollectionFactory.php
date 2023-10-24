<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 19/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser\Factory;

use JeckelLab\MauticWebhookParser\Builder\FieldCollectionBuilder;
use JeckelLab\MauticWebhookParser\Model\FieldCollection;
use JeckelLab\MauticWebhookParser\Parser\FieldParser;

class FieldCollectionFactory
{
    private FieldCollectionBuilder $fieldCollectionBuilder;
    private FieldParser $fieldParser;

    public function __construct(
        ?FieldCollectionBuilder $fieldCollectionBuilder = null,
        ?FieldParser $fieldParser = null
    ) {
        $this->fieldCollectionBuilder = $fieldCollectionBuilder ?? new FieldCollectionBuilder();
        $this->fieldParser = $fieldParser ?? new FieldParser();
    }

    /**
     * @param array<string, mixed> $jsonData
     * @return FieldCollection
     */
    public function constructFromJson(array $jsonData): FieldCollection
    {
        $this->fieldCollectionBuilder->reset();
        /** @var array{alias: string, group: string, id: int, label: string, type: string, value: mixed} $fieldData */
        foreach ($jsonData as $fieldData) {
            $field = $this->fieldParser->parseFieldValue($fieldData);
            if (null === $field) {
                continue;
            }
            $this->fieldCollectionBuilder->withField($field);
        }
        return $this->fieldCollectionBuilder->build();
    }
}
