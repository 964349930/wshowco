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
        $this->checkLoa();
    }

    /**
     * check user primission
     */
    private function checkLoa()
    {
        $group_id = $_SESSION['userInfo']['group_id'];
        $arrAction = __ACTION__;
        $result = explode('/', $arrAction);
        $map['module'] = array('eq', $result['3']);
        $map['action'] = array('eq', $result['4']);
        $loa_id = D('Loa')->where($map)->getField('id');
        if(!empty($loa_id)){
            if(!D('LoaGroup')->where('group_id='.$_SESSION['userInfo']['group_id'].' AND loa_id='.$loa_id)->find()){
                $this->error('对不起，您没有权限执行此操作!');
                exit;
            }
        }
    }
}
