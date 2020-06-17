<?php
/**
 * Created by PhpStorm.
 * User: $_s
 * Date: 2020/6/17
 * Time: 16:24
 */
namespace LinLancer\Laravel\RabbitMQ\AMQP;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

/**
 * Class MessageConfiguration
 * @package LinLancer\Laravel\RabbitMQ\AMQP
 * @method void setContentType($value)
 * @method void setContentEncoding($value)
 * @method void setApplicationHeaders($value)
 * @method void setDeliveryMode($value)
 * @method void setPriority($value)
 * @method void setCorrelationId($value)
 * @method void setReplyTo($value)
 * @method void setExpiration($value)
 * @method void setMessageId($value)
 * @method void setTimestamp($value)
 * @method void setType($value)
 * @method void setUserId($value)
 * @method void setAppId($value)
 * @method void setClusterId($value)
 * @method string getContentType($value)
 * @method string getContentEncoding($value)
 * @method array getApplicationHeaders($value)
 * @method int getDeliveryMode($value)
 * @method int getPriority($value)
 * @method string getCorrelationId($value)
 * @method string getReplyTo($value)
 * @method string getExpiration($value)
 * @method string getMessageId($value)
 * @method int getTimestamp($value)
 * @method string getType($value)
 * @method string getUserId($value)
 * @method string getAppId($value)
 * @method string getClusterId($value)
 */
class MessageConfiguration implements Arrayable
{
    private $config = [];

    /** @var array */
    protected static $properties = [
        'content_type',
        'content_encoding',
        'application_headers',
        'delivery_mode',
        'priority',
        'correlation_id',
        'reply_to',
        'expiration',
        'message_id',
        'timestamp',
        'type',
        'user_id',
        'app_id',
        'cluster_id',
    ];

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function __call($name, $arguments)
    {
        if (stripos($name, 'get') === 0) {
            return $this->__get(Str::snake(substr($name, 3)));
        } elseif (stripos($name, 'set') === 0) {
            $this->__set(Str::snake(substr($name, 3)), reset($arguments));
        }
    }

    public function __set($name, $value)
    {
        $paramName = Str::snake($name);
        if (in_array($paramName, self::$properties))
            $this->config[$paramName] = $value;
    }

    public function __get($name)
    {
        return $this->config[$name] ?? null;
    }
    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        if (!isset($this->config['content_type']))
            $this->config['content_type'] = 'application/json';
        if (!isset($this->config['content_encoding']))
            $this->config['content_encoding'] = 'utf-8';
        if (!isset($this->config['priority']))
            $this->config['priority'] = 9;
        if (!isset($this->config['message_id']))
            $this->config['message_id'] = Str::random(16);
        if (!isset($this->config['correlation_id']))
            $this->config['correlation_id'] = uniqid('R', true);
        return $this->config;
    }
}