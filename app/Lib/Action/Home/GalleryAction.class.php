<?php
/**
 * 图库管理
 * @author chen
 * @version 2014-03-24
 */
class GalleryAction extends HomeAction
{
    /**
     * 获取图库列表
     */
    public function galleryList()
    {
        $dir = 'data/attach/';
        $files = scandir($dir);
        print_r($files);
    }
}
