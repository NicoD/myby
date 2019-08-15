<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RoleTest extends WebTestCase
{
    use BaseTrait;

    /** @var Client */
    protected $client;

    /** @var string|null */
    protected $token;

    public function testRetrieveRoleList(): void
    {
        $response = $this->client->request('GET', '/roles');
        $json = json_decode($response->getContent(), true);

        $this->assertResponseValid($response);

        $this->assertArrayHasKey('hydra:member', $json);
        $this->assertCount(2, $json['hydra:member']);
    }

    public function testRetrieveRole(): void
    {
        $response = $this->client->request('GET', '/roles/ROLE_USER');
        $json = json_decode($response->getContent(), true);

        $this->assertResponseValid($response);

        $this->assertSame('Role', $json['@type']);
        $this->assertSame('ROLE_USER', $json['name']);
    }

    /**
     * @throws \Exception
     */
    protected function setUp()
    {
        parent::setUp();

        $this->client = Client::create(static::createClient(), 'admin@example.com', 'test');
    }
}
