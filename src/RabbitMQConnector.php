<?php
/**
 * Created by PhpStorm.
 * User: $_s
 * Date: 2020/6/17
 * Time: 14:48
 */

namespace LinLancer\Laravel\RabbitMQ;




use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Queue\Queue;
use Illuminate\Queue\Connectors\ConnectorInterface;
use Illuminate\Queue\Events\WorkerStopping;
use Illuminate\Support\Arr;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMQConnector implements ConnectorInterface
{
    /**
     * @var Dispatcher
     */
    private $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Establish a queue connection.
     *
     * @param  array $config
     * @return \Illuminate\Contracts\Queue\Queue
     */
    public function connect(array $config): Queue
    {

        $connection = new AMQPStreamConnection(
            Arr::get($config, 'host', '127.0.0.1'),
            Arr::get($config, 'port', '5672'),
            Arr::get($config, 'login', ''),
            Arr::get($config, 'password', ''),
            Arr::get($config, 'vhost', '/')
        );
        $channel = $connection->channel();
        $this->dispatcher->listen(WorkerStopping::class, function () use ($channel) {
            $channel->close();
        });
        return new RabbitMQQueue($channel, $config);
    }
}