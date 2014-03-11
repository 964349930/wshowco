<?php
/**
 * 首页
 * @version 2014-03-11
 */
class IndexAction extends AdminAction
{
    /**
     * 后台框架页
     */
	public function index()
	{
		$this->assign('channel', $this->_getChannel());
		$this->assign('menu',    $this->_getMenu());
		$this->display();
	}

	/**
	 * 首页
	 */
	public function main()
	{
		$this->display();
	}

	/**
	 * 顶部频道
	 */
	protected function _getChannel()
	{
		return array(
			'index'     => '首页',
		);
	}

	/**
	 * 左侧菜单
	 */
	protected function _getMenu()
	{
		$menu['index'] = array(
			'首页' => array(
				'首页' => U('admin/index/main'),
			),
            '订单管理' => array(
                '订单列表' => U('Admin/Order/ls'),
            ),
            '内容管理' => array(
                '内容列表' => U('Admin/Item/ls'),
            ),
            '信息管理' => array(
                '信息列表' => U('Admin/Message/ls'),
            ),
		);
		return $menu;
	}
}
