<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Entity\User;
use App\Entity\UserProfile;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserProfileTest extends WebTestCase
{
    use BaseTrait;
    use RefreshDatabaseTrait;

    /** @var Client */
    private $client;

    /** @var string|null */
    private $token;

    public function testRetrieveUserProfileList(): void
    {
        $response = $this->client->request('GET', '/user_profiles');

        $this->assertResponseValid($response);

        $json = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('hydra:totalItems', $json);
        $this->assertEquals(11, $json['hydra:totalItems']);

        $this->assertArrayHasKey('hydra:member', $json);
        $this->assertCount(11, $json['hydra:member']);
    }

    public function testRetrieveUserProfile(): void
    {
        $user = static::$container->get('doctrine')->getRepository(User::class)->findOneBy(['email' => 'admin@example.com']);
        $response = $this->client->request(
            'GET',
            $this->findOneIriBy(UserProfile::class, ['user' => $user])
        );

        $this->assertResponseValid($response);
        $json = json_decode($response->getContent(), true);

        $this->assertSame('UserProfile', $json['@type']);
        $this->assertSame(2200, $json['baseDistanceMeters']);
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
