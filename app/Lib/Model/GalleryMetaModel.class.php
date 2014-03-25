<?php
/**
 * Gallery meta mobel
 * @author chen
 * @version 2014-03-25
 */
class GalleryMetaModel extends CommonModel
{
    /**
     * format
     */
    public function format($arrInfo, $arrField){
        if(in_array('path_name', $arrField)){
            $arrInfo['path_name'] = getPicPath($arrInfo['path']);
        }
        return $arrInfo;
    }

    /**
     * add the img
     */
    public function addImg($img_name)
    {
        if(empty($img_name)){
            return 0;
            exit;
        }
        $gallery_id = D('Gallery')->getDefaultGalleryId($img_name);
        $data['gallery_id'] = $gallery_id;
        $data['path'] = $img_name;
        $data['date_modify'] = $data['date_add'] = time();
        $img_id = $this->add($data);
        return $img_id;
    }

    /**
     * get the image
     */
    public function getImg($img_id)
    {
        if(empty($img_id)){
            return 0;
            exit;
        }
        $path = $this->where('id='.$img_id)->getField('path');
        return $path; 
    }

}
