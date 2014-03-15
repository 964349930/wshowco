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
     * @param array $arrInfo
     * @param array $arrFormatFile
     * @return array $arrInfo
     */
    public function format($arrInfo, $arrFormatField){
        if(in_array('cover_name', $arrFormatField)){
            $arrInfo['cover_name'] = getPicPath($arrInfo['cover']);
        }
        if(in_array('template_name', $arrFormatField)){
            $arrInfo['template_name'] = D('Template')->where('id='.$arrInfo['template_id'])->getField('spell');
        }
        return $arrInfo;
    }
}
