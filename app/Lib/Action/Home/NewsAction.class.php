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
     * special push action
     */
    public function special(){
        $meta = $this->_post();
        if(empty($meta)){
            $keyword = $this->_get('keyword', 'trim');
            $routeInfo = D('Route')->where("user_id=".$_SESSION['uid']." AND keyword='".$keyword."'")->find();
            if(!empty($routeInfo)){
                $metaInfo = D('NewsMeta')->where('id='.$routeInfo['obj_id'])->find();
                $this->assign('route_id', $routeInfo['id']);
                $this->assign('news_id', $routeInfo['news_id']);
                $this->assign('metaInfo', $metaInfo);
            }
            $this->assign('keyword', $keyword);
            $this->assign('editUrl', U('Home/News/special'));
            $this->display();
            exit;
        }
        $news_id = $this->updateNews();
        $this->updateRoute($route, $news_id);
        $this->updateMeta($meta, $news_id);
    }
    /**
     * update the news action
     */
    private function updateNews()
    {
        $news['user_id'] = $_SESSION['uid'];
        $news['date_modify'] = time();
        if(empty($data['id'])){
            $news['date_add'] = time();
            $news_id = D('News')->add($data);
        }else{
            $news_id = D('News')->save($data);
        }
        return $news_id;
    }

    /**
     * update the route action
     */
    private function updateRoute()
    {
        $route['obj_type'] = 'news';
        $route['obj_id'] = $news_id;
        $route['user_id'] = $_SESSION['user_id'];
        $route['keyword'] = $keyword;
        $route['date_modify'] = time();
        if(empty($route)){
            $route['date_add'] = time();
            $result = D('Route')->add($route);
        }else{
            $result = D('Route')->save($route);
        }
        return $result;
    }

    /**
     * update the meta action
     */
    private function updateMeta($data, $news_id)
    {
        $meta['news_id'] = $news_id;
        $meta['date_modify'] = time();
        if(empty($meta['id'])){
            $meta['date_add'] = time();
            $result = D('NewsMeta')->add($meta);
        }else{
            $result = D('NewsMeta')->save($meta);
        }
        return $result;
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
		$textObj = D('Text');
		$arrField = array('*');
		$arrMap['user_id'] = array('eq', $_SESSION['user_id']);
        $arrOrder = array('date_modify desc');
		$count = $textObj->getCount($arrMap);
		$page = page($count);
		$pageHtml = $page->show();
		$textList = $textObj->getList($arrField, $arrMap, $arrOrder, $page->firstRow, $page->listRows);
		$textTpl = array(
			'addUrl' => U('Home/Text/add'),
			'editUrl' => U('Home/Text/edit'),
			'delUrl' => U('Home/Text/del'),
			'pageHtml' => $pageHtml,
			'textList' => $textList,
		);
		$this->assign($textTpl);
		$this->display();
	}

	/**
	 * 文字素材添加页面
	 */
	public function add(){
        $data = $this->_post();
        if(empty($data)){
            $this->assign('addUrl', U('Home/News/add'));
            $this->display();
            exit;
        }
        $data['date_add'] = $data['date_modify'] = time();
        if(D('Text')->add($data)){
            $this->success('success');
        }else{
            $this->error('error');
        }
	}

	/**
	 * 文字素材的编辑页面
	 */
	public function edit(){
        $data = $this->_post();
   		$textObj = D('Text');
        if(empty($data)){
            $id = $this->_get('id', 'intval');
            $textInfo = $textObj->where('id='.$id)->find();
            $this->assign('textInfo', $textInfo);
            $this->display();
            exit;
        }
        $data['date_modify'] = time();
        if(D('Text')->save($data)){
            $this->success('success');
        }else{
            $this->error('error');
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
