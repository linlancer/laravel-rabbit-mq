<?php
/**
 * Created by PhpStorm.
 * User: $_s
 * Date: 2020/6/17
 * Time: 14:49
 */

namespace LinLancer\Laravel\RabbitMQ;


use Illuminate\Queue\Queue;
use Illuminate\Contracts\Queue\Queue as QueueInterface;
use LinLancer\Laravel\RabbitMQ\AMQP\MessageConfiguration;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQQueue extends Queue implements QueueInterface
{
    /**
     * @var AMQPChannel
     */
    private $channel;

    private $config;

    private $fromQueue;

    public function __construct(AMQPChannel $channel, array $config)
    {
        $this->channel = $channel;
        $this->config = $config;
    }

    /**
     * Get the size of the queue.
     *
     * @param  string|null $queue
     * @return int
     */
    public function size($queue = null): int
    {
        list(, $messageCount) = $this->channel->queue_declare($queue, false, true, false, false);
        return intval($messageCount);
    }

    /**
     * Push a new job onto the queue.
     *
     * @param  string|object $job
     * @param  mixed         $data
     * @param  string|null   $queue
     * @return mixed
     */
    public function push($job, $data = '', $queue = null)
    {
        if ($job instanceof ForRabbitMQ) {
            /**
             * @var AbstractRabbitMQ $job
             */
            $job->setBody($data);
            $message = $job->getMessage();
            $this->channel->basic_publish($message, $job->getExchange(), $job->getRouteKey());
            return $job->getConfiguration()->getMessageId();
        } else {
            return $this->pushRaw($this->createPayload($job, $queue, $data), $queue, []);
        }

    }

    /**
     * Push a raw payload onto the queue.
     *
     * @param  string      $payload
     * @param  string|null $queue
     * @param  array       $options
     * @return mixed
     */
    public function pushRaw($payload, $queue = null, array $options = [])
    {
        $config = new MessageConfiguration($options);
        $message = new AMQPMessage($payload, $config->toArray());

        $this->channel->basic_publish($message, '', $queue);
        return $config->getMessageId();
    }

    /**
     * Push a new job onto the queue after a delay.
     *
     * @param  \DateTimeInterface|\DateInterval|int $delay
     * @param  string|object                        $job
     * @param  mixed                                $data
     * @param  string|null                          $queue
     * @return mixed
     */
    public function later($delay, $job, $data = '', $queue = null)
    {
        // TODO: Implement later() method.
    }

    /**
     * Pop the next job off of the queue.
     *
     * @param  string $queue
     * @return \Illuminate\Contracts\Queue\Job|null
     */
    public function pop($queue = null)
    {
        $message = $this->channel->basic_get($queue);
        if (is_null($message))
            return $message;
        $this->fromQueue = $queue;
        return new RabbitMQJob($this, $this->channel, $message);
    }

    public function getFromQueue()
    {
        return $this->fromQueue;
    }

}