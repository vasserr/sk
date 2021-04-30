<?php

namespace App\Tests\Feature;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EndpointControllerTest extends WebTestCase
{
    public function testForUnauthorizedUser(): void
    {
        $client = $this->createClient();
        $client->request('POST', 'api/endpoint/create/11');
        $this->assertResponseStatusCodeSame(401);
    }

    public function testForAuthorizedUser(): void
    {
        $client = static::createClient([], [
            'HTTP_X_AUTH_TOKEN' => 'apiTokenForTest',
            'HTTP_USER_AGENT' => 'MySuperBrowser/1.0',
            'CONTENT_TYPE' => 'application/json',
            'ACCEPT' => 'application/json',
        ]);

        $client->request('POST', 'api/endpoint/create/11', [
            'body' => [],
            'status' => 401,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJson(
            $client->getResponse()->getContent(),
            json_encode([
                'project' => '11',
            ])
        );
    }
}
