<?php

namespace App\Tests\Feature;

use App\Domain\ProjectManagement\Project;
use App\Domain\ProjectManagement\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EndpointControllerTest extends WebTestCase
{
    public function testCreateForUnauthorizedUser(): void
    {
        $client = $this->createClient();
        $client->request('POST', 'api/endpoint/projectForTest/new');
        $this->assertResponseStatusCodeSame(401);
    }

    public function testSuccessfulCreating(): void
    {
        $client = static::createClient([], [
            'HTTP_X_AUTH_TOKEN' => 'apiTokenForTest',
            'HTTP_USER_AGENT' => 'MySuperBrowser/1.0',
            'CONTENT_TYPE' => 'application/json',
            'ACCEPT' => 'application/json',
        ]);

        $client->request('POST', "api/endpoint/projectForTest/new", [
            'path' => 'fooPath',
            'responseBody' => json_encode(['success' => false]),
            'responseCode' => 401,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJson(
            $client->getResponse()->getContent(),
            json_encode([
                'url' => 'http://localhost/projectForTest/fooPath',
            ])
        );
    }
}
