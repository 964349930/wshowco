<?php
/**
 * 前台公共控制器类
 * @author chen
 * @version 2014-03-11
 */
class HomeAction extends BaseAction
{
    /**
     * initialize
     */
    public function _initialize()
    {
        if(!isset($_SESSION['uid'])){
            $this->redirect('Public/login');
        }
    }

    /**
     * check user primission
     */
    private function checkPro()
    {
        $group_id = $_SESSION['userInfo']['group_id'];
        $actionList = D('Promission')->where('group_id='.$group_id)->getField('action');
        if(1){
            $this->error('对不起，您没有权限执行此操作!');
            exit;
        }
    }
}
