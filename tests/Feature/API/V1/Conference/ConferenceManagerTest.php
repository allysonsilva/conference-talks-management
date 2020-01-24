<?php

namespace Tests\Feature\API\V1\Conference;

use Generator;
use Tests\TestCase;

class ConferenceManagerTest extends TestCase
{
    /**
     * @dataProvider getConferenceTalksFixtures
     * @small
     */
    public function testConferenceTalks(array $data, int $statusCode, array $responseBody): void
    {
        // Actions
        $response = $this->postJson('/api/v1/conferences/talks', $data);

        $content = json_decode((string) $response->getContent(), true);

        // Assertions
        $response->assertStatus($statusCode);
        self::assertEquals($responseBody, $content);
    }

    public function getConferenceTalksFixtures(): Generator
    {
        yield from $this->getFixture('invalid_talks_fields_format');
        yield from $this->getFixture('valid_conference_default');
        yield from $this->getFixture('validate_another_conference');
    }

    private function getFixture(string $name): array
    {
        $fixtureArray = json_decode(file_get_contents(__DIR__ . "/fixtures/{$name}.json") ?: '', true);

        return [
            "fixtures/{$name}.json" => [
                'data' => $fixtureArray['request']['body'],
                'statusCode' => $fixtureArray['response']['statusCode'],
                'responseBody' => $fixtureArray['response']['body'],
            ],
        ];
    }
}
