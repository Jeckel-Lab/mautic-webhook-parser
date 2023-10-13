<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 13/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser\Exception;

use LogicException as LogicExceptionCore;

class LogicException extends LogicExceptionCore implements MauticParserException {}
