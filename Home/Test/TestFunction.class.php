<?php
function testFunc1(){
	echo 'aop_add_before <br/>';
}

class TastFunction{
	public function samTest($arg){
		echo "这是一个测试方法".$arg;
	}

}
require '../Test/TSAspect.class.php';
header("Content-type:text/html;charset=utf-8");
$test = new TastFunction();
$aspect = new TSAspect($test,'samTest');

$aspect->callAspect();