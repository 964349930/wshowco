<?php
/**
 * Tab manage model
 * @author chen
 * @version 2014-03-29
 */
class TabAction extends HomeAction
{
    /**
     * Tab list
     */
    public function tabList()
    {
        $parent_id = $this->_get('parent_id', 'intval');
        $tabObj = D('Tab');
        $arrField = array();
        if(empty($parent_id)){
            $parent_id = 0;
        }
        $arrMap['parent_id'] = array('eq', $parent_id);
        $arrOrder = array('sort_order');
        $tabList = $tabObj->getList($arrField, $arrMap, $arrOrder);
        $data = array(
            'parent_id' => $parent_id,
            'tabList' => $tabList,
            'tabInfoUrl' => U('Home/Tab/tabInfo'),
            'subListUrl' => U('Home/Tab/tabList'),
            'tabDelUrl' => U('Home/Tab/tabDel'),
        );
        $this->assign($data);
        $this->display();
    }

    /**
     * tab info
     */
    public function tabInfo()
    {
        $tabObj = D('Tab');
        if(empty($_POST)){
            $tab_id = $this->_get('tab_id', 'intval');
            if(!empty($tab_id)){
                $tabInfo = $tabObj->getInfoById($tab_id);
                $parent_id = $tabInfo['parent_id'];
                $this->assign('tabInfo', $tabInfo);
            }else{
                $parent_id = $this->_get('parent_id', 'intval');
            }
            $this->assign('parent_id', $parent_id);
            $this->assign('tabInfoUrl', U('Home/Tab/tabInfo'));
            $this->display();
            exit;
        }
        $data = $this->_post();
        $data['date_modify'] = time();
        if(empty($data['id'])){
            $data['date_add'] = time();
            $tabObj->add($data);
        }else{
            $tabObj->save($data);
        }
        $this->success('操作成功');
    }

    /**
     * tab del
     */
    public function tabDel()
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
		D('Tab')->where($map)->delete();
		$this->success('删除成功');
    }
}
