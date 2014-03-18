<?php
/**
 * 消息管理类
 * @author chen
 * @version 2014-03-11
 */
class MessageAction extends HomeAction
{
    /**
     * 列表
     */
    public function messageList()
    {
        $arrField = array('*');
        $arrMap['user_id'] = array('eq', $_SESSION['uid']);
        $arrOrder = array('date_add desc');
        $page = page(D('Message')->getCount($arrMap));
        $messageList = D('Message')->getList($arrField, $arrMap, $arrOrder, $page->firstRow, $page->listRows);
        foreach($messageList as $k=>$v){
            $messageList[$k] = D('Message')->format($v, array('type_name', 'mobile_name'));
        }
        $data = array(
            'delUrl'      => U('Home/Message/del'),
            'messageList' => $messageList,
            'pageHtml'    => $page->show(),
        );
        $this->assign($data);
        $this->display();
    }

    /**
     * 添加
     */
    public function add()
    {
        $this->display();
    }

    /**
     * 更新
     */
    public function edit()
    {
        $this->display();
    }

    /**
     * 删除
     */
    public function del()
    {
        $delIds = array();
		$postIds = $this->_post('id');
		if (!empty($postIds)) {
			$delIds = $postIds;
		}
		$getId = intval($this->_get('id'));
		if (!empty($getId)) {
			$delIds[] = $getId;
		}
		if (empty($delIds)) {
			$this->error('请选择您要删除的数据');
		}
		$map['id'] = array('in', $delIds);
		D('Message')->where($map)->delete();
		$this->success('删除成功');
    }
}
