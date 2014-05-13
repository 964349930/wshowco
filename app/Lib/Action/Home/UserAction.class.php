<?php
/**
 * File Name: UserAction.class.php
 * Author: chen
 * Created Time: 2013-11-11 17:45:17
*/
class UserAction extends HomeAction{

	/**
	 * 会员列表
	 */
	public function userList(){
		$userObj = D('User');
		$arrField = array('*');
		$arrMap = array();
		$keyword = $this->_post('keyword');
		if(!empty($keyword)){
			$arrMap['name'] = array('like', '%'.$keyword.'%');
		}
		$arrOrder = array();
		$count = $userObj->getCount($arrMap);
		$page = page($count);
		$pageHtml = $page->show();
		$userList = $userObj->getList($arrField, $arrMap, $arrOrder, $page->firstRow, $page->listRows);
		$arrFormatField = array('group_name', 'avatar_name', 'date_log_text');
		foreach($userList as $k => $v){
			$userList[$k] = $userObj->format($v, $arrFormatField);
		}
		$tplData = array(
            'title' => '用户列表',
            'btn_list' => array(
                array(
                    'title' => '添加用户',
                    'url' => U('User/add'),
                ),
            ),
            'tr_list' => array(
                array('title'=>'用户名','flag'=>'name'),
                array('title'=>'类型','flag'=>'group'),
                array('title'=>'手机号码','flag'=>'mobile'),
                array('title'=>'注册时间','flag'=>'date_reg'),
                array('title'=>'访问时间','flag'=>'date_login')
            ),
            'action_list' => array(
                array(
                    'type' => 'edit',
                    'url' => U('User/info'),
                ),
            ),
            'plugin_list' => array('modal_delete'),
			'user_list' => $userList,
		    'pages' => $pageHtml,
		);
		$this->assign($tplData);
		$this->display();
	}

	/**
	 * 用户生成操作
	 */
	public function add(){
        $data = $this->_post();
        if(empty($data)){
            $this->display();
            exit;
        }
		$userObj = D('User');
		$password = mt_rand();
		$data['password'] = md5($password);
		$data['group_id'] = '2';
        $data['date_reg'] = $data['date_log'] = time();
		$userObj->add($data);
		echo ('用户名:'.$data['name']);
        echo ('<br>');
		echo ('密码:'.$password);
	}

	/**
	 * 会员登录后获取到的自身信息
	 */
	public function basic(){
		$data = $this->_post();
		$userObj = D('User');
        if(empty($data)){
		    $id = $_SESSION['uid'];
		    $userInfo = $userObj->getInfoById($id);
		    $userInfo = $userObj->format($userInfo, array('url', 'avatar_name'));
            $tpl_data = array(
                'title'=>'User basic',
                'url'=>U('User/basic'),
                'list'=>array(
                    array('name'=>'id','type'=>'hidden'),
                    array('title'=>'Name','flag'=>'name','name'=>'name','type'=>'text'),
                    array('title'=>'Avatar','flag'=>'avatar','name'=>'avatar','type'=>'image'),
                    array('title'=>'Phone','flag'=>'mobile','name'=>'mobile','type'=>'tel'),
                    array('title'=>'Url','flag'=>'url','name'=>'url','type'=>'url'),
                    array('title'=>'Token','flag'=>'token','name'=>'flag','type'=>'text'),
                    array('title'=>'APPID','flag'=>'appid','name'=>'appid','type'=>'text'),
                    array('title'=>'APPSECRECT','flag'=>'appsecrect','name'=>'appsecrect','type'=>'text'),
                ),
                'userInfo'=>$userInfo,
            );
            $this->assign($tpl_data);
		    $this->display('Public:info');
            exit;
        }
		if(!empty($_FILES['pic']['name'])){
			$picList = uploadPic();
			if($picList['code'] != 'error'){
				$data['avatar'] = D('GalleryMeta')->addImg($picList['pic']['savename']);
			}
		}
        $result = $userObj->save($data);
        if(empty($result)){
            echo json_encode(array('code'=>'0','msg'=>'更新错误'));
        }else{
            echo json_encode(array('code'=>'1','msg'=>'更新成功'));
        }
	}

    /**
     * 更新密码
     */
	public function password() {
        if(empty($_POST)){
            $this->assign('current', 'user_pwd');
            $this->display();
            exit;
        }
		$userObj = D('User');
		$map['id'] = $_SESSION['uid'];
		$map['password'] = md5($_POST['oldpassword']);
        if(!$userObj->where($map)->find()){
            echo json_encode(array('status'=>'0', 'msg'=>'原始密码输入错误'));
		}else{
            $password = md5($_POST['newpassword']);
            if($userObj->where('id='.$_SESSION['uid'])->setField('password', $password)){
                echo json_encode(array('status'=>'1', 'msg'=>'密码修改成功'));
            }else{
                echo json_encode(array('status'=>'0', 'msg'=>'密码修改失败'));
            }
         }
    }

    /**
     * 删除用户
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
		D('User')->where($map)->delete();
		$this->success('删除成功');
    }

    /*******************分组管理****************************/
    /**
     * group list
     */
    public function groupList()
    {
        $groupObj = D('UserGroup');
        $arrField = array();
        $arrMap = array();
        $arrOrder = array();
        $groupList = $groupObj->getList($arrField, $arrMap, $arrOrder);
        foreach($groupList as $k=>$v){
            $groupList[$k]['count'] = D('User')->getCount(array('group_id'=>$v['id']));
        }
        $data = array(
            'groupList' => $groupList,
            'groupInfoUrl' => U('Home/User/groupInfo'),
        );
        $this->assign($data);
        $this->display();
    }

    /**
     * gruop info
     */
    public function groupInfo()
    {
        $groupObj = D('UserGroup');
        if(empty($_POST)){
            $group_id = $this->_get('group_id', 'intval');
            if(!empty($group_id)){
                $groupInfo = $groupObj->getInfoById($group_id);
                $this->assign('groupInfo', $groupInfo);
            }
            $this->assign('groupInfoUrl', U('Home/User/groupInfo'));
            $this->display();
            exit;
        }
        $data = $this->_post();
        $data['date_modify'] = time();
        if(empty($data['id'])){
            $data['date_add'] = time();
            $groupObj->add($data);
        }else{
            $groupObj->save($data);
        }
        $this->success('操作成功');
    }

}
