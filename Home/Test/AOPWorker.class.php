<?php


class AOPWorker{
	public function testAOP(){
		Debugger::print_r(
				"\n工人:我要做一大堆操作了
                \n工人:... ...
                \n工人:好了 做完了\n");
		return 'OK';
	}

}


function testAOP(){// test aop  测试入口
	$aop = Wrapper::wrap(new AOPWorker());
	$aop->testAOP(33347);
}



class DiagnosisWrapper extends Wrapper{

	public function unpacking($name, $parameters){
		echo "\nDiagnosisWrapper:喂,有人调用$name,我要解包了.\n";
	}


	public function packing($retval,$name, $parameters){
		echo "\nDiagnosisWrapper:喂,调用$name,结果为$retval,重新打包好了.\n";
	}
}



class DasaiDiagnosisDecoration extends Decoration {
	public function before($name,$parameters){
		echo "\r\nDasaiDiagnosisDecoration:开始调用$name,已经告诉张三李四了.\n";
	}

	public function after($retval,$name,$parameters){
		echo "\nDasaiDiagnosisDecoration:结束调用$name,告诉霍金和Sheldon了.\n";
	}
}