<?php
class Test01{
	
}
function fun(){
	fun1();
	fun2();
}

function fun1(){
	echo '这个是方法1';
}

function fun2(){
	echo '这个是方法2';
}
echo 'test'; 
echo get_class_name();

$h=config_item("parser_fun") ;


function add($hook,$actionFunc){
	global $emHooks;//
	if(!@in_array($actionFunc, $emHooks[$hook])){
		$emHooks[$hook][] = $actionFunc;
	}
	return true;
}
