<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 19/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser\ValueObject\Field;

use DateTimeImmutable;

/**
 * @extends FieldAbstract<DateTimeImmutable>
 */
final readonly class DateTimeField extends FieldAbstract {}
