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
    protected $theme_name;

	/**
	 * 判断用户
	 */
    public function _initialize()
    {
		$this->user = trim($_GET['user']);
		if(empty($this->user)){
			echo '对不起，您所访问的站点不存在';
			exit;
		}
        $this->user_id = D('User')->where("name='".$this->user."'")->getField('id');
        $this->setTheme();
        $data = array(
            'user'          => $this->user,
            'site'          => $this->getSiteInfo(),
            'menuList'      => $this->getItemList(),
            'home'          => U('Index/index', array('user'=>$this->user)),
        );
        $this->assign($data);

	}

    /**
     * Set the guest info
     * add the ip, longitude, lagitude, and device info
     */
    private function setGuestInfo()
    {
        $this->guest = trim($_GET['guest']);
        if(empty($this->guest)){
            $this->guest = time().substr(mt_rand(), 5);
        }
    }

    /**
     * 获取网站设置信息
     * @return array $siteInfo 网站设置信息
     */
    protected function getSiteInfo()
    {
        $siteInfo = D('Setting')->where('user_id='.$this->user_id)->find();
        $siteInfo = D('Setting')->format($siteInfo, array('logo_name','theme_spell'));
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
        $itemInfo = D('Item')->format($itemInfo, array('cover_name', 'template_name'));
        return $itemInfo;
    }

    /**
     * 获取栏目列表
     * @param int $fid 父级栏目ID
     * @return array $catList 栏目列表
     */
    protected function getItemList($parent_id=0)
    {
        $itemList = D('Item')->where('parent_id='.$parent_id.' AND user_id='.$this->user_id.' AND status=1')->order('sort_order')->select();
        $arrFormatField = array('cover_name');
        foreach($itemList as $k=>$v){
            $itemList[$k] = D('Item')->format($v, $arrFormatField);
            $itemList[$k]['url'] = U('Index/item', array('user'=>$this->user, 'id'=>$v['id']));
        }
        return $itemList;
    }

    /**
     * Get the Thene name
     * return string $themeName 主题名称
     */
    protected function setTheme()
    {
        $theme_id = D('Setting')->where('user_id='.$this->user_id)->getField('theme_id');
        $theme_name = D('Theme')->where('id='.$theme_id)->getField('spell');
        if(!empty($theme_name)){
            $this->theme_name = $theme_name;
        }else{
            $this->theme_name = 'default';
        }
    }

} 
