<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 13/10/2023
 */

declare(strict_types=1);


use JeckelLab\MauticWebhookParser\ContactParser;
use JeckelLab\MauticWebhookParser\PayloadParser;
use JeckelLab\MauticWebhookParser\ValueObject\MauticEventType;
use PHPUnit\Framework\TestCase;

class PayloadParserTest extends TestCase
{
    public function testItExtractCorrectEvents(): void
    {
        $parser = new PayloadParser(new ContactParser());
        /** @var string $payloadString */
        $payloadString = file_get_contents(__DIR__ . '/fixtures/contact-identified.json');

        /** @var array<string, array<array<string, mixed>>> $payload */
        $payload = json_decode($payloadString, true);
        $events = [];
        foreach($parser->parse($payload) as $event) {
            $events[] = $event;
        }
        self::assertCount(1, $events);
        self::assertEquals(MauticEventType::LEAD_POST_SAVE_NEW, $events[0]->eventType);
        self::assertEquals("2017-06-19T09:31:18+00:00", $events[0]->timestamp->format("c"));
    }
}
