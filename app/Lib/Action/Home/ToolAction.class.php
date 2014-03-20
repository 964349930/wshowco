<?php
/**
 * 微应用操作类
 * @author chen
 * @version 2013-12-27
 */
class ToolAction extends HomeAction {
    /**
     * 获取应用列表
     */
    public function toolList(){
        $toolObj = D('WechatTool');
        $arrField = array('*');
        $arrMap['status'] = array('eq', 1);
        $arrOrder = array('sort_order');
        $page = page($toolObj->getCount($arrMap));
        $toolList = $toolObj->getList($arrField, $arrMap, $arrOrder, $page->firstRow, $page->listRows);
        foreach($toolList as $k=>$v){
            $toolList[$k] = $toolObj->format($v, array('status_name'));
        }
        $tplData = array(
            'toolList' => $toolList,
            'useUrl'   => U('Home/Tool/useTool'),
        );
        $this->assign($tplData);
        $this->display();
    }

    /**
     * 使用微应用
     */
    public function useTool(){
        $toolObj = D('PushTool');
        $id = intval($this->_get('id'));
        $status = $this->_get('status');
        $tool_name = $toolObj->where('id='.$id)->getField('tool_name');
        if(!empty($status)){
            $result = D('PushRoute')->addRoute('pushTool', $id, $tool_name);
        }else{
            $result = D('PushRoute')->where("keyword='".$tool_name."'")->delete();
        }
        if(!empty($result)){
            $this->success('更新成功');
        }
    }
}
