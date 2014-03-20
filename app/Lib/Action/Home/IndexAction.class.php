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
        if($_SESSION['uid'] == 1){
            return array(
                'index' => '内容',
                'setting' => '设置',
            );
        }else{
            return array('index'=>'内容');
        }
        /*
		$arrList = array();
		$tabList = $this->getMenuList();
		foreach($tabList as $k=>$v){
			$arrList[$v['spell']] = $v['name'];
		}
		return $arrList;
         */
	}

    /**
     * 左侧菜单
     */
    protected function _getMenu() {
        $menu = array();
        $menu['index'] = array(
            '我的信息' => array(
                '基本信息' => U('Home/User/basic'),
                '修改密码' => U('Home/User/password'),
            ),
            '微网管理' => array(
                '网站设置' => U('Home/Item/setting'),
                '栏目列表' => U('Home/Item/itemList'),
            ),
            '会员管理' => array(
                '会员列表' => U('Home/Member/MemberList'),
            ),
            '菜单管理' => array(
                '菜单列表' => U('Home/Menu/menuList'),
            ),
            '主题管理' => array(
                '主题列表' => U('Home/Theme/themeList'),
            ),
            '自动回复管理' => array(
                '关注回复' => U('Home/News/special', array('keyword'=>'关注')),
                '无匹配回复' => U('Home/News/special', array('keyword'=>'无匹配')),
                '文字回复' => U('Home/News/textList'),
                '图文回复' => U('Home/News/newsList'),
            ),
            '插件管理' => array(
                '插件列表' => U('Home/Tool/toolList'),
            ),
        );
        $menu['setting'] = array(
            '用户管理' => array(
                '用户列表' => U('Home/User/userList'),
            ),
            '主题管理' => array(
                '主题列表' => U('Home/Theme/themeList'),
            ),
            '微信功能' => array(
                '接口模拟' => U('Home/Wechat/sim'),
                '通用关键字' => U('Home/Wechat/keywordList'),
            ),
            '工具管理' => array(
                '工具列表' => U('Home/Tool/toolList'),
            ),
        );
        return $menu;
        /*
        $menu = array();
		$first_list = $this->getMenuList();
		foreach($first_list as $k=>$v){
			$second_list = $this->getMenuList($v['id']);	
			foreach($second_list as $k2=>$v2){
				$third_list = $this->getMenuList($v2['id']);
				foreach($third_list as $k3=>$v3){
					$third_real_list[$v3['name']] = U($v3['url']);
					$second_real_list[$v2['name']] = $third_real_list;
				}
				$third_real_list = array();
			}
			$menu[$v['spell']] = $second_real_list;
			$second_real_list = array();
		}
        return $menu;
         */
    }

	/**
	 * 获取菜单列表
	 */
	private function getMenuList($id=0){
		$tabObj = D('Tab');
		$arrField = array('*');
		$arrMap['fid'] = array('eq', $id);
        //tab信息存储位置
		$arrMap['id'] = array('in', $_SESSION['info']['tab']);
		$arrOrder = array();
		$tabList = $tabObj->getList($arrField, $arrMap, $arrOrder);
		return $tabList;
	}
}
