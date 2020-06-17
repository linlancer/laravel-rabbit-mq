<?php
/**
 * Created by PhpStorm.
 * User: $_s
 * Date: 2020/6/17
 * Time: 9:40
 */

namespace LinLancer\Laravel\RabbitMQ\Tests;

use LinLancer\Laravel\RabbitMQ\ForRabbitMQ;
use LinLancer\Laravel\RabbitMQ\Tests\Job\TestJob;
use PHPUnit\Framework\TestCase;

class RabbitMQQueueTest extends TestCase
{
    public function getQueue()
    {
        $obj = new RabbitMQConnectorTest;
        return $obj->testConnect();
    }

    public function testGetCorrelationId()
    {

    }

    public function testPush()
    {
        $rabbitQueue = $this->getQueue();
        $job = new TestJob;
        $this->assertInstanceOf(ForRabbitMQ::class, $job);
        $job->setRouteKey('aaa');
        $job->setExchange('demo');
        $return = $rabbitQueue->push($job, 'this is a test message');
        var_dump($return);
    }

    public function testGetContext()
    {

    }

    public function testSize()
    {

    }

    public function testSetCorrelationId()
    {

    }

    public function testRelease()
    {

    }

    public function testPop()
    {

    }

    public function testPushRaw()
    {

    }

    public function testLater()
    {

    }
}
