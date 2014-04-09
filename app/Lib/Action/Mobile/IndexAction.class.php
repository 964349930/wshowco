<?php
/**
 * 微网站统一控制器
 * @author chen
 * @version 2014-03-03
 */
class IndexAction extends MobileAction
{
    /**
     * 首页控制函数
     */
    public function index()
    {
        $siteInfo = $this->getSiteInfo();
        $this->assign('bannerList', $this->getImgList($siteInfo['banner_id']));
        $this->display(ucfirst($this->theme_name).':index');
    }

    /**
     * 内页控制函数
     */
    public function item()
    {
        $itemInfo = $this->getItemInfo($this->item_id);
        $itemList = $this->getItemList($this->item_id);
        D('MemberEvent')->addEvent($this->member_id, 'view', $this->item_id, $itemInfo['title']);
        $this->assign('info', $itemInfo);
        $this->assign('list', $itemList);
        $this->assign('nav', $this->getNav());
        $this->display($this->getRelTpl($itemInfo['template_name']));
    }

    /**
     * show the news push content
     */
    public function push()
    {
        $pushInfo = D('WechatNewsMeta')->getInfoById($this->item_id);
        $this->assign('info', $pushInfo);
        $this->display($this->getRelTpl('detail'));
    }


    /**
     * 标记为喜欢
     */
    public function like()
    {
        $item_name = D('Item')->where('id='.$this->item_id)->getField('title');
        $result = D('MemberEvent')->addEvent($this->member_id, 'like', $this->item_id, $item_name);
        return $result;
    }

    /**
     * 添加评论操作
     */
    public function message()
    {
        if(empty($this->member_id)){
            $this->error('对不起，请使用微信访问本网站');
            exit;
        }
        $data = $this->_post();
        $data['member_id'] = $this->member_id;
        $data['type'] = '2';    //微网浏览模式
        $data['date_msg'] = time();
        $result = D('MemberMsg')->add($data);
        if(!empty($result)){
            $this->success('留言成功');
        }else{
            $this->error('留言失败');
        }
    }
}
