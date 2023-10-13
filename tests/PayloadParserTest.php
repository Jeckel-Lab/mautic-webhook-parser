<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 13/10/2023
 */

declare(strict_types=1);


use JeckelLab\MauticWebhookParser\PayloadParser;
use JeckelLab\MauticWebhookParser\ValueObject\MauticEvent;
use PHPUnit\Framework\TestCase;

class PayloadParserTest extends TestCase
{
    public function testItExtractCorrectEvents(): void
    {
        $parser = new PayloadParser();
        $payload = [
            "mautic.lead_post_save_new" => [
                "data" => [
                    "id" => 123,
                ],
            ],
        ];
        $events = [];
        foreach($parser->parse($payload) as $event) {
            $events[] = $event;
        }
        self::assertCount(1, $events);
        self::assertEquals(MauticEvent::LEAD_POST_SAVE_NEW, $events[0]['event']);
    }
}
