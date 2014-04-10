<?php
/**
 * member management action
 * @author chen
 * @version 2014-03-18
 */
class MemberAction extends HomeAction
{
    /**
     * get the member list
     */
    public function memberList()
    {
        $memberObj = D('Member');
        $arrField = array();
        $arrMap['user_id'] = array('eq', $_SESSION['uid']);
        $arrOrder = array('date_login desc');
        $page = page($memberObj->getCount($arrMap));
        $memberList = $memberObj->getList($arrField, $arrMap, $arrOrder, $page->firstRow, $page->listRows);
        foreach($memberList as $k=>$v){
            $memberList[$k] = $memberObj->format($v, array('avatar_name', 'name', 'mobile'));
        }
        $data = array(
            'infoUrl' => U('Home/Member/memberInfo'),
            'msgUrl' => U('Home/Member/msgList'),
            'pushUrl' => U('Home/Member/pushList'),
            'viewUrl' => U('Home/Member/viewList'),
            'likeUrl' => U('Home/Member/likeList'),
            'memberList' => $memberList,
            'pageHtml' => $page->show(),
        );
        $this->assign($data);
        $this->display();
    }

    /**
     * view the member info
     */
    public function memberInfo()
    {
        $memberObj = D('Member');
        $member_id = $this->_get('member_id', 'intval');
        $memberInfo = $memberObj->getInfoById($member_id);
        $memberInfo = $memberObj->format($memberInfo, array('avatar_name'));
        $data = array(
            'memberInfo' => $memberInfo,
        );
        $this->assign($data);
        $this->display();
    }

    /**
     * view the member visit log
     */
    public function viewList()
    {
        $member_id = $this->_get('member_id', 'intval');
        $visitObj = D('MemberVisit');
        $arrField = array();
        $arrMap['member_id'] = array('eq', $member_id);
        $arrOrder = array('date_visit');
        $page = page($visitObj->getCount($arrMap));
        $visitList = $visitObj->getList($arrField, $arrMap, $arrOrder, $page->firstRow, $page->listRows);
        foreach($visitList as $k=>$v){
            $visitList[$k]['item_title'] = D('Item')->where('id='.$v['item_id'])->getField('title');
        }
        $data = array(
            'visitList' => $visitList,
            'pageHtml' => $page->show(),
        );
        $this->assign($data);
        $this->display();
    }

    /**
     * view the member visit log
     */
    public function likeList()
    {
        $member_id = $this->_get('member_id', 'intval');
        $eventObj = D('MemberCol');
        $arrField = array();
        $arrMap['member_id'] = array('eq', $member_id);
        $arrOrder = array('date_col');
        $page = page($eventObj->getCount($arrMap));
        $eventList = $eventObj->getList($arrField, $arrMap, $arrOrder, $page->firstRow, $page->listRows);
        $data = array(
            'eventList' => $eventList,
            'pageHtml' => $page->show(),
        );
        $this->assign($data);
        $this->display();
    }

    /**
     * wechat push list
     */
    public function pushList()
    {
        $member_id = $this->_get('member_id', 'intval');
        $pushObj = D('MemberPush');
        $arrField = array();
        if(!empty($member_id)){
            $arrMap['member_id'] = array('eq', $member_id);
        }else{
            $member_id_list = D('Member')->where('user_id='.$_SESSION['uid'])->getField('id', true);
            $arrMap['member_id'] = array('in', $member_id_list);
        }
        $arrOrder = array('date_push desc');
        $page = page($pushObj->getCount($arrMap));
        $pushList = $pushObj->getList($arrField, $arrMap, $arrOrder, $page->firstRow, $page->listRows);
        foreach($pushList as $k=>$v){
            $pushList[$k]['member_name'] = D('Member')->where('id='.$v['member_id'])->getField('name');
        }
        $data = array(
            'member_id' => $member_id,
            'pushList' => $pushList,
            'pageHtml' => $page->show(),
            'pushDelUrl' => U('Home/Member/pushDel'),
        );
        $this->assign($data);
        $this->display();
    }

    /**
     * view the site message list
     */
    public function msgList()
    {
        $member_id = $this->_get('member_id', 'intval');
        $msgObj = D('MemberMsg');
        $arrField = array();
        if(!empty($member_id)){
            $arrMap['member_id'] = array('eq', $member_id);
        }else{
            $member_id_list = D('Member')->where('user_id='.$_SESSION['uid'])->getField('id', true);
            $arrMap['member_id'] = array('in', $member_id_list);
        }
        $arrOrder = array('date_msg desc');
        $page = page($msgObj->getCount($arrMap));
        $msgList = $msgObj->getList($arrField, $arrMap, $arrOrder, $page->firstRow, $page->listRows);
        foreach($msgList as $k=>$v){
            $msgList[$k] = $msgObj->format($v, array('member_name'));
        }
        $data = array(
            'member_id' => $member_id,
            'msgList' => $msgList,
            'pageHtml' => $page->show(),
            'msgDelUrl' => U('Home/Member/msgDel'),
        );
        $this->assign($data);
        $this->display();
    }

    public function pushDel()
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
		D('MemberPush')->where($map)->delete();
		$this->success('删除成功');
    }

    /**
     * 删除
     */
    public function msgDel()
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
		D('MemberMsg')->where($map)->delete();
		$this->success('删除成功');
    }
}
