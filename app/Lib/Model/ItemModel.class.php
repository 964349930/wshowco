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
            $arrInfo['cover_name'] = getPicPath(D('GalleryMeta')->getImg($arrInfo['cover']));
        }
        if(in_array('template_name', $arrFormatField)){
            $arrInfo['template_name'] = D('ThemeTpl')->where('id='.$arrInfo['template_id'])->getField('spell');
        }
        if(in_array('ext', $arrFormatField)){
            $arrInfo['ext'] = D('Ext')->getExtList('item', $arrInfo['id']);
        }
        return $arrInfo;
    }
}
