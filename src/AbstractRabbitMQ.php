<?php
/**
 * Created by PhpStorm.
 * User: $_s
 * Date: 2020/6/17
 * Time: 16:38
 */

namespace LinLancer\Laravel\RabbitMQ;


use LinLancer\Laravel\RabbitMQ\AMQP\MessageBody;
use LinLancer\Laravel\RabbitMQ\AMQP\MessageConfiguration;
use PhpAmqpLib\Message\AMQPMessage;

abstract class AbstractRabbitMQ implements ForRabbitMQ
{
    protected $body;

    protected $routeKey = '';

    protected $exchange = '';

    protected $jobName = '';

    protected $options = [];

    public function getMessage(): AMQPMessage
    {
        $body = new MessageBody($this->body);
        $config = new MessageConfiguration($this->options);
        return new AMQPMessage($body->toJson(), $config->toArray());
    }

    public function setBody(string $body)
    {
        $this->body = $body;
    }

    public function getExchange()
    {
        return $this->exchange;
    }

    public function setExchange(string $value)
    {
        $this->exchange = $value;
    }
    public function getRouteKey()
    {
        return $this->routeKey;
    }

    public function setRouteKey(string $value)
    {
        $this->routeKey = $value;
    }
}