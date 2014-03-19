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

	/**
	 * 判断用户
	 */
    public function _initialize()
    {
		$this->user = trim($_GET['user']);
        $this->member_id = intval($_GET['member_id']);
        $this->user_id = D('User')->where("name='".$this->user."'")->getField('id');
        $this->theme_name = $this->getThemeName();
        $this->item_id = intval($_GET['id']);
        $data = array(
            'user'          => $this->user,
            'member_id'     => $this->member_id,
            'site'          => $this->getSiteInfo(),
            'menuList'      => $this->getItemList(),
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
            $itemList[$k]['url'] = U('Index/item', array('user'=>$this->user, 'member_id'=>$this->member_id, 'id'=>$v['id']));
        }
        return $itemList;
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

}
