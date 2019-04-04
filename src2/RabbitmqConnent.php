<?php
/**
 * This file is part of the EasyRabbitmq.
 *
 * (c) 陈润璇 <chenrunxuan0506@163.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

require_once '../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitmqConnent
{
    /**
     * @var string
     */
    protected $host = '127.0.0.1';

    /**
     * @var int
     */
    protected $port = 5672;

    /**
     * @var string
     */
    protected $login = 'guest';

    /**
     * @var string
     */
    protected $password = 'guest';

    /**
     * @var string
     */
    protected $vhost = '/';

    /**
     * @var object 链接对象
     */
    protected $connection;

    /**
     * @var object 通道对象
     */
    protected $channel;

    /**
     * @var object 交换机对象
     */
    protected $exchange_obj;

    /**
     * @var 队列对象
     */
    protected $queue;

    /**
     * @var
     */
    protected $exchange_name;

    /**
     * @var
     */
    protected $queue_name;

    /**
     * 连接rabbitmq
     * crx 2019年4月3日17:50:48
     * RabbitmqConnent constructor.
     * @param $exchange_name 交换机名称
     * @param $queue_name 队列名称
     * @param $exchange_type 交换机类型
     * @param bool $passive
     * @param bool $durable
     * @param bool $exclusive
     * @param bool $auto_delete
     */
    public function __construct($exchange_name, $queue_name, $exchange_type, $passive=false, $durable=false, $exclusive=false, $auto_delete=false)
    {
        $this->exchange_name = $exchange_name;

        $this->queue_name = $queue_name;

        // 建立连接
        $this->connection = new AMQPStreamConnection(
            $this->host,
            $this->port,
            $this->login,
            $this->password
        );
        $this->channel = $this->connection->channel();

        $this->exchange_obj = $this->channel->exchange_declare($exchange_name, $exchange_type, $passive, $durable, $auto_delete);

        $this->queue = $this->channel->queue_declare($queue_name, $passive, $durable, $exclusive, $auto_delete);

        return $this;
    }

    /**
     * 发送信息
     * crx 2019年4月3日17:50:43
     * @param string $msg
     * @param $roution_key
     * @param array $propertive
     * @return bool
     */
    public function publish(string $msg, $roution_key, $propertive = ['delivery_mode'=>2])
    {
        $data = new AMQPMessage($msg,$propertive);
        return $this->channel->basic_publish($data, $this->exchange_name, $roution_key);
    }

    /**
     * 接收信息
     * crx 2019年4月4日10:48:48
     */
    public function consume()
    {
        $callback = function ($msg) {
            echo " [x] Received :", $msg->body, "\n";
        };
        $this->channel->basic_qos(null,1,null);
        $this->channel->basic_consume('hello','',false,true,false,false,$callback);
        while (count($this->channel->callbacks)) {
            $this->channel->wait();
        }
    }

    /**
     * RabbitmqProducer destruct.
     */
    public function __destruct()
    {
        $this->connection->close();
        $this->channel->close();
    }
}

