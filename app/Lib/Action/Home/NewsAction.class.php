<?php
/**
 * File Name: PushAction.class.php
 * Author: chen
 * Created Time: 2013-11-9 14:23:18
*/
class NewsAction extends HomeAction{
	/**
	 * 回复图文消息素材列表
	 */
	public function newsList(){
        /*
        //实例化模型
		$newsObj = D('News');
        //设置选项
		$arrField = array('*');
		$arrMap['user_id'] = array('eq', $_SESSION['uid']);
		$arrOrder = array();
        //分页
		$count = $newsObj->getCount($arrMap);
		$page = page($count, 10);
		$pageHtml = $page->show();
        //获取图文列表
		$newsList = $newsObj->getList($arrField, $arrMap, $arrOrder, $page->firstRow, $page->listRows);
        //对列表数据进行格式化
		$arrFormatField = array('cover_name', 'keyword', 'mtime_text');
		foreach ($newsList as $k=>$v){
			$newsList[$k] = $newsObj->format($v, $arrFormatField);
		}
        //模板赋值
		$tplData = array( 
			'addUrl'   => U('Admin/News/addNews'),
			'editUrl'  => U('Admin/News/editNews'),
			'delUrl'   => U('Admin/News/doDelNews'),
            'newsList' => $newsList,
			'pageHtml' => $pageHtml,
		);
         */
		$this->assign($tplData);
		$this->display();
	}

	/**
	 * 页面：添加图文素材
	 */
	public function addNews(){
		$tplData = array(
			'addUrl' => U('Admin/News/doAddNews'),
            'left_current' => 'news',
		);
		$this->assign($tplData);
		$this->display();
	}

	/**
	 * 操作：添加图文素材
	 */
	public function doAddNews(){
        //实例化模型
		$newsObj = D('PushNews');
        //获取post数据
		$insert = $this->_post();

        //判断关键字是否可用
        if(!D('PushRoute')->checkKeyword($insert['keyword'])){
            $this->error('关键字不可用');
        }

        //处理图片数据
		if(!empty($_FILES['cover']['name'])){
			$picList = uploadPic();
			$insert['cover'] = $picList['cover']['savename'];
		}
        $insert['wechat_id'] = $_SESSION['wechat_id'];
		$insert['content'] = htmlspecialchars_decode(stripslashes($insert['content']));
		$insert['ctime'] = $insert['mtime'] = time();
        //获取图文ID
		$id = $newsObj->add($insert);
		if($id){
            if(empty($insert['url'])){
                //添加route数据
                D('PushRoute')->addRoute('pushNews', $id, $insert['keyword']);
                $url = U('Admin/News/newsList');
                $this->success('添加成功', $url);
            }else{
		        $this->error('添加失败');
            }
        }
    }

    /**
	 * 页面：编辑图文
	 */
	public function editNews(){
        //实例化模型
		$newsObj = D('PushNews');
        //获取图文ID
		$id = intval($this->_get('id'));
        //获取图文信息
		$newsInfo = $newsObj->getInfoById($id);
        //获取格式化后的图文信息
		$newsInfo = $newsObj->format($newsInfo, array('cover_name'));
        //模板赋值
		$tplData = array(
			'editUrl'   => U('Admin/News/doEditNews'),
			'itemInfo'  => $newsInfo,
            'routeInfo' => D('PushRoute')->getRoute('pushNews', $id),
            'left_current' => 'news',
		);
		$this->assign($tplData);
		$this->display();
	}

