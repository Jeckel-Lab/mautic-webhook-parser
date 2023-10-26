<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 19/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser\ValueObject\Field;

use JeckelLab\MauticWebhookParser\ValueObject\Email;

/**
 * @extends FieldAbstract<Email>
 */
final readonly class EmailField extends FieldAbstract {}
