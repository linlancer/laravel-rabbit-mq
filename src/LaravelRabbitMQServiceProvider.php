<?php
/**
 * Created by PhpStorm.
 * User: $_s
 * Date: 2020/6/17
 * Time: 14:46
 */
namespace LinLancer\Laravel\RabbitMQ;


use Illuminate\Queue\QueueManager;
use Illuminate\Support\ServiceProvider;

class LaravelRabbitMQServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/rabbitmq.php', 'queue.connections.rabbitmq'
        );
    }


    public function boot(): void
    {
        /**
         * @var QueueManager $queueManager
         */
        $queueManager = $this->app['queue'];
        $queueManager->addConnector('rabbitmq', function () {
            return new RabbitMQConnector($this->app['events']);
        });
    }
}