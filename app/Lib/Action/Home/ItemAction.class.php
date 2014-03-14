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
        $this->display();
    }

    /**
     * 内容列表
     */
    public function itemList()
    {
        $itemObj = D('Item');
        $id = $this->_get('id', 'intval');
        $arrField = array();
        if(empty($id)){$id = 0;}
        $arrMap['parent_id'] = array('eq', $id);
        $arrOrder = array();
        $itemList = $itemObj->getList($arrField, $arrMap, $arrOrder);
        $arrFormatField = array('cover_name');
        foreach($itemList as $k=>$v){
            $itemList[$k] = $itemObj->format($v, $arrFormatField);
        }
        $data = array(
            'addUrl'   => U('Home/Item/add'),
            'editUrl'  => U('Home/Item/edit'),
            'delUrl'   => U('Home/Item/del'),
            'subUrl'   => U('Home/Item/itemList'),
            'itemList' => $itemList,
            'id'       => $id,
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
        $this->display();
    }
}
