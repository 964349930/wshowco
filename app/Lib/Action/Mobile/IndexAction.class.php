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
        $this->display(ucfirst($this->theme_name).':index');
    }

    /**
     * 内页控制函数
     */
    public function item()
    {
        $this->display(ucfirst($this->theme_name).':'.$this->template_name);
    }
}

