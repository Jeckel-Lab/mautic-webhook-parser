<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 16/10/2023
 */

declare(strict_types=1);

namespace JeckelLab\MauticWebhookParser\Tests;

use JeckelLab\MauticWebhookParser\ContactParser;
use JeckelLab\MauticWebhookParser\Identity\ContactId;
use Monolog\Test\TestCase;

class ContactParserTest extends TestCase
{
    public function testItExtractContact(): void
    {
        /** @var string $payloadString */
        $payloadString = file_get_contents(__DIR__ . '/fixtures/contact-payload-extract.json');

        /** @var array<string, mixed> $payload */
        $payload = json_decode($payloadString, true);

        $parser = new ContactParser();
        $contact = $parser->parse($payload);
        self::assertSame(ContactId::from(52), $contact->id);
    }
}
