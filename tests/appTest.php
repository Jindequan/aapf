<?php
include '../vendor/autoload.php';
$a = [1,2,3];
foreach ($a as &$value) {
var_dump($value);//$value是声明的一个变量，&是引用这个变量的内存地址。三次循环中修改了$value的值分别为$a[0],$a[1],$a[2]。且$a也发生了变化，
//随着$value变更其引用地址，最后一次引用将$a[2]与其关联在一起。即$value bind $a[2]
}
var_dump($a);
foreach ($a as $value) {//
var_dump($value);//循环前两次分别$value=$a[0](1),$a[1](2),第三次的时候因为之前$a[2]与$value的内存地址绑定在一起了，而$value=$a[1](2),故将此$value赋值给$value。我=我所以第三次值是2
}
var_dump($a);die;

$res = \AF\Core\Orm\Pdo::getInstance()->setConnection('127.0.0.1', 3306, 'root', 'root', 'mysql');

var_dump($res);die;
$id = \AF\Tool\TraceId::getInstance()->genTraceId('Datetime');
$nextId = \AF\Tool\TraceId::getInstance()->nextTraceId($id);
var_dump($id, $nextId);die;