	/**
	 * 操作：编辑图文素材
	 */
	public function doEditNews(){
        //实例化模型
		$newsObj = D('PushNews');
        //获取图文信息的post数据
		$update = $this->_post();
        //获取route信息的post数据
        $routeInfo = $this->_post('route');

        //判断关键字是否可用
        if(!D('PushRoute')->checkKeyword($routeInfo['keyword'], $routeInfo['id'])){
            $this->error('关键字不可用');
        }

        //处理图文信息的post数据
		if(!empty($_FILES['pic']['name'])){
			$picList = uploadPic();
			$update['cover'] = $picList['pic']['savename'];
		}
		$update['content'] = htmlspecialchars_decode(stripslashes($update['content']));
        $update['mtime'] = time();
        //news表的更新操作
        $newsObj->save($update);
        //route表的更新操作
        D('PushRoute')->editRoute($routeInfo);
		$this->success('编辑成功');
	}

    /**
     * 关注时回复
     */
    public function special(){
        /*
        //获取特殊回复类型名称
        $keyword = $this->_get('keyword');
        //实例化模型
        $newsObj = D('News');
        $arrMap = array(
            'user_id' => $_SESSION['user_id'],
            'keyword'   => $keyword,
        );
        //获取图文ID
        $id = D('Route')->where($arrMap)->getField('obj_id');
        //获取图文信息
        $newsInfo = $newsObj->getInfoById($id);
        $newsInfo = $newsObj->format($newsInfo, array('cover_name'));

        //模板赋值
        $tplData = array(
            'editUrl'  => U('Admin/News/doEditSub', array('keyword'=>$keyword)),
            'itemInfo' => $newsInfo,
            'left_current' => ($keyword == '关注') ? 'sub' : 'none',
            'title' => ($keyword == '关注') ? '关注时回复' : '无匹配回复',
        );
         */
        $this->assign($tplData);
        $this->display();
    }

    /**
     * 特殊回复更新
     */
    public function doEditSub(){
        //获取关键字
        $keyword = $this->_get('keyword');
        //实例化模型
        $newsObj = D('PushNews');
        //获取post数据
        $update = $this->_post();
		if(!empty($_FILES['pic']['name'])){
			$picList = uploadPic();
			$update['cover'] = $picList['pic']['savename'];
		}
        $update['wechat_id'] = $_SESSION['wechat_id'];
        $update['mtime'] = time();
        //如果是更新数据，则执行下列操作
        if(!empty($update['id'])){
            if(empty($update['url'])){
                //设置关注图文链接
                $blue_key = D('UserWechat')->where('id='.$_SESSION['wechat_id'])->getField('blue_key');
                $url = 'http://';
                $url .= $_SERVER['HTTP_HOST'];
                $url .= U('Shenlan/Cat/index', array('blue_key'=>$blue_key));
                $update['url'] = $url;
            }
            if($newsObj->save($update)){
                $this->success('更新成功');
                exit;
            }else{
                $this->error('更新失败');
                exit;
            }
        }else{
            //如果是首次创建，则执行以下操作

            if(empty($update['url'])){
                //设置关注图文链接
                $blue_key = D('UserWechat')->where('id='.$_SESSION['wechat_id'])->getField('blue_key');
                $url = 'http://';
                $url .= $_SERVER['HTTP_HOST'];
                $url .= U('Shenlan/Cat/index', array('blue_key'=>$blue_key));
                $update['url'] = $url;
            }
            $update['ctime'] = time();
            $obj_id = $newsObj->add($update);
            if($obj_id){
                D('PushRoute')->addRoute('pushNews', $obj_id, $keyword);
                $this->success('更新成功');
            }else{
                $this->error('更新失败');
            }
        }
    }

