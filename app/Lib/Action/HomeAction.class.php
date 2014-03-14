<?php
/**
 * 前台公共控制器类
 * @author chen
 * @version 2014-03-11
 */
class HomeAction extends BaseAction
{
    public function _initialize()
    {
        if(empty($_SESSION['uid'])){
            $this->redirect('Public/login');
        }
    }
}
