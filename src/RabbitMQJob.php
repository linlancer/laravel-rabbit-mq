<?php
/**
 * Created by PhpStorm.
 * User: $_s
 * Date: 2020/6/17
 * Time: 14:49
 */

namespace LinLancer\Laravel\RabbitMQ;


use Illuminate\Queue\Jobs\Job;
use Illuminate\Contracts\Queue\Job as JobInterface;

class RabbitMQJob extends Job implements JobInterface
{

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