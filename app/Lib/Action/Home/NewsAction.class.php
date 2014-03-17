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
		$newsObj = D('News');
		$arrField = array('*');
		$arrMap['user_id'] = array('eq', $_SESSION['uid']);
		$arrOrder = array('date_modify desc');
		$count = $newsObj->getCount($arrMap);
		$page = page($count, 10);
		$pageHtml = $page->show();
		$newsList = $newsObj->getList($arrField, $arrMap, $arrOrder, $page->firstRow, $page->listRows);
		$arrFormatField = array('keyword');
		foreach ($newsList as $k=>$v){
			$newsList[$k] = $newsObj->format($v, $arrFormatField);
		}
		$tplData = array( 
			'addUrl'   => U('Home/News/newsInfo'),
            'subUrl'   => U('Home/News/metaList'),
			'editUrl'  => U('Home/News/newsInfo'),
			'delUrl'   => U('Home/News/delNews'),
            'newsList' => $newsList,
			'pageHtml' => $pageHtml,
		);
		$this->assign($tplData);
		$this->display();
	}

	/**
	 * 页面：添加图文素材
	 */
	public function newsInfo(){
        if(empty($_POST)){
            $id = $this->_get('id', 'intval');
            if(!empty($id)){
                $routeInfo = D('Route')->where("obj_type='news' AND obj_id=".$id)->find();
                $this->assign('newsInfo', D('News')->getInfoById($id));
                $this->assign('routeInfo', $routeInfo);
            }
            $this->assign('editUrl', U('Home/News/newsInfo'));
            $this->display();
            exit;
        }
        $news = $this->_post('news');
        $route = $this->_post('route');
        if(!D('Route')->checkKeyword($route['keyword'], $news['id'])){
            $this->error('关键字不可用');
        }
        $news_id = D('News')->updateNews($news);
        D('Route')->updateRoute('news', $news_id, $route);
	    $this->success('操作成功');	
	}

    /**
     * special push action
     */
    public function special(){
        if(empty($_POST)){
            $keyword = $this->_get('keyword', 'trim');
            $routeInfo = D('Route')->where("obj_type='news' AND keyword='".$keyword."'")->find();
            if(!empty($routeInfo)){
                $metaInfo = D('NewsMeta')->where('id='.$routeInfo['obj_id'])->find();
                $metaInfo = D('NewsMeta')->format($metaInfo, array('cover_name'));
                $this->assign('routeInfo', $routeInfo);
                $this->assign('newsInfo', D('News')->getInfoById($routeInfo['obj_id']));
                $this->assign('metaInfo', $metaInfo);
            }
            $this->assign('keyword', $keyword);
            $this->assign('editUrl', U('Home/News/special'));
            $this->display();
            exit;
        }
        $news = $this->_post('news');
        $meta = $this->_post('meta');
        $route = $this->_post('route');
		if(!empty($_FILES['pic']['name'])){
			$picList = uploadPic();
			if($picList['code'] != 'error'){
				$meta['cover'] = $picList['pic']['savename'];
			}
		}
        $news_id = D('News')->updateNews($news);
        D('Route')->updateRoute('news', $news_id, $route);
        D('NewsMeta')->updateMeta($meta, $news_id);
        $this->success('操作成功');
    }

	/**
	 * 图文删除
	 */
	public function delNews(){
		$newsObj = D('News');
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
		$arrMap['id'] = $arrRouteMap['obj_id'] = $arrMetaMap['news_id'] = array('in', $delIds);
		if($newsObj->where($arrMap)->delete()){
            D('Route')->delRoute('news', $arrRouteMap);
            D('NewsMeta')->where($arrMetaMap)->delete();
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
	}

    /*********************子图文内容管理*********************/
    /**
     * meta list
     */
    public function metaList()
    {
        $id = $this->_get('id', 'intval');
        $metaObj = D('NewsMeta');
        $arrField = array('*');
        $arrMap['news_id'] = array('eq', $id);
        $arrOrder = array('sort_order');
        $metaList = $metaObj->getList($arrField, $arrMap, $arrOrder);
        $arrFormatField = array('cover_name');
        foreach($metaList as $k=>$v){
            $metaList[$k] = $metaObj->format($v, $arrFormatField);
        }
        $data = array(
            'addUrl' => U('Home/News/metaInfo', array('news_id'=>$id)),
            'editUrl' => U('Home/News/metaInfo'),
            'delUrl' => U('Home/News/delMeta'),
            'metaList' => $metaList,
        );
        $this->assign($data);
        $this->display();
    }

    /**
     * meta update
     */
    public function metaInfo()
    {
        $metaObj = D('NewsMeta');
        if(empty($_POST)){
            $id = $this->_get('id', 'intval');
            $news_id = $this->_get('news_id', 'intval');
            if(!empty($id)){
                $metaInfo = $metaObj->getInfoById($id);
                $metaInfo = $metaObj->format($metaInfo, array('cover_name'));
                $news_id = $metaInfo['news_id'];
                $this->assign('metaInfo', $metaInfo);
            }
            $this->assign('news_id', $news_id);
            $this->assign('editUrl', U('Home/News/metaInfo'));
            $this->display();
            exit;
        }
        $meta = $this->_post('meta');
		if(!empty($_FILES['pic']['name'])){
			$picList = uploadPic();
			if($picList['code'] != 'error'){
				$meta['cover'] = $picList['pic']['savename'];
			}
		}
        D('NewsMeta')->updateMeta($meta, $meta['news_id']);
        $this->success('操作成功');
    }

	/**
	 * zi图文删除
	 */
	public function delMeta(){
		$metaObj = D('NewsMeta');
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
		$arrMap['id'] = $arrRouteMap['obj_id'] = $arrMetaMap['news_id'] = array('in', $delIds);
		if($metaObj->where($arrMap)->delete()){
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
		$arrMap['user_id'] = array('eq', $_SESSION['uid']);
        $arrOrder = array('date_modify desc');
		$count = $textObj->getCount($arrMap);
		$page = page($count);
		$pageHtml = $page->show();
		$textList = $textObj->getList($arrField, $arrMap, $arrOrder, $page->firstRow, $page->listRows);
        $arrFormatField = array('keyword');
        foreach($textList as $k=>$v){
            $textList[$k] = D('Text')->format($v, $arrFormatField);
        }
		$textTpl = array(
			'addUrl' => U('Home/News/textInfo'),
			'editUrl' => U('Home/News/textInfo'),
			'delUrl' => U('Home/News/delText'),
			'pageHtml' => $pageHtml,
			'textList' => $textList,
		);
		$this->assign($textTpl);
		$this->display();
	}

	/**
	 * 文字素材添加页面
	 */
	public function textInfo(){
        $textObj = D('Text');
        if(empty($_POST)){
            $id = $this->_get('id', 'intval');
            if(!empty($id)){
                $this->assign('textInfo', $textObj->getInfoById($id));
                $this->assign('routeInfo', D('Route')->getRoute('text', $id));
            }
            $this->assign('addUrl', U('Home/News/textInfo'));
            $this->display();
            exit;
        }
        $text = $this->_post('text');
        $route = $this->_post('route');
        if(!D('Route')->checkKeyword($route['keyword'], $text['id'])){
            $this->error('关键字不可用');
        }
        $obj_id = D('Text')->updateText($text);
        D('Route')->updateRoute('text', $obj_id, $route);
        $this->success('提交成功');

	}

	/**
	 * 文字素材的删除操作
	 */
	public function delText(){
		$textObj = D('Text');
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
            D('Route')->delRoute('text', $arrRouteMap);
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
	}
}
