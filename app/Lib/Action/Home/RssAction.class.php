<?php
/**
 *  RSS 订阅回复 控制器
 *  @author chen
 *  @version 2014-03-31
 */
class RssAction extends HomeAction
{
    /**
     * rss list
     */
    public function rssList()
    {
        $rssObj = D('WechatRss');
        $arrField = array();
        $arrMap['user_id'] = array('eq', $_SESSION['uid']);
        $arrOrder = array();
        $rssList = $rssObj->getList($arrField, $arrMap, $arrOrder);
        foreach($rssList as $k=>$v){
            $routeInfo = D('WechatRoute')->getRoute('rss', $v['id']);
            $rssList[$k]['keyword'] = $routeInfo['keyword'];
        }
        $data = array(
            'rssList' => $rssList,
            'current' => 'rss_list',
            'breadcrumbs' => $this->breadcrumbs,
        );
        $this->assign($data);
        $this->display();
    }

    /**
     * rssInfo
     */
    public function rssInfo()
    {
        $rssObj = D('WechatRss');
        if(empty($_POST)){
            $rss_id = $this->_get('id', 'intval');
            if(!empty($rss_id)){
                $this->assign('rssInfo', $rssObj->getInfoById($rss_id));
                $this->assign('routeInfo', D('WechatRoute')->getRoute('rss', $rss_id));
            }
            $this->breadcrumbs['1'] = array('title' => 'RSS回复列表','url' => U('Rss/rssList'));
            $this->assign('breadcrumbs', $this->breadcrumbs);
            $this->assign('current', 'rss_list');
            $this->display();
            exit;
        }
        $data = $this->_post('rss');
        $route = $this->_post('route');
        if(!is_numeric($data['count'])){
            echo json_encode(array('code'=>'0','msg'=>'请输入数字'));exit;
        }elseif(($data['count'] < 1) OR ($data['count'] > 8)){
            echo json_encode(array('code'=>'0','msg'=>'数字应在1-8之间'));exit;
        }
        if(!D('WechatRoute')->checkKeyword($route['keyword'], $data['id'])){
            echo json_encode(array('code'=>'0','msg'=>'关键字不可用'));exit;
        }
        $data['date_modify'] = time();
        $data['url'] = htmlspecialchars_decode($data['url']);
        if(empty($data['id'])){
            $data['user_id'] = $_SESSION['uid'];
            $data['date_add'] = time();
            $obj_id = $rssObj->add($data);
        }else{
            $rssObj->save($data);
            $obj_id = $data['id'];
        }
        if(!empty($obj_id)){
            D('WechatRoute')->updateRoute('rss', $obj_id, $route);
            echo json_encode(array('code'=>'1','msg'=>'操作成功'));
        }else{
            echo json_encode(array('code'=>'0','msg'=>'操作失败'));
        }
    }

    /**
     * 删除
     */
    public function rssDel()
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
		$map['id'] = $routeMap['obj_id'] = array('in', $delIds);
        D('WechatRoute')->delRoute('rss', $routeMap);
        if(D('WechatRss')->where($map)->delete()){
            echo json_encode(array('code'=>'1','msg'=>'删除成功'));
        }else{
            echo json_encode(array('code'=>'0','msg'=>'删除失败'));
        }
    }
}
