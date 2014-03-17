<?php
/**
 * 内容管理类
 * @author chen
 * @version 2014-03-11
 */
class ItemAction extends HomeAction
{
    /**
     * 微网设置
     */
    public function setting()
    {
        $siteObj = D('Setting');
        $data = $this->_post();
        $siteInfo = $siteObj->where('user_id='.$_SESSION['uid'])->find();
        if(empty($data)){
            $siteInfo = $siteObj->format($siteInfo, array('logo_name', 'url', 'theme_name'));
            $this->assign('siteInfo', $siteInfo);
            $this->assign('editUrl', U('Home/Item/setting'));
            $this->display();
            exit;
        }
        if(empty($siteInfo)){
            $data['user_id'] = $_SESSION['uid'];
            if($siteObj->add($data)){
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
        }else{
            if($siteObj->save($data)){
                $this->success('更新成功');
            }else{
                $this->error('更新失败');
            }
        }
    }

    /**
     * 内容列表
     */
    public function itemList()
    {
        $itemObj = D('Item');
        $id = $this->_get('id', 'intval');
        $arrField = array();

        //search
        $search = $this->_post('search');
        if(!empty($search)){
            $arrMap['title'] = array('like', '%'.$search.'%');
        }

        //For the Parent item
        if(empty($id)){$id = 0;}
        $arrMap['user_id'] = array('eq', $_SESSION['uid']);
        $arrMap['parent_id'] = array('eq', $id);
        $arrOrder = array('sort_order');
        $itemList = $itemObj->getList($arrField, $arrMap, $arrOrder);
        $arrFormatField = array('cover_name');
        foreach($itemList as $k=>$v){
            $itemList[$k] = $itemObj->format($v, $arrFormatField);
        }
        $data = array(
            'addUrl'   => U('Home/Item/add', array('id'=>$id)),
            'editUrl'  => U('Home/Item/edit'),
            'delUrl'   => U('Home/Item/del'),
            'subUrl'   => U('Home/Item/itemList'),
            'itemList' => $itemList,
        );
        $this->assign($data);
        $this->display();
    }

    /**
     * 添加内容
     */
    public function add()
    {
        $itemData = $this->_post('item');
        if(empty($itemData)){
            $id = $this->_get('id', 'intval');
            $this->assign('tplList', D('ThemeTpl')->getTplList());
            $this->assign('parent_id', $id);
            $this->assign('addUrl', U('Home/Item/add'));
            $this->display();
            exit;
        }
        $itemObj = D('Item');
		if(!empty($_FILES['pic']['name'])){
			$picList = uploadPic();
			if($picList['code'] != 'error'){
				$itemData['cover'] = $picList['pic']['savename'];
			}
		}
        $itemData['user_id'] = $_SESSION['uid'];
        $itemData['date_add'] = $itemData['date_modify'] = time();
        $id = $itemObj->add($itemData);
        $this->success('添加成功');
    }

    /**
     * 更新
     */
    public function edit()
    {
        $itemObj = D('Item');
        $itemData = $this->_post('item');
        if(empty($itemData)){
            $id = $this->_get('id', 'intval');
            $itemInfo = $itemObj->getInfoById($id);
            $itemInfo = $itemObj->format($itemInfo, array('cover_name'));
            $this->assign('tplList', D('ThemeTpl')->getTplList());
            $this->assign('editUrl', U('Home/Item/edit'));
            $this->assign('itemInfo', $itemInfo);
            $this->display();
            exit;
        }
		if(!empty($_FILES['pic']['name'])){
			$picList = uploadPic();
			if($picList['code'] != 'error'){
				$itemData['cover'] = $picList['pic']['savename'];
			}
		}
        $itemData['date_modify'] = time();
        $itemObj->save($itemData);
        $this->success('更新成功');
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
		$map['id'] = array('in', $delIds);
		D('Item')->where($map)->delete();
		$this->success('删除成功');
    }

    /**
     * Get the sub item id
     */
    private function getSub($ids)
    {
        foreach($ids as $k=>$v){
            $sub_id[] = D('Item')->where('parent_id='.$v)->getField('id');
        }
    }
}
