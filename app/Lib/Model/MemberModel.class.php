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
    public function getMemberIdByWechatId($user_id, $wechat_id)
    {
        $map['user_id'] = array('eq', $user_id);
        $map['wechat_id'] = array('eq', $wechat_id);
        $result = D('Member')->where($map)->find();
        if(empty($result)){
            $data = array(
                'user_id' => $user_id,
                'wechat_id' => $wechat_id,
                'date_reg' => time(),
                'date_login' => time(),
            );
            $member_id = D('Member')->add($data);
        }else{
            $member_id = $result['id'];
        }
        return $member_id;
    }

    /**
     * format action
     */
    public function format($arrInfo, $arrFormat)
    {
        return $arrInfo;
    }

}
