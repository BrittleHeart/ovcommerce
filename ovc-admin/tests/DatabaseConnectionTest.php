<?php

namespace App\Tests;

use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DatabaseConnectionTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();
    }

    #[Test]
    public function databaseConnectionIsSet(): void
    {
        $container = self::$kernel->getContainer();
        $doctrine = $container->get('doctrine')->getConnection();

        $doctrine->connect();
        $this->assertTrue($doctrine->isConnected(), 'Application does not have connection to database');
    }
}
