<?php
/**
 * File Name: PermissionModel.class.php
 * Author: Blue
 * Created Time: 2013-11-22 15:30:31
*/
class TabModel extends CommonModel{
    /**
     * 获取菜单列表
     */
    public function  getTabList($parent_id=0){
        $arrField = array('*');
        $arrMap['parent_id'] = array('eq', $parent_id);
        if($_SESSION['userInfo']['group_id'] != 1){
            //当用户为普通用户时，菜单显示方式
            $arrMap['status'] = array('eq', 2);
        }
        $arrOrder = array('sort_order');
        $tabList = $this->getList($arrField, $arrMap, $arrOrder);
        return $tabList;
    }
}
