<?php
/**
 * 微信功能控制器
 * @author chen
 * @version 2014-03-19
 */
class WechatAction extends HomeAction
{
    /**
     * 模拟函数
     */
    public function sim()
    {
        /*
        $data = '公交济南k308';
        $data = csubstr($data, 6);
        print_r($data);
        preg_match('/[\x{4e00}-\x{9fa5}]+/u', $data, $result);
        print_r($result);exit;*/
        if(empty($_POST)){
            $xml = '<xml>
<ToUserName><![CDATA[ccms]]></ToUserName>
<FromUserName><![CDATA[chanmo]]></FromUserName> 
<CreateTime>1348831860</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[测试]]></Content>
<MsgId>1234567890123456</MsgId>
</xml>';
            $this->assign('testUrl', 'http://'.$_SERVER['HTTP_HOST'].U('Home/Wx/wxapi', array('user'=>$_SESSION['userInfo']['name'])));
            $this->assign('testXml', $xml);
            $this->assign('url', U('Home/Wechat/sim'));
            $this->display();
            exit;
        }
        $url = $_POST['url'];
        $xml = $_POST['xml'];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
		curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);
        $this->assign('testUrl', $url);
        $this->assign('testXml', $xml);
        $this->assign('result', htmlspecialchars($result));
        $this->display();
    }

    /**
     * 禁忌关键字管理
     */
    public function keywordList()
    {
        $routeObj = D('WechatRoute');
        $arrField = array();
        $arrMap['obj_type'] = array('eq', 'common');
        $arrOrder = array('id');
        $page = page($routeObj->getCount($arrMap));
        $keywordList = $routeObj->getList($arrField, $arrMap, $arrOrder, $page->firstRow, $page->listRows);
        $data = array(
            'infoUrl' => U('Home/Wechat/info'),
            'delUrl' => U('Home/Wechat/del'),
            'keywordList' => $keywordList,
            'pageHtml' => $page->show(),
        );
        $this->assign($data);
        $this->display();
    }

    /**
     * 关键字信息
     */
    public function info()
    {
        $wechatObj = D('WechatRoute');
        if(empty($_POST)){
            $id = $this->_get('id', 'intval');
            if(empty($id)){
                $this->assign('infoUrl', U('Home/Wechat/info'));
                $this->display();
                exit;
            }
            $info = $wechatObj->getInfoById($id);
            $this->assign('info', $info);
            $this->assign('infoUrl', U('Home/Wechat/info'));
            $this->display();
            exit;
        }
        $data = $this->_post();
        $data['date_modify'] = time();
        if(empty($data['id'])){
            $data['obj_type'] = 'common';
            $data['obj_id'] = '0';
            $data['date_add'] = time();
            $wechatObj->add($data);
        }else{
            $wechatObj->save($data);
        }
        $this->success('操作成功');
    }

    /**
     * 关键字删除
     */
    public function del()
    {
		$routeObj = D('WechatRoute');
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
		$arrMap['id'] = array('in', $delIds);
		if($routeObj->where($arrMap)->delete()){
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
    }

}
