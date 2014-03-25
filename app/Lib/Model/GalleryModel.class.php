<?php
/**
 * Gallery mobel
 * @author chen
 * @version 2014-03-25
 */
class GalleryModel extends CommonModel
{
    /**
     * format
     */
    public function format($arrInfo, $arrFormat)
    {
        if(in_array('cover_name', $arrFormat)){
            $arrInfo['cover_name'] = getPicPath($arrInfo['cover']);
        }
        return $arrInfo;
    }

    /**
     * get the default gallery id
     */
    public function getDefaultGalleryId($img_name)
    {
        $map['user_id'] = array('eq', $_SESSION['uid']);
        $galleryId = $this->where($map)->getField('id');
        if(empty($galleryId)){
            $data['user_id'] = $_SESSION['uid'];
            $data['cover'] = $img_name;
            $data['date_add'] = $data['date_modify'] = time();
            $galleryId = $this->add($data);
        }
        return $galleryId;
    }
}