	/**
	 * 图文删除
	 */
	public function doDelNews(){
		$pushObj = D('PushNews');
        //数据
        $delIds = array();
        $postIds = $this->_post('id');
        if (!empty($postIds)) {
            $delIds = $postIds;
        }
        $getId = intval($this->_get('id'));
        if (!empty($getId)) {
            $delIds[] = $getId;
        }
        //删除数据
        if (empty($delIds)) {
            $this->error('请选择您要删除的数据');
        }
		$arrMap['id'] = $arrRouteMap['obj_id'] = array('in', $delIds);
		if($pushObj->where($arrMap)->delete()){
            D('PushRoute')->delRoute('pushNews', $arrRouteMap);
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
	}

    /*********************文字内容管理***********************/
	/**
	 * 文字素材列表
	 */
	public function textList(){
        /*
		$textObj = D('Text');
		$arrField = array('*');
		$arrMap['wechat_id'] = array('eq', $_SESSION['wechat_id']);
        $arrOrder = array('mtime desc');
		$count = $textObj->getCount($arrMap);
		$page = page($count);
		$pageHtml = $page->show();
		$textList = $textObj->getList($arrField, $arrMap, $arrOrder, $page->firstRow, $page->listRows);
		$arrFormatField = array('mtime_text');
		foreach($textList as $k=>$v){
			$textList[$k] = $textObj->format($v, $arrFormatField);
		}
		$textTpl = array(
			'addUrl' => U('Admin/Text/addText'),
			'editUrl' => U('Admin/Text/editText'),
			'delUrl' => U('Admin/Text/doDelText'),
			'pageHtml' => $pageHtml,
			'itemList' => $textList,
            'left_current' => 'text',
		);
         */
		$this->assign($textTpl);
		$this->display();
	}

	/**
	 * 文字素材添加页面
	 */
	public function addText(){
		$tplData = array(
			'addUrl' => U('Admin/Text/doAddText'),
            'left_current' => 'text',
		);
		$this->assign($tplData);
		$this->display();
	}

	/**
	 * 文字素材的添加操作
	 */
	public function doAddText(){
		$textObj = D('PushText');
		$insert = $this->_post();
        $insert['wechat_id'] = $_SESSION['wechat_id'];

        //判断关键字是否可用
        if(!D('PushRoute')->checkKeyword($insert['keyword'])){
            $this->error('关键字不可用');
        }

		$insert['ctime'] = time();
        $id = $textObj->add($insert);
		if($id){
            D('PushRoute')->addRoute('pushText', $id, $insert['keyword']); 
			$url = U('Admin/Text/textList');
			$this->success('添加成功', $url);
		}else{
			$this->error('添加失败');
		}
	}

	/**
	 * 文字素材的编辑页面
	 */
	public function editText(){
		$textObj = D('PushText');
		$id = $this->_get('id');
		$textInfo = $textObj->getInfoById($id);
        $routeInfo = D('PushRoute')->getRoute('pushText', $id);
		$tplData = array(
			'editUrl' => U('Admin/Text/doEditText'),
			'itemInfo' => $textInfo,
            'routeInfo' => $routeInfo,
            'left_current' => 'text',
		);
		$this->assign($tplData);
		$this->display();
	}

	/**
	 * 文字素材的编辑操作
	 */
	public function doEditText(){
		$textObj = D('PushText');
		$update = $this->_post();
        $routeInfo = $this->_post('route');

        //判断关键字是否可用
        if(!D('PushRoute')->checkKeyword($routeInfo['keyword'], $routeInfo['id'])){
            $this->error('关键字不可用');
        }

		$update['mtime'] = time();
		if($textObj->save($update)){
            D('PushRoute')->editRoute($routeInfo);
			$this->success('更新成功');
		}else{
			$this->error('更新失败');
		}
	}

	/**
	 * 文字素材的删除操作
	 */
	public function doDelText(){
		$textObj = D('PushText');
        //数据
        $delIds = array();
        $postIds = $this->_post('id');
        if (!empty($postIds)) {
            $delIds = $postIds;
        }
        $getId = intval($this->_get('id'));
        if (!empty($getId)) {
            $delIds[] = $getId;
        }
        //删除数据
        if (empty($delIds)) {
            $this->error('请选择您要删除的数据');
        }
		$arrMap['id'] = $arrRouteMap['obj_id'] = array('in', $delIds);
		if($textObj->where($arrMap)->delete()){
            D('PushRoute')->delRoute('pushText', $arrRouteMap);
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
	}


}
