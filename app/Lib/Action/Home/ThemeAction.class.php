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
        $fields = array('id','name','date_modify');
        $page = page(D('Theme')->getCount());
        $theme_list = D('Theme')->field($fields)->order('date_modify desc')->limit($page->firstRow,$page->listRows)->select();

        $fields_all = D('Theme')->field_list();
        $data = array(
            'title' => '主题列表',
            'field_list' => $this->get_field_list($fields_all,$fields),
            'field_info' => $theme_list,
            'page_list' => $page->show(),
        );
		$this->assign($data);
		$this->display('Public:list');
	}

	/**
	 * 使用主题
	 */
	public function toUse(){
		$siteObj = D('Setting');
		$id = intval($this->_get('id'));
        $arrMap['user_id'] = array('eq', $_SESSION['uid']);
		if($siteObj->where($arrMap)->setField('theme_id', $id)){
		}else{
		}
	}

    /**
     * 更新
     */
    public function themeInfo()
    {
        $themeObj = D('Theme');
        if(empty($_POST)){
            $theme_id = $this->_get('id', 'intval');
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
            if($themeObj->add($data)){
                echo json_encode(array('code'=>'1','msg'=>'主题添加成功'));
            }else{
                echo json_encode(array('code'=>'0','msg'=>'主题添加失败'));
            }
        }else{
            if($themeObj->save($data)){
                echo json_encode(array('code'=>'1','msg'=>'主题添加成功'));
            }else{
                echo json_encode(array('code'=>'0','msg'=>'主题添加失败'));
            }
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
 
