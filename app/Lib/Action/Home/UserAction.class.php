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
			'userList' => $userList,
			'addUrl' => U('Home/User/add'),
            'delUrl' => U('Home/User/del'),
		    'pageHtml' => $pageHtml,
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
		    $this->assign('editUrl', U('Home/User/basic'));
            $this->assign('userInfo', $userInfo);
		    $this->display();
            exit;
        }
		if(!empty($_FILES['pic']['name'])){
			$picList = uploadPic();
			if($picList['code'] != 'error'){
				$data['avatar'] = $picList['pic']['savename'];
			}
		}
        $userObj->save($data);
        $this->success('更新成功');
	}

    /**
     * 更新密码
     */
	public function password() {
        if(empty($_POST)){
            $this->assign('editUrl', U('Home/User/password'));
            $this->display();
            exit;
        }
		$userObj = D('User');
		$map['id'] = $_SESSION['uid'];
		$map['password'] = md5($_POST['oldpassword']);
		if(empty($_POST['newpassword']) OR empty($_POST['repassword'])){
			$this->error('密码不能为空');
		}elseif($_POST['newpassword'] !== $_POST['repassword']) {
			$this->error('两次输入的密码不一致');
        }elseif(!$userObj->where($map)->find()){
            $this->error('原始密码输入错误');
		}else{
            $password = md5($_POST['newpassword']);
            $userObj->where('id='.$_SESSION['uid'])->setField('password', $password);
            $this->success('密码修改成功！');
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

} 
