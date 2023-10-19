<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 19/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser\ValueObject;

enum FieldTypeType: string
{
    case COUNTRY = 'country';
    case LOOKUP = 'lookup';
    case REGION = 'region';
    case SELECT = 'select';
    case TEL = 'tel';
    case TEXT = 'text';
    case TIMEZONE = 'timezone';
    case URL = 'url';
    case NUMBER = 'number';
    case DATETIME = 'datetime';
    case BOOLEAN = 'boolean';
    case EMAIL = 'email';
    case MULTISELECT = 'multiselect';
    case LOCALE = 'locale';
}
