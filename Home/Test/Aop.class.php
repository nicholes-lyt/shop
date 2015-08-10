<?php
/**
 * AOP for PHP
 *
 * @author yuting.li
 *
 */
class AOP{
	
	/**
	 * 方法所属对象引用 
	 * @var mixed
	 * @access private
	 */
	private $instance;
	
	/**
	 * 
	* @date: 2015年8月4日 下午4:11:03
	* @author: yuting.li 
	* @Title: __construct
	* @Description: 构造方法，初始化声明的变量
	* @param unknown $instance  
	* return_type    返回类型
	 */
	public function __construct($instance){
		$this->instance = $instance;
	}


	public function __call($method,$argument) {
		if (!method_exists($this->instance, $method)) {
			throw new Exception('未定义的方法：' . $method);
		}
		$callBack = array($this->instance,$method);
		$return = call_user_func($callBack,$argument);
		$this->saveLog($method,$argument);
	}
	
	private function saveLog($method,$argument){
		echo date('Y-m-d H:i:s',time()).'  |'.$method.'|执行了操作，操作参数为['.$argument[0].']';
	}
}