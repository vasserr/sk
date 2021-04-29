<?php

namespace App\Tests\Feature;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EndpointControllerTest extends WebTestCase
{
    public function testForUnauthorizedUser(): void
    {
        /** @var KernelBrowser $client */
        $client = $this->createClient();
        $client->request('POST', 'api/endpoint/create/11');
        $this->assertResponseStatusCodeSame(401);
    }
}
