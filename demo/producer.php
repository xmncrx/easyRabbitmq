<?php
/**
 * 生产者
 */
include_once '../src2/RabbitmqConnent.php';

$obj = new RabbitmqConnent('hello','hello','direct');

$data = 'hellow world';
$obj->publish($data,'hello_key');

echo $data,"\n";
