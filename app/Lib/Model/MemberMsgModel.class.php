<?php
/**
 * member msg model
 * @author chen
 * @version 2014-03-18
 */
class MemberMsgModel extends CommonModel
{
    /**
     * add the wechat message
     */
    public function addWechatMessage($arrPost, $member_id)
    {
        if(!empty($member_id)){
        switch ($arrPost['MsgType']){
        case 'event':
            $content = $arrPost['Event'];
            break;
        case 'text':
            $content = $arrPost['Content'];
            break;
        default :
            $content = '未知类型';
            break;
        }
        $insert = array(
            'member_id' => $member_id,
            'type'     => '1',
            'info'     => $content,
            'date_msg' => time(),
        );
        $id = D('MemberMsg')->add($insert);
        return $id;
        }
    }

    /**
     * format the data
     * @param array $arrInfo
     * @param array @arrFormatField
     * @return array $arrInfo
     */
    public function format($arrInfo, $arrFormatField)
    {
        if(in_array('type_name', $arrFormatField)){
            $arrInfo['type_name'] = ($arrInfo['type'] == 1) ? '微信信息' : '网站留言';
        }
        if(in_array('mobile_name', $arrFormatField)){
            $arrInfo['mobile_name'] = ($arrInfo['mobile']) ? $arrInfo['mobile'] : '未知';
        }
        return $arrInfo;
    }
}
