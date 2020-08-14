<?php
/**
 * Created by PhpStorm.
 * User: $_s
 * Date: 2020/6/17
 * Time: 14:49
 */

namespace LinLancer\Laravel\RabbitMQ;


use Illuminate\Database\DetectsDeadlocks;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Contracts\Queue\Job as JobInterface;
use Illuminate\Queue\Jobs\JobName;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQJob extends Job implements JobInterface
{
    use DetectsDeadlocks;

    protected $connection;

    protected $consumer;

    protected $message;

    public function __construct(
        RabbitMQQueue $connection,
        AMQPChannel $consumer,
        AMQPMessage $message
    ) {
        $this->connection = $connection;
        $this->consumer = $consumer;
        $this->message = $message;
        $this->queue = $connection->getFromQueue();
        $this->connectionName = $connection->getConnectionName();
    }

    public function fire()
    {
        $payload = $this->payload();

        [$class, $method] = JobName::parse($payload['job']);

        ($this->instance = $this->resolve($class))->{$method}($this, $payload['data']);

    }

    /**
     * Get the job identifier.
     *
     * @return string
     */
    public function getJobId()
    {
        // TODO: Implement getJobId() method.
    }

    /**
     * Get the raw body of the job.
     *
     * @return string
     */
    public function getRawBody()
    {
        // TODO: Implement getRawBody() method.
    }

    /**
     * Get the number of times the job has been attempted.
     *
     * @return int
     */
    public function attempts()
    {
        // TODO: Implement attempts() method.
    }
}