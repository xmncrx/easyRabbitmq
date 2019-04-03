<?php
/**
 * This file is part of the EasyRabbitmq.
 *
 * (c) 陈润璇 <chenrunxuan0506@163.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace easyRabbitmq;
require_once '../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

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
     * @var object
     */
    protected $connection;

    /**
     * @var object
     */
    protected $channel;

    /**
     * @var object 交换机对象
     */
    protected $exchange_obj;

    /**
     * @var string
     */
    protected $set_name;

    /**
     * 连接rabbitmq
     * crx 2019年4月3日17:50:48
     * RabbitmqConnent constructor.
     */
    public function __construct()
    {
        // 建立连接
        $this->connection = new AMQPStreamConnection(
            $this->host,
            $this->port,
            $this->login,
            $this->password
        );
        $this->channel = $this->connection->channel();

        $this->exchange_obj = new AMQPExchange($this->channel);
    }

    /**
     * 设置交换机名称
     * crx 2019年4月3日17:50:39
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->set_name = $this->exchange_obj->setName($name);
    }

    /**
     * 设置交换机类型
     * crx 2019年4月3日17:52:33
     * @param string $amqp_ex_type
     * @return bool
     */
    public function setType($amqp_ex_type = 'direct')
    {
        switch ($amqp_ex_type) {
            case 'direct':
                return $this->exchange_obj->setType(AMQP_EX_TYPE_DIRECT);
                break;
            case 'fanout':
                return $this->exchange_obj->setType(AMQP_EX_TYPE_FANOUT);
                break;
            case 'headers':
                return $this->exchange_obj->setType(AMQP_EX_TYPE_HEADERS);
                break;
            case 'topic':
                return $this->exchange_obj->setType(AMQP_EX_TYPE_TOPIC);
                break;
            default:
                return false;
            break;
        }
    }

    /**
     * 设置持久化
     * crx 2019年4月3日18:05:02
     * @param $flags
     * AMQP_DURABLE, 持久化 ,支持rabbitMq重启时交换机自动恢复
     * AMQP_PASSIVE,
     * AMQP_EXCLUSIVE,
     * AMQP_AUTODELETE.
     */
    public function setFlags($flags = AMQP_DURABLE)
    {
        $this->exchange_obj->setFlags($flags);
    }

    /**
     * 发送信息
     * crx 2019年4月3日17:50:43
     * @param string $msg
     * @return bool
     * @throws \AMQPChannelException
     * @throws \AMQPConnectionException
     * @throws \AMQPExchangeException
     */
    public function publish(string $msg)
    {
        return $this->exchange_obj->publish($msg);
    }

    /**
     * RabbitmqProducer destruct.
     */
    public function __destruct()
    {
        $this->connection->disconnect();
    }
}

