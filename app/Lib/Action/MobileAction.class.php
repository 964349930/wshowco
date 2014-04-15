<?php
/**
 * File Name: HomeCommonAction.class.php
 * Author: Blue
 * Created Time: 2013-11-15 10:59:09
*/
class MobileAction extends BaseAction
{
    //类属性
    protected $user;
    protected $user_id;
    protected $member_id;
    protected $item_id;
    protected $theme_name;
    private $relTplList;

	/**
	 * 判断用户
	 */
    public function _initialize()
    {
		$this->user = trim($_GET['user']);
        $this->member_id = intval($_GET['member_id']);
        $this->user_id = D('User')->where("name='".$this->user."'")->getField('id');
        $this->theme_name = $this->getThemeName();
        $this->setTplList();
        $this->item_id = intval($_GET['id']);
        $listData = $this->getItemList();
        $data = array(
            'user'          => $this->user,
            'member_id'     => $this->member_id,
            'site'          => $this->getSiteInfo(),
            'menuList'      => $listData['list'],
            'home'          => U('Index/index', array('user'=>$this->user, 'member_id'=>$this->member_id)),
        );
        $this->assign($data);
	}

    /**
     * check link
     */
    private function checkLink()
    {
		if(empty($this->user)){
			echo '对不起，您所访问的站点不存在';
			exit;
		}elseif(empty($this->member_id)){
            echo '对不起，系统无法获取的您的身份信息，请使用微信重新访问';
            exit;
        }elseif(($this->member_id !== $_SESSION['member_id'])
        OR($this->user !== $_SESSION['user'])){
            $_SESSION['member_id'] = $this->member_id;
            $_SESSION['user'] = $this->user;
        }
    }

    /**
     * 获取网站设置信息
     * @return array $siteInfo 网站设置信息
     */
    protected function getSiteInfo()
    {
        $siteInfo = D('Setting')->where('user_id='.$this->user_id)->find();
        $siteInfo['logo'] = getPicPath(D('GalleryMeta')->getImg($siteInfo['logo'], 'm'));
        $siteInfo = D('Setting')->format($siteInfo, array('theme_spell'));
        return $siteInfo;
    }

    /**
     * 获取栏目信息
     * @param int $id
     * @return array $itemInfo
     */
    protected function getItemInfo($id)
    {
		$itemInfo = D('Item')->where('id='.$id)->find();

        /** 使用接口 **/
        if(!empty($itemInfo['api'])){
            $this->redirect('Index/api', array('user'=>$this->user,'member_id'=>$this->member_id,'id'=>$id));exit;
        }
        $itemInfo = D('Item')->format($itemInfo, array('template_name', 'ext'));
        $itemInfo['cover_name'] = getPicPath(D('GalleryMeta')->getImg($itemInfo['cover']), 'm');
        $itemInfo['date_add_text'] = date('Y-m-d H:i', $itemInfo['date_add']);
        $itemInfo['info'] = htmlspecialchars_decode($itemInfo['info']);
        return $itemInfo;
    }

    /**
     * 获取栏目列表
     * @param int $fid 父级栏目ID
     * @return array $catList 栏目列表
     */
    protected function getItemList($parent_id=0)
    {
        $map = array(
            'parent_id' => $parent_id,
            'user_id' => $this->user_id,
            'status' => 1,
        );
        $page = page(D('Item')->getCount($map), 5, 'simple');
        if($parent_id == 0){
            $limit = array();
        }else{
            $limit = array($page->firstRow, $page->listRows);
        }
        $itemList = D('Item')->where($map)->order('sort_order')->limit($limit)->select();
        $arrFormatField = array('ext');
        foreach($itemList as $k=>$v){
            $itemList[$k] = D('Item')->format($v, $arrFormatField);
            $itemList[$k]['cover_name'] = getPicPath(D('GalleryMeta')->getImg($v['cover']), 'm');
            $itemList[$k]['url'] = U('Index/item', array('user'=>$this->user, 'member_id'=>$this->member_id, 'id'=>$v['id']));
        }
        return array('list'=>$itemList,'page'=>$page->show());
    }

    /**
     * Get the Thene name
     * return string $themeName 主题名称
     */
    protected function getThemeName()
    {
        $theme_id = D('Setting')->where('user_id='.$this->user_id)->getField('theme_id');
        $theme_name = D('Theme')->where('id='.$theme_id)->getField('spell');
        return ($theme_name) ? $theme_name : 'default';
    }

    /**
     * Get the gallery img list
     */
    protected function getImgList($gallery_id)
    {
        $imgObj = D('GalleryMeta');
        $imgList = $imgObj->where('gallery_id='.$gallery_id)->select();
        foreach($imgList as $k=>$v){
            $imgList[$k]['path_name'] = getPicPath($v['path'], 'b');
        }
        return $imgList;
    }

    /**
     * get template file list
     */
    private function setTplList()
    {
        /* 模版的定制优先原则 */
        $relTplList = scandir('./app/Tpl/Mobile/'.ucfirst($this->theme_name));
        $this->relTplList = $relTplList;
    }


    /**
     * get nav template
     */
    protected function getNav()
    {
        if(in_array('navigation.html', $this->relTplList)){
            $nav = ucfirst($this->theme_name).':navigation';
        }else{
            $nav = 'Public:navigation';
        }
        return $nav;
    }

    /**
     * get theme dir
     */
    protected function getRelTpl($tplName)
    {
        if(in_array($tplName.'.html', $this->relTplList)){
            $themeDir = ucfirst($this->theme_name);
        }else{
            $themeDir = 'Default';
        }
        return $themeDir.':'.$tplName;
    }

    /**
     * getApiData
     */
    protected function getApiInfo($url, $article_id){
        $url .= '&article_id='.$article_id;
        $info = $this->getCUrl($url);
        return $info;
    }

    protected function getApiList($url, $article_id, $count){
        $page = page($count, 10, 'simple');
        $url .= '&article_id='.$article_id.'&type=list&start='.$page->firstRow.'&length='.$page->listRows;
        $list = $this->getCUrl($url);
        if(!empty($list)){
            foreach($list as $k=>$v){
                $list[$k]['url'] = U('Index/api', array(
                    'user'=>$this->user,
                    'member_id'=>$member_id,
                    'id'=>$this->item_id,
                    'article_id'=>$v['id']
                ));
            }
        }
        return array('list'=>$list,'page'=>$page->show());
    }

    private function getCUrl($url){
        if(empty($url)){return 0;exit;}
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        $info = json_decode($result, 'true');
        return $info;
    }
}
