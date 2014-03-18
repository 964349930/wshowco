<?php
/**
 * member model
 * @warning if the new guest use another's link to visit the site,
 * then the system cann't check if the current member , how to ?
 * @author chen
 * @version 2014-03-18
 */
class MemberModel extends CommonModel
{
    /**
     * get the member_id
     * @param int $wechat_id
     * @return int member_id
     */
    public function getMemberIdByWechatId($wechat_id)
    {
        $map['user_id'] = array($_SESSION['uid']);
        $map['wechat_id'] = array('eq', $wechat_id);
        $result = $this->where($map)->find();
        $member_id = $result['id'];
        if(empty($member_id)){
            $data = array(
                'user_id' => $_SESSION['uid'],
                'wechat_id' => $wechat_id,
                'date_reg' => time(),
                'date_login' => time(),
            );
            $member_id = $this->add($data);
        }
        return $member_id;
    }

}