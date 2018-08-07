<?php
namespace phpunit\Wec\OAuth2;

use PHPUnit\Framework\TestCase;
use Wec\OAuth2\AccessService;

class AccessTest extends TestCase
{
    public function testAccess()
    {
        $this->assertEquals('todo', 'todo');
    }
}
