<?php
declare(strict_types=1);

use Avast\XmlParser\util\RedisService;
use PHPUnit\Framework\TestCase;

final class RedisServiceTest extends TestCase {
    
    public function testExceptionIsThrownOnInitialize()
    {
        $this->expectException(Exception::class);
        new RedisService([]);
    }
}