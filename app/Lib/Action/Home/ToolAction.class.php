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
        if($_SESSION['uid'] != 1){
            $arrMap['status'] = array('eq', 1);
        }
        $arrOrder = array('sort_order');
        $page = page($toolObj->getCount($arrMap));
        $toolList = $toolObj->getList($arrField, $arrMap, $arrOrder, $page->firstRow, $page->listRows);
        foreach($toolList as $k=>$v){
            $toolList[$k] = $toolObj->format($v, array('useStatus'));
        }
        $tplData = array(
            'toolList' => $toolList,
            'useUrl'   => U('Home/Tool/useTool'),
            'toolInfoUrl' => U('Home/Tool/toolInfo'),
            'delUrl'    => U('Home/Tool/del'),
        );
        $this->assign($tplData);
        $this->display();
    }

    /**
     * toolInfo
     */
    public function toolInfo()
    {
        $toolObj = D('WechatTool');
        if(empty($_POST)){
            $id = $this->_get('id', 'intval');
            if(!empty($id)){
                $toolInfo = $toolObj->getInfoById($id);
                $this->assign('toolInfo', $toolInfo);
            }
            $this->assign('toolInfoUrl', U('Home/Tool/toolInfo'));
            $this->display();
            exit;
        }
        $data = $this->_post();
        $data['date_modify'] = time();
        if(empty($data['id'])){
            $data['date_add'] = time();
            $toolObj->add($data);
        }else{
            $toolObj->save($data);
        }
        $this->success('操作成功');
    }

    /**
     * 使用微应用
     */
    public function useTool(){
        $toolObj = D('WechatTool');
        $routeObj = D('WechatRoute');
        $id = intval($this->_get('id'));
        $tool_name = $toolObj->where('id='.$id)->getField('name');
        $route_id = $routeObj->where("user_id=".$_SESSION['uid']." AND keyword='".$tool_name."'")->getField('id');
        if(!empty($route_id)){
            $result = $routeObj->where('id='.$route_id)->delete();
        }else{
            $result = $routeObj->updateRoute('tool', $id, array('keyword'=>$tool_name));
        }
        $this->success('操作成功');
    }

    /**
     * 删除
     */
    public function del()
    {
        $delIds = array();
		$postIds = $this->_post('id');
		if (!empty($postIds)) {
			$delIds = $postIds;
		}
		$getId = intval($this->_get('id'));
		if (!empty($getId)) {
			$delIds[] = $getId;
		}
		if (empty($delIds)) {
			$this->error('请选择您要删除的数据');
		}
		$map['id'] = array('in', $delIds);
		D('WechatTool')->where($map)->delete();
		$this->success('删除成功');
    }

}
