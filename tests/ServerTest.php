<?php
use Fordnox\JsonApiServer;

class GeneralTest extends \PHPUnit_Framework_TestCase
{
    public function testServer()
    {
        $server = new JsonApiServer;
        $server->register('test', function($params){ return $params; });
        $r = $server->handle(true);
        $this->assertInternalType('array', $r);
    }
}