<?php
/**
 * 消费者
 */

include_once '../src2/RabbitmqConnent.php';

$obj = new RabbitmqConnent('hello','hello','direct');

$obj->consume();

