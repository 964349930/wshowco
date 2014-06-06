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
        if(empty($_POST)){
            $user_id = $_SESSION['uid'];
            $fields = array('id','site_name','tel','address','email','latitude','longitude');
            $siteInfo = $siteObj->field($fields)->where('user_id='.$user_id)->find();
            $siteInfo = $siteObj->format($siteInfo, array('logo_name', 'url', 'theme_name'));
            $galleryList = D('Gallery')->where('user_id='.$user_id)->select();
            $fields_all = $siteObj->field_list();
            $tpl_data = array(
                'title' => '网站设置',
                'form_url' => U('Item/setting'),
                'field_list'=>$this->get_field_list($fields_all, $fields),
                'field_info'=>$siteInfo,
            );
            $this->assign('galleryList', $galleryList);
            $this->assign('siteInfo', $siteInfo);
            $this->assign('settingUrl', U('Home/Item/setting'));
            $this->assign('current', 'site_setting');
            $this->assign($tpl_data);
            $this->display('Public:info');
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
            if($siteObj->add($data)){
                echo json_encode(array('code'=>'1','msg'=>'更新成功'));
            }else{
                echo json_encode(array('code'=>'0','msg'=>'更新失败'));
            }
        }else{
            if($siteObj->save($data)){
                echo json_encode(array('code'=>'1','msg'=>'更新成功'));
            }else{
                echo json_encode(array('code'=>'0','msg'=>'更新失败'));
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

        //For the Parent item
        if(empty($parent_id)){$parent_id = 0;}
        $page = page($itemObj->getCount($arrMap));

        //获取文章列表
        $fields = array('id','title','intro','date_modify');
        $itemList = $itemObj->field()->where('user_id='.$_SESSION['uid'].' AND parent_id='.$parent_id)
            ->order('sort_order')->limit($page->firstRow, $page->listRows)->select();
        foreach($itemList as $k=>$v){
            $itemList[$k]['date_modify'] = date('Y-m-d H:i', $v['date_modify']);
            $itemList[$k]['action_list'] = array(
                array('title'=>'管理子文章','type'=>'ls','url'=>U('Item/itemList',array('parent_id'=>$v['id']))),
                array('title'=>'编辑','type'=>'edit','url'=>U('Item/itemInfo',array('id'=>$v['id']))),
                array('title'=>'删除','type'=>'del','url'=>U('Item/del',array('id'=>$v['id']))),
            );
        }
        
        //设置面包屑导航
        $this->setBCrumbs($parent_id);

        //模板赋值
        $fields[] = 'action_list';
        $fields_all = $itemObj->field_list();
        $data = array(
            'title'=>'文章列表',
            'btn_list'=>array(array('title'=>'添加文章','url'=>U('Item/itemInfo',array('parent_id'=>$parent_id)))),
            'bread_list' => $this->breadcrumbs,
            'field_list' => $this->get_field_list($fields_all, $fields),
            'field_info' => $itemList,
            'plugin_list' => array('Public:modal_delete',),
            //'page_list' => $page->show(),
        );
        $this->assign($data);
        $this->display('Public:list');
    }

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
            $title = D('Item')->where('id='.$v)->getField('title');
            $this->breadcrumbs[$k+1]['title'] = ($title) ? $title : '文章列表';
            $this->breadcrumbs[$k+1]['url'] = U('Item/itemList', array('parent_id'=>$v));
        }
    }

    /**
     * get parent_id for breadcrumbs
     */
    private function get_ids($id, $i=0)
    {
        $pid[$i] = D('Item')->where('id='.$id)->getField('parent_id');
        if(!empty($pid[$i])){
            $pid = array_merge($pid, $this->get_ids($pid[$i],$i+1));
        }
        return $pid;
    }

    /**
     * 添加内容
     */
    public function itemInfo()
    {
        $itemObj = D('Item');
        if(empty($_POST)){
            $id = $this->_get('id', 'intval');
            $fields = array('id','parent_id','title','cover','intro','info','template_id','status');
            if(!empty($id)){

                //更新显示
                $field_info = $itemObj->field()->where('id='.$id)->find();
                $field_info = $itemObj->format($field_info, array('cover_name'));
                $this->assign('extList', D('Ext')->getExtList('item', $itemInfo['id']));
            }else{

                //添加显示
                $field_info['parent_id'] = $this->_get('parent_id', 'intval');
            }

            //面包屑导航
            $this->setBCrumbs($parent_id);
            $this->assign('getExtValueList', U('Home/Ext/getExtValueList'));
            $fields_all = $itemObj->field_list();
            $data = array(
                'title'=>'文章详情',
                'bread_list'=>$this->breadcrumbs,
                'form_url'=>U('Item/itemInfo'),
                'field_info'=>$field_info,
                'field_list'=>$this->get_field_list($fields_all, $fields),
                'plugin_list' => array('Public:imgUpload',),
            );
            $this->assign($data);
            //$this->assign('extUrl', U('Home/Ext/extList'));
            $this->display('Public:info');
            exit;
        }
        $data = $this->_post();
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
            if($item_id = $itemObj->add($data)){
                echo json_encode(array('code'=>'1','msg'=>'添加成功'));
            }else{
                echo json_encode(array('code'=>'0','msg'=>'添加失败'));
            }
        }else{
            //更新操作
            if($itemObj->save($data)){
                echo json_encode(array('code'=>'1','msg'=>'添加成功'));
            }else{
                echo json_encode(array('code'=>'0','msg'=>'添加失败'));
            }
        }
        /*
        //增值属性操作
        $extValData = $_POST['ext'];
        D('ExtVal')->updateExtVal($extValData, $item_id);
        $this->success('操作成功');
         */
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
			echo json_encode(array('code'=>'0','msg'=>'请选择您要删除的数据'));
            exit;
		}
		$where['id'] = array('in', $delIds);
        $where['parent_id'] = array('in', $delIds);
        $where['_logic'] = 'or';
        $map['_complex'] = $where;
		if(D('Item')->where($map)->delete()){
            echo json_encode(array('code'=>'1','msg'=>'删除成功'));
        }else{
            echo json_encode(array('code'=>'0','msg'=>'error'));
        }
    }
}
