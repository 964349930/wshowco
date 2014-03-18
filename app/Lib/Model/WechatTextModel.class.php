<?php
/**
 * File Name: TextModel.class.php
 * Author: Blue
 * Created Time: 2013-11-16 14:21:30
*/
class WechatTextModel extends CommonModel{
	/**
	 * 首页方法
	 */
	public function format($arrInfo, $arrFormatField){
        if(in_array('keyword', $arrFormatField)){
            $routeInfo = D('WechatRoute')->getRoute('text', $arrInfo['id']);
            $arrInfo['keyword'] = $routeInfo['keyword'];
        }
		return $arrInfo;
	}

    /**
     * update the text info
     */
    public function updateText($text)
    {
        $textObj = D('WechatText');
        $text['date_modify'] = time();
        $id = $text['id'];
        if(empty($id)){
            $text['user_id']  = $_SESSION['uid'];
            $text['date_add'] = time();
            $id = $textObj->add($text);
        }else{
            $textObj->save($text);
        }
        return $id;
    }


}
