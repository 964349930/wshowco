<?php
/**
 * 平台首页
 * @author chen
 * @version 2014-03-14
 */
class IndexAction extends HomeAction {

    //框架页
    public function index() {
        C('SHOW_PAGE_TRACE', false);
        $this->assign('channel', $this->_getChannel());
        $this->assign('menu',    $this->_getMenu());
        $this->display();
    }


}
