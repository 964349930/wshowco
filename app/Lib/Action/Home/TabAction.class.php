<?php
/**
 * Tab manage model
 * @author chen
 * @version 2014-03-29
 */
class TabAction extends HomeAction
{
    /**
     * set the breadcrumbs
     */
    private function setBCrumbs($id)
    {
        $result = $this->get_ids($id);
        $result = array_reverse($result);
        if(!empty($id)){
            $result = array_merge($result, array($id));
        }
        foreach($result as $k=>$v){
            $this->breadcrumbs[$k+1]['id'] = $v;
            $title = D('Tab')->where('id='.$v)->getField('title');
            $this->breadcrumbs[$k+1]['title'] = ($title) ? $title : '菜单列表';
            $this->breadcrumbs[$k+1]['url'] = U('Tab/tabList', array('parent_id'=>$v));
        }
    }

    /**
     * get parent_id for breadcrumbs
     */
    private function get_ids($id, $i=0)
    {
        $pid[$i] = D('Tab')->where('id='.$id)->getField('parent_id');
        if(!empty($pid[$i])){
            $pid = array_merge($pid, $this->get_ids($pid[$i],$i+1));
        }
        return $pid;
    }

    /**
     * Tab list
     */
    public function tabList()
    {
        $parent_id = intval($_GET['parent_id']);
        if(empty($parent_id)){$parent_id = 0;}
        $map = array('parent_id'=>$parent_id);

        $tab_list = D('Tab')->where($map)->order('sort_order')->select();
        $data = array(
            'breadcrumbs' => D('Tab')->get_bcrumbs($parent_id),
            'parent_id' => $parent_id,
            'tabList' => $tab_list,
            'current' => 'tab_list',
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
            $tab_id = $this->_get('id', 'intval');
            if(!empty($tab_id)){
                $tabInfo = $tabObj->getInfoById($tab_id);
                $parent_id = $tabInfo['parent_id'];
                $this->assign('tabInfo', $tabInfo);
            }else{
                $parent_id = $this->_get('parent_id', 'intval');
            }
            $this->setBCrumbs($parent_id);
            $this->assign('current', 'tab_list');
            $this->assign('breadcrumbs', $this->breadcrumbs);
            $this->assign('parent_id', $parent_id);
            $this->display();
            exit;
        }
        $data = $this->_post();
        $data['date_modify'] = time();
        if(empty($data['id'])){
            $data['date_add'] = time();
            if($tabObj->add($data)){
                echo json_encode(array('code'=>'1','msg'=>'操作成功'));
            }else{
                echo json_encode(array('msg'=>'操作失败'));
            }
        }else{
            if($tabObj->save($data)){
                echo json_encode(array('code'=>'1','msg'=>'操作成功'));
            }else{
                echo json_encode(array('msg'=>'操作失败'));
            }
        }
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
        if(D('Tab')->where($map)->delete()){
            echo json_encode(array('code'=>'1','msg'=>'删除成功'));
        }else{
            echo json_encode(array('msg'=>'删除失败'));
        }
    }
}
