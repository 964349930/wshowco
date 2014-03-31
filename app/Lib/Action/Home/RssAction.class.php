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
            'rssInfoUrl' => U('Home/Rss/rssInfo'),
            'rssDelUrl' => U('Home/Rss/rssDel'),
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
            $rss_id = $this->_get('rss_id', 'intval');
            if(!empty($rss_id)){
                $this->assign('rssInfo', $rssObj->getInfoById($rss_id));
                $this->assign('routeInfo', D('WechatRoute')->getRoute('rss', $rss_id));
            }
            $this->assign('rssInfoUrl', U('Home/Rss/rssInfo'));
            $this->display();
            exit;
        }
        $data = $this->_post('rss');
        $route = $this->_post('route');
        if(!is_numeric($data['count'])){
            $this->error('请输入数字');
        }elseif(($data['count'] < 1) OR ($data['count'] > 8)){
            $this->error('数字应在1到8之间');
        }
        if(!D('WechatRoute')->checkKeyword($route['keyword'], $data['id'])){
            $this->error('关键字不可用');
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
        D('WechatRoute')->updateRoute('rss', $obj_id, $route);
        $this->success('操作成功');
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
		D('WechatRss')->where($map)->delete();
		$this->success('删除成功');
    }
}
