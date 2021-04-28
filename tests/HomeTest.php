<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeTest extends WebTestCase
{
    public function testSomething(): void
    {
        /** @var KernelBrowser $client */
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $this->assertResponseStatusCodeSame(200);
        $this->assertJson(
            $client->getResponse()->getContent(),
            json_encode([
                'message' => 'Welcome to your new controller!',
                'path' => 'src\/Controller\/HomeController.php',
            ])
        );
    }
}
