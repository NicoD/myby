<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Client as TestClient;
use Symfony\Component\HttpFoundation\Response;

final class Client
{
    /** @var TestClient */
    private $client;

    /** @var string|null */
    private $token;

    /**
     * @param TestClient $client
     * @param string     $token
     */
    private function __construct(TestClient $client, string $token)
    {
        $this->client = $client;
        $this->token = $token;
    }

    /**
     * @param TestClient $client
     * @param string     $username
     * @param string     $password
     *
     * @return Client
     *
     * @throws \Exception
     */
    public static function create(TestClient $client, string $username, string $password): Client
    {
        $client->request(
            'POST',
            '/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode(['username' => $username, 'password' => $password]),
            );

        $response = $client->getResponse();

        if (null === ($jsonResponse = \json_decode($response->getContent(), true)) || !isset($jsonResponse['token'])) {
            throw new \Exception('unable to get token');
        }

        return new Client($client, $jsonResponse['token']);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param null   $content
     * @param array  $headers
     *
     * @return Response
     */
    public function request(string $method, string $uri, $content = null, array $headers = []): Response
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
}
