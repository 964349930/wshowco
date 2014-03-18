<?php
/**
 * Message model
 * @author chen
 * @version 2014-03-18
 */
class MessageModel extends CommonModel
{
    /**
     * add the wechat message
     */
    public function addWechatMessage($arrPost, $user_id)
    {
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
            'user_id'  => $user_id,
            'type'     => '1',
            'guest'    => $arrPost['FromUserName'],
            'info'     => $content,
            'date_add' => time(),
        );
        $id = D('Message')->add($insert);
        return $id;
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
