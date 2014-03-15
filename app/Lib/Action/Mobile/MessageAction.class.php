<?php
/**
 * 接收信息控制器
 * @author chen
 * version 2014-03-04
 */
class MessageAction extends MobileAction
{
    /**
     * 添加评论操作
     */
    public function message()
    {
        $data = $_POST;
        $data['date_add'] = time();
        $data['user_id'] = $this->user_id;
        D('Message')->add($data);
        echo '操作成功';
    }
}
