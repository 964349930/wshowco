<?php
/**
 * news meta model
 * @author vhen
 * @version 2014-03-17
 */
class NewsMetaModel extends CommonModel
{
    /**
     * format action
     * @param array $arrInfo
     * @param array @arrFormatField
     * @return array $arrInfo
     */
    public function format($arrInfo, $arrFormatField)
    {
        if(in_array('cover_name', $arrFormatField)){
            $arrInfo['cover_name'] = getPicPath($arrInfo['cover']);
        }
        return $arrInfo;
    }

    /**
     * update the meta action
     */
    public function updateMeta($meta, $news_id)
    {
        $metaObj = D('NewsMeta');
        $meta['date_modify'] = time();
        if(empty($meta['id'])){
            $meta['news_id'] = $news_id;
            $meta['date_add'] = time();
            $result = $metaObj->add($meta);
        }else{
            $result = $metaObj->save($meta);
        }
        return $result;
    }


}
