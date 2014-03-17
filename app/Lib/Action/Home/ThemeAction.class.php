<?php
/**
 * File Name: ThemeAction.class.php
 * Author: chen
 * Created Time: 2013-11-21 13:49:38
*/
class ThemeAction extends HomeAction{
	/**
	 * 首页方法
	 */
	public function themeList(){
		$themeObj = D('Theme');
		$arrField = array('*');

        //search
        $search = $this->_post('search');
        if(!empty($search)){
            $arrMap['name'] = array('like', '%'.$search.'%');
        }
        $arrMap['status'] = array('eq', 1);
		$arrOrder = array('date_modify desc');
		$count = $themeObj->getCount($arrMap);
		$page = page($count);
		$pageHtml = $page->show();
		$themeList = $themeObj->getList($arrField, $arrMap, $arrOrder, $page->firstRow, $page->listRows);
		$arrFormatField = array('cover_name');
		foreach($themeList as $k=>$v){
			$themeList[$k] = $themeObj->format($v, $arrFormatField);
		}
		$tplData = array(
			'addUrl' => U('Home/Theme/add'),
			'useUrl' => U('Home/Theme/toUse'),
            'tplUrl' => U('Home/Theme/tplList'),
			'editUrl' => U('Home/Theme/edit'),
			'delUrl' => U('Home/Theme/del'),
			'pageHtml' => $pageHtml,
			'themeList' => $themeList,
		);
		$this->assign($tplData);
		$this->display();
	}

	/**
	 * 使用主题
	 */
	public function toUse(){
		$siteObj = D('Setting');
		$id = intval($this->_get('id'));
        $arrMap['user_id'] = array('eq', $_SESSION['uid']);
		if($siteObj->where($arrMap)->setField('theme_id', $id)){
			$url = U('Home/Item/setting');
			$this->success('使用主题成功', $url);
		}else{
			$this->error('使用主题失败');
		}
	}
    /**
     * 添加主题
     */
    public function add()
    {
        $data = $this->_post();
        if(empty($data)){
            $this->assign('addUrl', U('Home/Theme/add'));
            $this->display();
            exit;
        }
        $themeObj = D('Theme');
        if(!empty($_FILES)){
            $picList = uploadPic();
            if($picList['code'] != 'error'){
                if(!empty($picList['pic']['savename'])){
                    $data['cover'] = $picList['pic']['savename'];
                }
            }
        }
        $data['date_add'] = $data['date_modify'] = time();
        $themeObj->add($data);
        $this->success('添加成功', U('Home/Theme/themeList'));
    }

    /**
     * 更新
     */
    public function edit()
    {
        $data = $this->_post();
        $themeObj = D('Theme');
        if(empty($data)){
            $id = $this->_get('id', 'intval');
            $themeInfo = $themeObj->getInfoById($id);
            $themeInfo = $themeObj->format($themeInfo, array('cover_name'));
            $this->assign('editUrl', U('Home/Theme/edit'));
            $this->assign('themeInfo', $themeInfo);
            $this->display();
            exit;
        }
        if(!empty($_FILES)){
            $picList = uploadPic();
            if($picList['code'] != 'error'){
                if(!empty($picList['pic']['savename'])){
                    $data['cover'] = $picList['pic']['savename'];
                }
            }
        }
        $data['date_modify'] = time();
        if($themeObj->save($data)){
            $this->success('更新成功');
        }else{
            $this->error('更新失败');
        }
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
		D('Theme')->where($map)->delete();
		$this->success('删除成功');
    }

    /*******************模版管理*******************/
    /**
     * template list
     */
    public function tplList()
    {
        $id = $this->_get('id', 'intval');
        $theme_name = D('Theme')->where('id='.$id)->getField('name');

        $tplObj = D('ThemeTpl');
        $arrField = array();
        $arrMap['theme_id'] = array('eq', $id);
        $search = $this->_post('search');
        if(!empty($search)){
            $arrMap['name'] = array('like', '%'.$search.'%');
        }
        $arrOrder = array('sort_order');
        $tplList = $tplObj->getList($arrField, $arrMap, $arrOrder);
        $arrFormatField = array('status_name');
        foreach($tplList as $k=>$v){
            $tplList[$k] = $tplObj->format($v, $arrFormatField);
        }
        $data = array(
            'theme_name' => $theme_name,
            'tplList' => $tplList,
            'addUrl' => U('Home/Theme/addTpl', array('theme_id'=>$id)),
            'editUrl' => U('Home/Theme/editTpl'),
            'delUrl' => U('Home/Theme/delTpl'),
        );
        $this->assign($data);
        $this->display();
    }

    /**
     * add the new template
     */
    public function addTpl()
    {
        $data = $this->_post();
        if(empty($data)){
            $theme_id = $this->_get('theme_id', 'intval');
            $this->assign('theme_id', $theme_id);
            $this->assign('addUrl', U('Home/Theme/addTpl'));
            $this->display();
            exit;
        }
        $data['date_add'] = $data['date_modify'] = time();
        if(D('ThemeTpl')->add($data)){
            $this->success('添加成功');
        }else{
            $this->error('添加失败');
        }
    }

    /**
     * update the template 
     */
    public function editTpl()
    {
        $tplObj = D('ThemeTpl');
        $data = $this->_post();
        if(empty($data)){
            $id = $this->_get('id', 'intval');
            $tplInfo = $tplObj->where('id='.$id)->find();
            $this->assign('tplInfo', $tplInfo);
            $this->assign('editUrl', U('Home/Theme/editTpl'));
            $this->display();
            exit;
        }
        $data['date_modify'] = time();
        if($tplObj->save($data)){
            $this->success('更新成功');
        }else{
            $this->error('更新失败');
        }
    }

    /**
     * del the template
     */
    public function delTpl()
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
		D('ThemeTpl')->where($map)->delete();
		$this->success('删除成功');
    }


}
 
