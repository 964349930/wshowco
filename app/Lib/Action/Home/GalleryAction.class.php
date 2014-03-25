<?php
/**
 * 图库管理
 * @author chen
 * @version 2014-03-24
 */
class GalleryAction extends HomeAction
{
    /**
     * scan user img
     */
    public function lostImgList()
    {
        $dir = 'data/attach/201403/25/';
        $files = scandir($dir);
        print_r($files);
    }

    /**
     * 获取图库列表
     */
    public function galleryList()
    {
        $parent_id = $this->_get('parent_id', 'intval');
        if(empty($parent_id)){$parent_id = 0;}
        $galleryObj = D('Gallery');
        $arrField = array();
        $arrMap['user_id'] = array('eq', $_SESSION['uid']);
        $arrMap['parent_id'] = array('eq', $parent_id);
        $arrOrder = array('date_add desc');
        $galleryList = $galleryObj->getList($arrField, $arrMap, $arrOrder);
        foreach($galleryList as $k=>$v){
            $galleryList[$k] = $galleryObj->format($v, array('cover_name'));
        }
        $data = array(
            'galleryList' => $galleryList,
            'galleryAddUrl' => U('Home/Gallery/galleryInfo', array('parent_id'=>$parent_id)),
            'galleryInfoUrl' => U('Home/Gallery/galleryInfo'),
            'galleryDelUrl' => U('Home/Gallery/galleryDel'),
            'galleryListUrl' => U('Home/Gallery/galleryList'),
        );
        $this->assign($data);
        $this->display();
    }

    /**
     * add gallery
     */
    public function galleryInfo()
    {
        $galleryObj = D('Gallery');
        if(empty($_POST)){
            $gallery_id = $this->_get('gallery_id', 'intval');
            if(!empty($gallery_id)){
                $galleryInfo = $galleryObj->getInfoById($gallery_id);
                $galleryInfo = $galleryObj->format($galleryInfo, array('cover_name'));
                $parent_id = $galleryInfo['parent_id'];
                $this->assign('galleryInfo', $galleryInfo);
            }else{
                $parent_id = $this->_get('parent_id', 'intval');
            }
            $this->assign('metaListUrl', U('Home/Gallery/metaList'));
            $this->assign('galleryInfoUrl', U('Home/Gallery/galleryInfo'));
            $this->assign('parent_id', $parent_id);
            $this->display();
            exit;
        }
        $data = $this->_post('gallery');
        $data['user_id'] = $_SESSION['uid'];
        $data['date_modify'] = time();
		if(!empty($_FILES['pic']['name'])){
			$picList = uploadPic();
			if($picList['code'] != 'error'){
				$data['cover'] = $picList['pic']['savename'];
			}
		}
        if(empty($data['id'])){
            $data['date_add'] = time();
            $galleryObj->add($data);
        }else{
            $galleryObj->save($data);
        }
        $this->success('操作成功');
    }

    /**
     * gallery delete
     */
    public function galleryDel()
    {
        $delIds = array();
		$postIds = $this->_post('id');
		if (!empty($postIds)) {
			$delIds = $postIds;
		}
		$getId = intval($this->_get('id'));
		if (!empty($getId)) {
			$delIds[] = $getId;
		}
		if (empty($delIds)) {
			$this->error('请选择您要删除的数据');
		}
		$map['id'] = $metaMap['gallery_id'] = array('in', $delIds);
        $paths = D('GalleryMeta')->where($metaMap)->getField('path', true);
        foreach($paths as $k=>$v){
            delImage($v);
        }
        D('GalleryMeta')->where($metaMap)->delete();
        $covers = D('Gallery')->where($map)->getField('cover', true);
        foreach($covers as $k=>$v){
            delImage($v);
        }
		D('Gallery')->where($map)->delete();
		$this->success('删除成功');
    }

    /**
     * meta list
     */
    public function metaList()
    {
        $gallery_id = $this->_post('gallery_id', 'intval');
        $metaObj = D('GalleryMeta');
        $arrField = array();
        $arrMap['gallery_id'] = array('eq', $gallery_id);
        $arrOrder = array('date_modify desc');
        $metaList = $metaObj->getList($arrField ,$arrMap, $arrOrder);
        foreach($metaList as $k=>$v){
            $metaList[$k] = $metaObj->format($v, array('path_name'));
        }
        $data = array(
            'metaList' => $metaList,
            'metaAddUrl' => U('Home/Gallery/metaInfo', array('gallery_id'=>$gallery_id)),
            'metaInfoUrl' => U('Home/Gallery/metaInfo'),
            'metaDelUrl' => U('Home/Gallery/metaDel'),
        );
        $this->assign($data);
        $this->display();
    }

    /**
     * meta info
     */
    public function metaInfo()
    {
        $metaObj = D('GalleryMeta');
        if(empty($_POST)){
            $id = $this->_get('meta_id', 'intval');
            if(!empty($id)){
                $metaInfo = $metaObj->getInfoById($id);
                $metaInfo = $metaObj->format($metaInfo, array('path_name'));
                $gallery_id = $metaInfo['gallery_id'];
                $this->assign('metaInfo', $metaInfo);
            }else{
                $gallery_id = $this->_get('gallery_id', 'intval');
            }
            $this->assign('gallery_id', $gallery_id);
            $this->assign('metaInfoUrl', U('Home/Gallery/metaInfo'));
            $this->display();
            exit;
        }
        $data = $this->_post();
        $data['date_modify'] = time();
		if(!empty($_FILES['pic']['name'])){
			$picList = uploadPic();
			if($picList['code'] != 'error'){
				$data['path'] = $picList['pic']['savename'];
			}
		}
        if(empty($data['id'])){
            $data['date_add'] = time();
            $metaObj->add($data);
        }else{
            $metaObj->save($data);
        }
        $this->success('操作成功');
    }

    /**
     * gallery meta delete
     */
    public function metaDel()
    {
        $delIds = array();
		$postIds = $this->_post('id');
		if (!empty($postIds)) {
			$delIds = $postIds;
		}
		$getId = intval($this->_get('id'));
		if (!empty($getId)) {
			$delIds[] = $getId;
		}
		if (empty($delIds)) {
			$this->error('请选择您要删除的数据');
		}
		$map['id'] = array('in', $delIds);
        $paths = D('GalleryMeta')->where($map)->getField('path', true);
        foreach($paths as $k=>$v){
            delImage($v);
        }
        D('GalleryMeta')->where($map)->delete();
		$this->success('删除成功');
    }

}
