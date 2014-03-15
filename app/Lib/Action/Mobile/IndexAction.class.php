<?php
/**
 * 微网站统一控制器
 * @author chen
 * @version 2014-03-03
 */
class IndexAction extends MobileAction
{
    /**
     * 首页控制函数
     */
    public function index()
    {
        $this->display(ucfirst($this->theme_name).':index');
    }

    /**
     * 内页控制函数
     */
    public function item()
    {
        //获取栏目信息
        $id = intval($this->_get('id'));
        $info = $this->getItemInfo($id);
        $data = array(
            'info' => $info,
            'list' => $this->getItemList($id),
        );
        D('Item')->where('id='.$id)->setInc('views');
        $this->assign($data);
        $this->display(ucfirst($this->theme_name).':'.$info['template_name']);
    }
}

