<?php
//添加本类的日志类库
require_once(LOG4PHP_DIR.'LoggerManager.php');
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    public function index(){
    	//log4php日志
    	$logger = LoggerManager::getLogger('IndexAction');
    	$logger->debug('是debug信息!');
    	$logger->info("是info信息!");
    	$logger->error("是error信息!");
		$this->display();
    }
}