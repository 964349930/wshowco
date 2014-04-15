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
        $data = $this->getItemList($this->item_id);
        D('MemberVisit')->add(array('member_id'=>$this->member_id,'item_id'=>$itemInfo['id'],'date_visit'=>time()));
        $this->assign('info', $itemInfo);
        $this->assign('list', $data['list']);
        $this->assign('nav', $this->getNav());
        $this->assign('page', $data['page']);
        $this->display($this->getRelTpl($itemInfo['template_name']));
    }

    /**
     * show the news push content
     */
    public function push()
    {
        $pushInfo = D('WechatNewsMeta')->getInfoById($this->item_id);
        $pushInfo['cover_name'] = getPicPath(D('GalleryMeta')->getImg($pushInfo['cover'], 'm'));
        $pushInfo['intro'] = $pushInfo['description'];
        $pushInfo['info'] = htmlspecialchars_decode($pushInfo['content']);
        $pushInfo['date_add_text'] = date('Y-m-d H:i', $pushInfo['date_add']);

        $this->assign('info', $pushInfo);
        $this->display($this->getRelTpl('detail'));
    }

    /**
     * show the api data
     */
    public function api()
    {
        $id = $this->_get('id', 'intval');
        $article_id = $this->_get('article_id', 'intval');
        $itemInfo = D('Item')->where('id='.$id)->find();
        $url = htmlspecialchars_decode($itemInfo['api']);
        $info = $this->getApiInfo($url, $article_id);
        $data = $this->getApiList($url, $article_id, $info['count']);
        $this->assign('info', $info);
        $this->assign('list', $data['list']);
        $this->assign('nav', $this->getNav());
        $this->assign('page', $data['page']);
        $this->display($this->getRelTpl($info['tpl']));
    }

    /**
     * 标记为喜欢
     */
    public function like()
    {
        $id = D('MemberCol')->add(array('member_id'=>$this->member_id,'item_id'=>$this->item_id,'date_col'=>time()));
        echo $id;
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
        $data['date_msg'] = time();
        $result = D('MemberMsg')->add($data);
        if(!empty($result)){
            $this->success('留言成功');
        }else{
            $this->error('留言失败');
        }
    }
}
