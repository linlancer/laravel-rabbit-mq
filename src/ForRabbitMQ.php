<?php
/**
 * Created by PhpStorm.
 * User: $_s
 * Date: 2020/6/17
 * Time: 16:10
 */

namespace LinLancer\Laravel\RabbitMQ;


use PhpAmqpLib\Message\AMQPMessage;

interface ForRabbitMQ
{
    public function getMessage(): AMQPMessage;
}