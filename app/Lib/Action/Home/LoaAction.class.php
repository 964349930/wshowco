<?php
/**
 * limit of authority model
 * @author chen
 * @version 2014-03-31
 */
class LoaAction extends HomeAction
{
    /**
     * loa list
     */
    public function loaList()
    {
        $loaObj = D('Loa');
        $arrField = array();
        $arrMap = array();
        $arrOrder = array('sort_order');
        $loaList = $loaObj->getList($arrField, $arrMap, $arrOrder);
        $data = array(
            'loaList' => $loaList,
            'loaInfoUrl' => U('Home/Loa/loaInfo'),
            'loaDelUrl' => U('Home/Loa/loaDel'),
        );
        $this->assign($data);
        $this->display();
    }

    /**
     * loa info
     */
    public function loaInfo()
    {
        $loaObj = D('Loa');
        if(empty($_POST)){
            $loa_id = $this->_get('loa_id', 'intval');
            if(!empty($loa_id)){
                $loaInfo = $loaObj->getInfoById($loa_id);
                $this->assign('loaInfo', $loaInfo);
            }
            $this->assign('loaInfoUrl', U('Home/Loa/loaInfo'));
            $this->display();
            exit;
        }
        $data = $this->_post();
        $data['date_modify'] = time();
        if(empty($data['id'])){
            $data['date_add'] = time();
            $loaObj->add($data);
        }else{
            $loaObj->save($data);
        }
        $this->success('操作成功');
    }

    /**
     * loa del
     */
    public function loaDel()
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
		D('loa')->where($map)->delete();
		$this->success('删除成功');
    }
}
