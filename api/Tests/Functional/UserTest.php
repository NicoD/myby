<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Entity\User;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase
{
    use BaseTrait;
    use RefreshDatabaseTrait;

    /** @var Client */
    private $client;

    /** @var string|null */
    private $token;

    public function testRetrieveUserList(): void
    {
        $response = $this->client->request('GET', '/users');
        $json = json_decode($response->getContent(), true);

        $this->assertResponseValid($response);

        $this->assertArrayHasKey('hydra:totalItems', $json);
        $this->assertEquals(11, $json['hydra:totalItems']);

        $this->assertArrayHasKey('hydra:member', $json);
        $this->assertCount(11, $json['hydra:member']);
    }

    public function testRetrieveUser(): void
    {
        $response = $this->client->request('GET', $this->findOneIriBy(User::class, ['email' => 'admin@example.com']));
        $json = json_decode($response->getContent(), true);

        $this->assertResponseValid($response);

        $this->assertSame('User', $json['@type']);
        $this->assertInternalType('integer', $json['id']);
        $this->assertSame('admin@example.com', $json['email']);
        $this->assertSame(['ROLE_USER', 'ROLE_ADMIN'], $json['roles']);
    }

    /**
     * @throws \Exception
     */
    protected function setUp()
    {
        parent::setUp();

        $this->client = Client::create(static::createClient(), 'admin@example.com', 'test');
    }

    /**
     * @param string $resourceClass
     * @param array  $criteria
     *
     * @return string
     */
    private function findOneIriBy(string $resourceClass, array $criteria): string
    {
        $resource = static::$container->get('doctrine')->getRepository($resourceClass)->findOneBy($criteria);

        return static::$container->get('api_platform.iri_converter')->getIriFromitem($resource);
    }
}
