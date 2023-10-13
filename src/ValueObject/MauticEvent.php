<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 13/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser\ValueObject;

enum MauticEvent: string
{
    case LEAD_POST_SAVE_NEW = "mautic.lead_post_save_new";
}
