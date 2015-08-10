<?php
/**
 * 此工厂类每次实例化不同的对象
 * @author yuting.li
 *
 */
require '../Test/Aop.class.php';
class AopFactory{
	
	public static function getObject($param) {
		//初始化AOP对象
		return new AOP($param);
	}
	
}