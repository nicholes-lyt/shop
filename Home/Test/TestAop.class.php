<?php
require '../Test/AopFactory.class.php';
header("Content-Type: text/html; charset=utf-8");
class TestAop{
	public function test01($param) {
		echo '<br>测试aop'.$param[0].'<br>';
	}
}

$aop = AopFactory::getObject(new TestAop());
$aop->test01('asdf');