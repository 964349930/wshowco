<?php
/**
 * 内容管理类
 * @author chen
 * @version 2014-03-11
 */
class ItemAction extends HomeAction
{
    public function _initialize()
    {
        parent::_initialize();
        $this->breadcrumbs['1'] = array(
            'title' => '文章管理',
            'url' => U('Home/Item/itemList'),
        );
    }

    /**
     * 微网设置
     */
    public function setting()
    {
        $siteObj = D('Setting');
        if(empty($_POST)){
            $user_id = $_SESSION['uid'];
            $siteInfo = $siteObj->where('user_id='.$user_id)->find();
            $siteInfo = $siteObj->format($siteInfo, array('logo_name', 'url', 'theme_name'));
            $galleryList = D('Gallery')->where('user_id='.$user_id)->select();
            $this->assign('galleryList', $galleryList);
            $this->assign('siteInfo', $siteInfo);
            $this->assign('settingUrl', U('Home/Item/setting'));
            $this->display();
            exit;
        }
        $data = $this->_post();
		if(!empty($_FILES['pic']['name'])){
			$picList = uploadPic();
			if($picList['code'] != 'error'){
                $data['logo'] = D('GalleryMeta')->addImg($picList['pic']['savename']);
			}
		}
        if(empty($data['id'])){
            $data['user_id'] = $_SESSION['uid'];
            $siteObj->add($data);
        }else{
            if($siteObj->save($data)){
                echo json_encode(array('status'=>'alert-success','msg'=>'更新成功'));
            }else{
                echo json_encode(array('status'=>'alert-danger','msg'=>'更新失败'));
            }
        }
    }

    /**
     * 内容列表
     */
    public function itemList()
    {
        $itemObj = D('Item');
        $parent_id = $this->_get('parent_id', 'intval');
        $arrField = array();

        //search
        $search = $this->_post('search');
        if(!empty($search)){
            $arrMap['title'] = array('like', '%'.$search.'%');
        }

        //For the Parent item
        if(empty($parent_id)){$parent_id = 0;}
        $arrMap['user_id'] = array('eq', $_SESSION['uid']);
        $arrMap['parent_id'] = array('eq', $parent_id);
        $page = page($itemObj->getCount($arrMap));
        $arrOrder = array('sort_order');
        $itemList = $itemObj->getList($arrField, $arrMap, $arrOrder, $page->firstRow, $page->listRows);
        foreach($itemList as $k=>$v){
            $itemList[$k] = $itemObj->format($v, array('cover_name'));
        }

        /** 面包屑导航 **/
         
        $data = array(
            'breadcrumbs' => $this->breadcrumbs,
            'addUrl'   => U('Home/Item/itemInfo', array('parent_id'=>$parent_id)),
            'editUrl'  => U('Home/Item/itemInfo'),
            'delUrl'   => U('Home/Item/del'),
            'subUrl'   => U('Home/Item/itemList'),
            'itemList' => $itemList,
            'pageHtml' => $pageHtml,
        );
        $this->assign($data);
        $this->display();
    }

    /**
     * 添加内容
     */
    public function itemInfo()
    {
        $itemObj = D('Item');
        if(empty($_POST)){
            $id = $this->_get('id', 'intval');
            if(!empty($id)){
                //更新显示
                $itemInfo = $itemObj->getInfoById($id);
                $itemInfo = $itemObj->format($itemInfo, array('cover_name'));
                $parent_id = $itemInfo['parent_id'];
                $this->assign('itemInfo', $itemInfo);
                $this->assign('extList', D('Ext')->getExtList('item', $itemInfo['id']));
            }else{
                //添加显示
                $parent_id = $this->_get('parent_id', 'intval');
            }
            $this->assign('getExtValueList', U('Home/Ext/getExtValueList'));
            $this->assign('parent_id', $parent_id);
            $this->assign('tplList', D('ThemeTpl')->getTplList());
            $this->assign('infoUrl', U('Home/Item/itemInfo'));
            $this->assign('extUrl', U('Home/Ext/extList'));
            $this->display();
            exit;
        }
        $data = $this->_post('item');
        $data['date_modify'] = time();
		if(!empty($_FILES['pic']['name'])){
			$picList = uploadPic();
			if($picList['code'] != 'error'){
				$data['cover'] = D('GalleryMeta')->addImg($picList['pic']['savename']);
			}
		}
        $item_id = $data['id'];
        if(empty($item_id)){
            //添加操作
            $data['user_id'] = $_SESSION['uid'];
            $data['date_add'] = time();
            $item_id = $itemObj->add($data);
        }else{
            //更新操作
            $itemObj->save($data);
        }
        //增值属性操作
        $extValData = $_POST['ext'];
        D('ExtVal')->updateExtVal($extValData, $item_id);
        $this->success('操作成功');
    }

    /**
     * 删除
     */
    public function del()
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
		$where['id'] = array('in', $delIds);
        $where['parent_id'] = array('in', $delIds);
        $where['_logic'] = 'or';
        $map['_complex'] = $where;
		D('Item')->where($map)->delete();
		$this->success('删除成功');
    }
}
