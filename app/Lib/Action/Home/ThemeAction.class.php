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
			'useUrl' => U('Home/Theme/toUse'),
            'tplListUrl' => U('Home/Theme/tplList'),
            'themeInfoUrl' => U('Home/Theme/themeInfo'),
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
     * 更新
     */
    public function themeInfo()
    {
        $themeObj = D('Theme');
        if(empty($_POST)){
            $theme_id = $this->_get('theme_id', 'intval');
            if(!empty($theme_id)){
                $themeInfo = $themeObj->getInfoById($theme_id);
                $themeInfo = $themeObj->format($themeInfo, array('cover_name'));
                $this->assign('themeInfo', $themeInfo);
            }
            $this->assign('themeInfoUrl', U('Home/Theme/themeInfo'));
            $this->display();
            exit;
        }
        $data = $this->_post();
        $data['date_modify'] = time();
        if(!empty($_FILES)){
            $picList = uploadPic();
            if($picList['code'] != 'error'){
                if(!empty($picList['pic']['savename'])){
                    $data['cover'] = D('GalleryMeta')->addImg($picList['pic']['savename']);
                }
            }
        }
        if(empty($data['id'])){
            $data['date_add'] = time();
            $themeObj->add($data);
        }else{
            $themeObj->save($data);
        }
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
            'addUrl' => U('Home/Theme/tplInfo', array('theme_id'=>$id)),
            'editUrl' => U('Home/Theme/tplInfo'),
            'delUrl' => U('Home/Theme/tplDel'),
        );
        $this->assign($data);
        $this->display();
    }

    /**
     * add the new template
     */
    public function tplInfo()
    {
        $tplObj = D('ThemeTpl');
        if(empty($_POST)){
            $tpl_id = $this->_get('tpl_id', 'intval');
            if(!empty($tpl_id)){
                $tplInfo = $tplObj->getInfoById($tpl_id);
                $theme_id = $tplInfo['theme_id'];
                $this->assign('tplInfo', $tplInfo);
            }else{
                $theme_id = $this->_get('theme_id', 'intval');
            }
            $this->assign('theme_id', $theme_id);
            $this->assign('tplInfoUrl', U('Home/Theme/tplInfo'));
            $this->display();
            exit;
        }
        $data = $this->_post();
        $data['date_modify'] = time();
        if(empty($data['id'])){
            $data['date_add'] = time();
            $tplObj->add($data);
        }else{
            $tplObj->save($data);
        }
        $this->success('操作成功');
    }

    /**
     * del the template
     */
    public function tplDel()
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
 
