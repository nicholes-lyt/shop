<?php

/**
 * 包装器(Wrapper).
* Wrapper是一个AOP_LIKE的实现. 也可以看作监听者模式的实现.
* 一个Wrapper报装了一个对象(source). source可以是任意对象(不包括数组及原子类型),甚至是一个Wrapper.
*
* 包装器可以任意添加饰品(Decoration).通过Wrapper调用source的函数的流程将是:
*  unpacking --> teardown --> open --> setup --> packing.
*
*  例如调用source->doXX(),各个流程将是:
*  unpacking:  解包. 这是调用任意source的函数都会调用的方法;
*  teardown:   撕掉饰品. 对于Wrapper中的每个Decoration,调用其before()函数;
*  open:       真正调用source->doXX()函数;
*  setup:      重新贴上饰品. 对于Wrapper中的每个Decoration,调用其after()函数;
*  packing:    重新打包.  这是调用任意source的函数都会调用的方法;
*
*/
class Wrapper{
	private $source;

	/**
	 * @var bool
	 */
	private $undecorated;

	/**
	 * @var array[Decoration]
	 */
	private $decorations=array();

	public function __construct($source){
		$this->source = $source;
	}

	public function __call($name,$parameters){
		$this->unpacking($name,$parameters);
		$this->tearDown($name,$parameters);

		// opening
		if(method_exists($this->source, $name)){
			$retval = call_user_func_array(array($this->source,$name),$parameters);
		}

		$this->setup($retval,$name,$parameters);
		$this->packing($retval,$name,$parameters);

		return $retval;
	}

	public function unpacking($name,$parameters){
	}

	public function packing($name,$parameters){
	}

	public function tearDown($name,$parameters){
		if($this->undecorated){
			return;
		}
		foreach ($this->decorations as $d){
			$d->before($name,$parameters);
		}
	}

	public function setup($retval,$name,$parameters){
		if($this->undecorated){
			return ;
		}
		foreach ($this->decorations as $d){
			$d->after($retval,$name,$parameters);
		}
	}

	public function decarate($decoration){
		$this->decorations[] = $decoration;
	}



	public static function wrap($source){
		//  wrap the source
		$wrapperConfig = app()->wrappers[get_class($source)];
		if($wrapperConfig){
			$wrapperClass = $wrapperConfig['class'];
			$wrapper = new $wrapperClass($source);

			foreach ($wrapperConfig['decorations'] as $item){
				$decoration = new $item;
				$wrapper->decarate($decoration);
			}
		}
		return $wrapper?$wrapper:$source;
	}

}

?>