<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 16/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser\Exception;

use InvalidArgumentException as InvalidArgumentExceptionCore;

class InvalidArgumentException extends InvalidArgumentExceptionCore implements MauticParserException {}
