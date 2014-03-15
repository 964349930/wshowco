<?php
/**
 * Theme template Action
 * @author chen
 * @version 2014-03-15
 */
class TemplateAction extends HomeAction
{
    /**
     * template list
     */
    public function templateList()
    {
        $templateObj = D('Template');
        $arrField = array();
        $arrMap = array();
        $search = $this->_post('search');
        if(!empty($search)){
            $arrMap['name'] = array('like', '%'.$search.'%');
        }
        $arrOrder = array('sort_order');
        $templateList = $templateObj->getList($arrField, $arrMap, $arrOrder);
        $arrFormatField = array('status_name');
        foreach($templateList as $k=>$v){
            $templateList[$k] = $templateObj->format($v, $arrFormatField);
        }
        $data = array(
            'templateList' => $templateList,
            'searchUrl' => U('Home/Template/templateList'),
            'addUrl' => U('Home/Template/add'),
            'editUrl' => U('Home/Template/edit'),
            'delUrl' => U('Home/Template/del'),
        );
        $this->assign($data);
        $this->display();
    }

    /**
     * add the new template
     */
    public function add()
    {
        $data = $this->_post();
        if(empty($data)){
            $this->assign('addUrl', U('Home/Template/add'));
            $this->display();
            exit;
        }
        $data['date_add'] = $data['date_modify'] = time();
        if(D('Template')->add($data)){
            $this->success('添加成功');
        }else{
            $this->error('添加失败');
        }
    }

    /**
     * update the template 
     */
    public function edit()
    {
        $templateObj = D('Template');
        $data = $this->_post();
        if(empty($data)){
            $id = $this->_get('id', 'intval');
            $templateInfo = $templateObj->where('id='.$id)->find();
            $this->assign('templateInfo', $templateInfo);
            $this->assign('editUrl', U('Home/Template/edit'));
            $this->display();
            exit;
        }
        $data['date_modify'] = time();
        if($templateObj->save($data)){
            $this->success('更新成功');
        }else{
            $this->error('更新失败');
        }
    }

    /**
     * del the template
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
		D('Template')->where($map)->delete();
		$this->success('删除成功');
    }

}
