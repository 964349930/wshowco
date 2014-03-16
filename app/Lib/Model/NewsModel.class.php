<?php
/**
 * File Name: NewsModel.class.php
 * Author: Blue
 * Created Time: 2013-10-12 9:40:04
*/
class PushNewsModel extends CommonModel{

    /**
     * 获取图文的详细信息
     * @return array $newsInfo 格式化的图文信息
     * @param int $id 图文资源的ID
     */
    public function getNewsInfo($id){
        $newsObj = D('PushNews');
        $newsInfo = $newsObj->getInfoById($id);
        $arrFormatField = array('cover_name', 'mtime_text');
        $newsInfo = $newsObj->format($newsInfo, $arrFormatField);
        return $newsInfo;
    }

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
            $routeInfo = D('PushRoute')->getRoute('pushNews', $info['id']);
            $info['keyword'] = $routeInfo['keyword'];
        }
        //时间
        if(in_array('mtime_text', $arrFormatField)){
            $info['mtime_text'] = date('Y-m-d H:i', $info['mtime']);
        }
        return $info;
    }
}
