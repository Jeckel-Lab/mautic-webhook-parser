<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 19/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser\ValueObject;

enum FieldTypeGroup: string
{
    case CORE = 'core';
    case PERSONAL = 'personal';
    case PROFESSIONAL = 'professional';
    case SOCIAL = 'social';
}
