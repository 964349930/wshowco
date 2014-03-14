<?php
/**
 * 内容模型类
 * @author chen
 * @version 2014-03-12
 */
class ItemModel extends CommonModel
{
    /**
     * 格式化
     */
    public function format($arrInfo, $arrFormatField){
        if(in_array('cover_name', $arrFormatField)){
            $arrInfo['cover_name'] = getPicPath($arrInfo['cover']);
        }
        return $arrInfo;
    }
}
