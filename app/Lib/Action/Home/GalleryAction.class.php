<?php
/**
 * 图库管理
 * @author chen
 * @version 2014-03-24
 */
class GalleryAction extends HomeAction
{
    /**
     * upload the image
     */
    public function uploadImage()
    {
		if(isset($_FILES['pic'])){
			$picList = uploadPic();
			if($picList['code'] != 'error'){
				$id = D('GalleryMeta')->addImg($picList['pic']['savename']);
			}
            if(!empty($id)){
                echo $id;
            }else{
                //echo 'upload image field';
                print_r($_POST);
            }
		}else{
            echo 'img is null';
        }
    }


    /**
     * get the gallery list for add new img
     */
    public function getGalleryList()
    {
        $galleryList = D('Gallery')->where('user_id='.$_SESSION['uid'])->select();
        $html = '';
        foreach($galleryList as $k=>$v){
            $html .= "<option value='".$v['id']."'>".$v['title']."</option>";
        }
        echo $html;
    }

    /**
     * show the gallery meta
     */
    public function showImgList()
    {
        $imgObj = D('GalleryMeta');
        $gallery_id = $this->_post('gallery_id', 'intval');
        if(empty($gallery_id)){
            $gallery_id = D('Gallery')->getDefaultGalleryId();
        }
        $arrField = array();
        $arrMap['gallery_id'] = array('eq', $gallery_id);
        $arrOrder = array();
        $imgList = $imgObj->getList($arrField, $arrMap, $arrOrder);
        foreach($imgList as $k=>$v){
            $imgList[$k] = $imgObj->format($v, array('path_name'));
        }
        $this->assign('imgList', $imgList);
        $this->display();
    }

    /**
     * scan user img
     */
    public function lostImgList()
    {
        $dir = './data/attach';
        $allImgs = find_all_files($dir);
        $sqlImgs = D('GalleryMeta')->getField('path', true);
        foreach($sqlImgs as $k=>$v){
            $sqlImgs[$k] = getPicPath($v);
        }
        $result = array_diff($allImgs, $sqlImgs);
        $data = array(
            'imgList' => $result,
            'lostDelUrl' => U('Home/Gallery/lostDel'),
        );
        $this->assign($data);
        $this->display();
    }

    /**
     * lost img delete
     */
    public function lostDel()
    {
        $delImgs = array();
		$postImgs = $this->_post('img');
		if (!empty($postImgs)) {
			$delImgs = $postImgs;
		}
		$getImg = trim($this->_get('img'));
		if (!empty($getImg)) {
			$delImgs[] = $getImg;
		}
		if (empty($delImgs)) {
			$this->error('请选择您要删除的数据');
		}
        foreach($delImgs as $k=>$v){
            $imgInfo = pathinfo($v);
            foreach(array('_b', '_m', '_s') as $k2=>$v2){
                $delImgs[] = $imgInfo['dirname'].'/'.basename($imgInfo['basename'], '.jpg').$v2.'.'.$imgInfo['extension'];
            }
        }
        foreach($delImgs as $k=>$v){
            unlink($v);
        }
        $this->success('删除成功');
    }

    /**********************图库管理*******************************/

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
            'current' => 'gallery_list',
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
        $this->breadcrumbs['1'] = array(
            'title' => '相册管理',
            'url' => U('Gallery/galleryList'),
        );
        if(empty($_POST)){
            $id = $this->_get('id', 'intval');
            if(!empty($id)){
                $galleryInfo = $galleryObj->getInfoById($id);
                $galleryInfo = $galleryObj->format($galleryInfo, array('cover_name'));
                $this->assign('galleryInfo', $galleryInfo);
            }
            $this->assign('breadcrumbs', $this->breadcrumbs);
            $this->display();
            exit;
        }
        $data = $this->_post();
        $data['user_id'] = $_SESSION['uid'];
        $data['date_modify'] = time();
        if(empty($data['id'])){
            $data['date_add'] = time();
            if($galleryObj->add($data)){
                echo json_encode(array('code'=>'1','msg'=>'创建成功'));
            }else{
                echo json_encode(array('code'=>'2','msg'=>'创建失败'));
            }
        }else{
            if($galleryObj->save($data)){
                echo json_encode(array('code'=>'1','msg'=>'创建成功'));
            }else{
                echo json_encode(array('code'=>'2','msg'=>'创建失败'));
            }
        }
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
        if(D('Gallery')->where($map)->delete()){
            echo json_encode(array('code'=>'1','msg'=>'删除成功'));
        }else{
            echo json_encode(array('code'=>'0','msg'=>'删除失败'));
        }
    }


    /*******************************图片管理******************************/
    /**
     * meta list
     */
    public function metaList()
    {
        $gallery_id = $this->_request('gallery_id', 'intval');
        $metaObj = D('GalleryMeta');
        $arrField = array();
        $arrMap['gallery_id'] = array('eq', $gallery_id);
        $arrOrder = array('date_modify desc');
        $page = page($metaObj->getCount($arrMap), 10);
        $metaList = $metaObj->getList($arrField ,$arrMap, $arrOrder, $page->firstRow, $page->listRows);
        foreach($metaList as $k=>$v){
            $metaList[$k] = $metaObj->format($v, array('path_name'));
        }
        $this->breadcrumbs['1'] = array(
            'title' => D('Gallery')->where('id='.$gallery_id)->getField('title'),
            'url' => U('Gallery/galleryList'),
        );
        $data = array(
            'breadcrumbs' => $this->breadcrumbs,
            'gallery_id' => $gallery_id,
            'metaList' => $metaList,
            'pageHtml' => $page->show(),
            'current' => 'gallery_list',
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
            $id = $this->_get('id', 'intval');
            if(!empty($id)){
                $metaInfo = $metaObj->getInfoById($id);
                $metaInfo = $metaObj->format($metaInfo, array('path_name'));
                $gallery_id = $metaInfo['gallery_id'];
                $this->assign('metaInfo', $metaInfo);
            }else{
                $gallery_id = $this->_get('gallery_id', 'intval');
            }
            $this->assign('gallery_id', $gallery_id);
            $this->assign('current', 'gallery_list');
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
            if($metaObj->add($data)){
                echo json_encode(array('code'=>'1','msg'=>'更新成功'));
            }else{
                echo json_encode(array('code'=>'2','msg'=>'更新失败'));
            }
        }else{
            if($metaObj->save($data)){
                echo json_encode(array('code'=>'1','msg'=>'更新成功'));
            }else{
                echo json_encode(array('code'=>'2','msg'=>'更新失败'));
            }
        }
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
        if(D('GalleryMeta')->where($map)->delete()){
            echo json_encode(array('code'=>'1','msg'=>'删除成功'));
        }else{
            echo json_encode(array('code'=>'0','msg'=>'删除失败'));
        }
    }

}
