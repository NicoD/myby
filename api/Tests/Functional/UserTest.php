<?php

declare(strict_types=1);

namespace App\Tests;

use App\Entity\User;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ApiTest extends WebTestCase
{
    use RefreshDatabaseTrait;

    /** @var Client */
    protected $client;

    /** @var string|null */
    protected $token;

    public function testRetrieveUserList(): void
    {
        $response = $this->request('GET', '/users');
        $json = json_decode($response->getContent(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/ld+json; charset=utf-8', $response->headers->get('Content-Type'));

        $this->assertArrayHasKey('hydra:totalItems', $json);
        $this->assertEquals(11, $json['hydra:totalItems']);

        $this->assertArrayHasKey('hydra:member', $json);
        $this->assertCount(11, $json['hydra:member']);
    }

    public function testRetrieveUser(): void
    {
        $response = $this->request('GET', $this->findOneIriBy(User::class, ['email' => 'admin@example.com']));
        $json = json_decode($response->getContent(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/ld+json; charset=utf-8', $response->headers->get('Content-Type'));

        $this->assertSame('User', $json['@type']);
        $this->assertInternalType('integer', $json['id']);
        $this->assertSame('admin@example.com', $json['email']);
        $this->assertSame(['ROLE_USER', 'ROLE_ADMIN'], $json['roles']);
    }

    protected function setUp()
    {
        parent::setUp();

        $this->client = static::createClient();

        $this->client->request(
            'POST',
            '/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode(['username' => 'admin@example.com', 'password' => 'test']),
        );

        $response = $this->client->getResponse();

        if (null === ($jsonResponse = \json_decode($response->getContent(), true))) {
            return;
        }
        $this->token = $jsonResponse['token'] ?? null;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param null   $content
     * @param array  $headers
     *
     * @return Response
     */
    protected function request(string $method, string $uri, $content = null, array $headers = []): Response
    {
        $server = ['CONTENT_TYPE' => 'application/ld+json', 'HTTP_ACCEPT' => 'application/ld+json'];
        foreach ($headers as $key => $value) {
            if ('content-type' === strtolower($key)) {
                $server['CONTENT_TYPE'] = $value;

                continue;
            }

            $server['HTTP_'.strtoupper(str_replace('-', '_', $key))] = $value;
        }
        $server['HTTP_AUTHORIZATION'] = sprintf('Bearer %s', $this->token);

        if (is_array($content) && false !== preg_match('#^application/(?:.+\+)?json$#', $server['CONTENT_TYPE'])) {
            $content = json_encode($content);
        }

        $this->client->request($method, $uri, [], [], $server, $content);

        return $this->client->getResponse();
    }

    /**
     * @param string $resourceClass
     * @param array  $criteria
     *
     * @return string
     */
    protected function findOneIriBy(string $resourceClass, array $criteria): string
    {
        $resource = static::$container->get('doctrine')->getRepository($resourceClass)->findOneBy($criteria);

        return static::$container->get('api_platform.iri_converter')->getIriFromitem($resource);
    }
}
