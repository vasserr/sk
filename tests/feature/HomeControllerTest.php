<?php

namespace App\Tests\Feature;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testHomePageRunsCorrectly(): void
    {
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
