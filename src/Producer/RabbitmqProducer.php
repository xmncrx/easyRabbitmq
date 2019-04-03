<?php
/**
 * This file is part of the EasyRabbitmq.
 *
 * (c) 陈润璇 <chenrunxuan0506@163.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace easyRabbitmq\Producer;

use easyRabbitmq\RabbitmqConnent;
use AMQPExchange;

class RabbitmqProducer extends RabbitmqConnent
{
    /**
     * @var object 交换机对象
     */
    protected $exchange_obj;

    /**
     * @var string
     */
    protected $set_name;

    /**
     * RabbitmqProducer constructor.
     * @throws \AMQPConnectionException
     * @throws \AMQPExchangeException
     */
    public function __construct()
    {
        parent::__construct();

        $this->exchange_obj = new AMQPExchange($this->channel);
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->set_name = $this->exchange_obj->setName($name);
    }

    /**
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
