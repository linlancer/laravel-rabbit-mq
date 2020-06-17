<?php
/**
 * Created by PhpStorm.
 * User: $_s
 * Date: 2020/6/17
 * Time: 16:25
 */
namespace LinLancer\Laravel\RabbitMQ\AMQP;

use Illuminate\Contracts\Support\Jsonable;

class MessageBody implements Jsonable
{
    private $body;

    public function __construct($body)
    {
        $this->body = $body;
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return is_array($this->body) ? json_encode($this->body) : $this->body;
    }
}