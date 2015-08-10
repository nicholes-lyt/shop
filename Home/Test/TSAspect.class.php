<?php
/**
 * AOP for PHP
 * 
 * @author yuting.li
 *
 */
class TSAspect{


	/**
	 * 方法所属对象引用 
	 * @var mixed
	 * @access private
	 */
	private $instance;

	/**
	 * 方法名
	 * @var mixed(可以存放任何类型数据的一种数据类型)
	 */
	private $method;


	/**
	 * 存放切面的值
	 * @var array
	 */
	private $aspect = array();
	
	/**
	 * 
	* @date: 2015年8月4日 下午2:51:19
	* @author: yuting.li 
	* @Title: __construct
	* @Description: 构造函数查找出所有Aspect的实现方法
	* @param mixed $instance
	* @param mixed $method
	* @param mixed $arg  
	* return_type   void
	 */
	public function __construct( $instance,$method,$arg = null ){
		$this->aspect = self::findFunction();
		$this->instance = $instance;
		$this->method = $method;
	}
	
	/**
	 * 
	* @date: 2015年8月4日 下午2:53:24
	* @author: yuting.li 
	* @Title: callAspect
	* @Description: 回调方法 
	* return_type  void
	 */
	public function callAspect(){
		$before_arg = $this->beforeFunction();
		$callBack = array($this->instance,$this->method);
		echo '<br>callBack------------->'.$callBack;
		echo '<br>$arg----------------->'.$before_arg;
		$return = call_user_func_array($callBack,$before_arg);
		$this->afterFunction();
	}
	
	/**
	 * 
	* @date: 2015年8月4日 下午2:54:01
	* @author: yuting.li 
	* @Title: beforeFunction
	* @Description:方法之前执行的方法集合
	* void    array
	 */
	protected function beforeFunction(){
		$result = $this->getFunction("before");
		return $result;
	}

	/**
	 * 
	* @date: 2015年8月4日 下午2:54:31
	* @author: yuting.li 
	* @Title: afterFunction
	* @Description: 方法之后执行的方法集合 
	* return_type    array
	 */
	protected function afterFunction(){
		$result = $this->getFunction( "after" );
	}
	
	/**
	 * 
	* @date: 2015年8月4日 下午2:55:15
	* @author: yuting.li 
	* @Title: findFunction
	* @Description: 查找所有的Aspect的方法集合
	* @return multitype:ReflectionClass   
	* multitype:ReflectionClass    array
	 */
	private static function findFunction(){
		$aspect = array();
		foreach (get_declared_classes() as $class ){
			$reflectionClass = new ReflectionClass( $class );
			if ( $reflectionClass->implementsInterface('InterfaceAspect' )){
				$aspect[] = $reflectionClass;
			}
		}
		return $aspect;
	}
	
	/**
	 * 
	* @date: 2015年8月4日 下午2:56:31
	* @author: yuting.li 
	* @Title: getFunction
	* @Description: 调用插入的方法
	* @param unknown $aspect
	* @return multitype:  
	* multitype:   array
	 */
	private function getFunction($aspect){
		$result = array();
		$array = $this->aspect;
		foreach ( $array as $plugin ){
			if ( $plugin->hasMethod($aspect ) ){
				$reflectionMethod = $plugin->getMethod( $aspect );
				if ( $reflectionMethod->isStatic() ){
					$items = $reflectionMethod->invoke( null );
				}else{
					$pluginInstance = $plugin->newInstance();
					$items = $reflectionMethod->invoke( $pluginInstance );
				}
				//处理经过处理的集合
				if ( is_array( $items ) ){
					$result = array_merge( $result,$items );
				}
			}
		}
		echo '<br>调用插入的方法-------------->'.$result;
		return $result;
	}
}

//定义接口，获取名称
interface InterfaceAspect{
	public static function getName();
}



/* class testAspect implements InterfaceAspect{
	public static function getName(){
		return "这是一个测试AOP";
	}

	public static function before(){
		echo "方法执行之前";
	}

	public static function after(){
		echo "方法执行后";
	}
} */


