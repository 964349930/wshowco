<?php
/**
 * File Name: UserModel.class.php
 * Author: Blue
 * Created Time: 2013-11-15 9:02:37
*/
class UserModel extends CommonModel{
    /**
     * action list
     */
    public function get_action_list()
    {
        return array(
            array('title'=>'添加用户','url'=>U('User/add')),
            array('title'=>'','type'=>'','url'=>U('User/info')),
        );
    }

    /**
     * file list
     */
    public function get_file_list()
    {
        return array(
            array('name'=>'id','type'=>'hidden'),
            array('title'=>'用户名','flag'=>'name','name'=>'name','type'=>'text'),
            array('title'=>'头像','flag'=>'avatar','name'=>'avatar','type'=>'image'),
            array('title'=>'手机号码','flag'=>'mobile','name'=>'mobile','type'=>'tel'),
            array('title'=>'接口地址','flag'=>'url','name'=>'url','type'=>'url'),
            array('title'=>'借口凭证','flag'=>'token','name'=>'flag','type'=>'text'),
            array('title'=>'APPID','flag'=>'appid','name'=>'appid','type'=>'text'),
            array('title'=>'APPSECRECT','flag'=>'appsecrect','name'=>'appsecrect','type'=>'text'),
        );
    }

	/**
	 * 输出格式化
	 */
	public function format($info, $arrFormatField){
		//分组
		if(in_array('group_name', $arrFormatField)){
			$info['group_name'] = ($info['group_id'] == 1) ? '管理员' : '普通会员';
		}
		//时间
		if(in_array('data_log_text', $arrFormatField)){
			$info['data_log_text'] = date('Y-m-d H:i', $info['data_log']);
		}
		//头像
		if(in_array('avatar_name', $arrFormatField)){
			$info['avatar_name'] = getPicPath(D('GalleryMeta')->getImg($info['avatar']), 's');
		}
        //url
        if(in_array('url', $arrFormatField)){
            $info['url'] = 'http://'.$_SERVER['HTTP_HOST'].U('Home/Wx/wxapi', array('user'=>$info['name']));
        }
		return $info;
	}
}
