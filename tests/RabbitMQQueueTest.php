<?php
/**
 * Created by PhpStorm.
 * User: $_s
 * Date: 2020/6/17
 * Time: 9:40
 */

namespace LinLancer\Laravel\RabbitMQ\Tests;

use LinLancer\Laravel\RabbitMQ\ForRabbitMQ;
use LinLancer\Laravel\RabbitMQ\RabbitMQJob;
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
    public function testPushRaw()
    {
        $rabbitQueue = $this->getQueue();
        var_dump($rabbitQueue->pushRaw('this is a test message', 'bbb'));
    }

    public function testSize()
    {
        $rabbitQueue = $this->getQueue();
        $size = $rabbitQueue->size('bbb');
        var_dump($size);
    }


    public function testRelease()
    {

    }

    public function testPop()
    {
        $rabbitQueue = $this->getQueue();
        $job = $rabbitQueue->pop('bbb');
        $this->assertInstanceOf(RabbitMQJob::class, $job);
        var_dump($job->getRawBody());
    }

    public function testLater()
    {

    }
}
