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
            $memberList[$k] = $memberObj->format($v, array('avatar_name'));
        }
        $data = array(
            'memberList' => $memberList,
            'pageHtml' => $page->show(),
        );
        $this->assign($data);
        $this->display();
    }

    /**
     * view the member info
     */
    public function viewInfo()
    {
        $memberObj = D('Member');
        $id = $this->_get('id', 'intval');
        $memberInfo = $memberObj->getInfoById($id);
        $memberInfo = $memberObj->format($memberInfo, array('avatar_name'));
        $data = array(
            'memeberInfo' => $memberInfo,
        );
        $this->assign($data);
        $this->display();
    }

    /**
     * view the member visit log
     */
    public function eventList()
    {
        $member_id = $this->_get('member_id', 'intval');
        $event = $this->_get('event');
        $eventObj = D('MemberEvent');
        $arrField = array();
        $arrMap['member_id'] = array('eq', $member_id);
        $arrMap['event'] = array('eq', $event);
        $arrOrder = array('date_event');
        $page = page($logObj->getCount($arrMap));
        $eventList = $eventObj->getList($arrField, $arrMap, $arrOrder, $page->firstRow, $page->listRows);
        $data = array(
            'eventList' => $eventList,
            'pageHtml' => $page->show(),
        );
        $this->assign($data);
        $this->display();
    }

    /**
     * view the message content
     */
    public function msgList()
    {
        $member_id = $this->_get('id', 'intval');
        $msgObj = D('MemberMsg');
        $arrField = array();
        $arrMap['member_id'] = array('eq', $member_id);
        $arrOrder = array('date_msg desc');
        $page = page($msgObj->getCount($arrMap));
        $msgList = $msgObj->getList($arrField, $arrMap, $arrOrder, $page->firstRow, $page->listRows);
        foreach($msgList as $k=>$v){
            $msgList[$k] = $msgObj->format($v, array('type_name'));
        }
        $data = array(
            'msgList' => $msgList,
            'pageHtml' => $page->show(),
        );
        $this->assign($data);
        $this->display();
    }
}