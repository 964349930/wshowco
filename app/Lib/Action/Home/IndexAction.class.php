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

   /**
     * 头部菜单
     */
    protected function _getChannel() {
		$arrList = array();
		$tabList = D('Tab')->getTabList();
		foreach($tabList as $k=>$v){
			$arrList[$v['tag']] = $v['title'];
		}
		return $arrList;
	}

    /**
     * 左侧菜单
     */
    protected function _getMenu() {
        $menu = array();
		$first_list = D('Tab')->getTabList();
		foreach($first_list as $k=>$v){
			$second_list = D('Tab')->getTabList($v['id']);	
			foreach($second_list as $k2=>$v2){
				$third_list = D('Tab')->getTabList($v2['id']);
				foreach($third_list as $k3=>$v3){
					$third_real_list[$v3['title']] = U($v3['url']);
					$second_real_list[$v2['title']] = $third_real_list;
				}
				$third_real_list = array();
			}
			$menu[$v['tag']] = $second_real_list;
			$second_real_list = array();
		}
        return $menu;
    }
}
