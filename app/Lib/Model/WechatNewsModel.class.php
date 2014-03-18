<?php
/**
 * File Name: NewsModel.class.php
 * Author: Blue
 * Created Time: 2013-10-12 9:40:04
*/
class WechatNewsModel extends CommonModel{

    /**
     * 格式化
     * @return array $info 格式化后的数组
     * @param  array $info 格式化前的数组
     * @param  array $arrFormatField 需要格式化的数组
     */
    public function format($info, $arrFormatField){
        //封面
        if(in_array('cover_name', $arrFormatField)){
            $info['cover_name'] = getPicPath($info['cover']);
        }
        //关键字
        if(in_array('keyword', $arrFormatField)){
            $routeInfo = D('WechatRoute')->getRoute('news', $info['id']);
            $info['keyword'] = $routeInfo['keyword'];
        }
        return $info;
    }

    /**
     * update the news action
     */
    public function updateNews($news)
    {
        $newsObj = D('WechatNews');
        $news['date_modify'] = time();
        $id = $news['id'];
        if(empty($id)){
            $news['user_id'] = $_SESSION['uid'];
            $news['date_add'] = time();
            $id = $newsObj->add($news);
        }else{
            $newsObj->save($news);
        }
        return $id;
    }

}
