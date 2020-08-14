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

    /**
     * @var MessageConfiguration
     */
    protected $configuration;

    public function getMessage(): AMQPMessage
    {
        $body = new MessageBody($this->body);
        $this->configuration = new MessageConfiguration($this->options);
        return new AMQPMessage($body->toJson(), $this->configuration->toArray());
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

    public function setExpiredOn($timestamp)
    {
        $this->getConfiguration()->setExpiration(strval($timestamp));
    }
    /**
     * @return MessageConfiguration
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }
}