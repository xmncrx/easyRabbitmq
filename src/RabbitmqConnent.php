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
//        echo 33333;
        $this->channel = $this->connection->channel();
    }
}

//$obj = new RabbitmqConnent();
