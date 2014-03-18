<?php
/**
 * 菜单模型
 */
class WechatMenuModel extends CommonModel
{
    /**
     * 获取token
     */
    public function getToken(){
        $userInfo = D('User')->where('id='.$_SESSION['uid'])->find();
        $grant_type = 'client_credential';
        $appid = $userInfo['appid'];
        $appsecret = $userInfo['appsecrect'];
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type='.$grant_type.'&appid='.$appid.'&secret='.$appsecret;

        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        //将获取到的内容json解码为类
        $result = json_decode($result);
        if($result->expires_in !== 7200){
        }
        return $result->access_token;
    }

}
