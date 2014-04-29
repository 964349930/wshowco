<?php
/**
* member management action
* @author chen
* @version 2014-03-18
*/
class MemberAction extends HomeAction
{
    /**
* get the member list
*/
    public function memberList()
    {
        $memberObj = D('Member');
        $arrField = array();
        $arrMap['user_id'] = array('eq', $_SESSION['uid']);
        $arrOrder = array('date_login desc');
        $page = page($memberObj->getCount($arrMap));
        $memberList = $memberObj->getList($arrField, $arrMap, $arrOrder, $page->firstRow, $page->listRows);
        foreach($memberList as $k=>$v){
            $memberList[$k] = $memberObj->format($v, array('avatar_name', 'name', 'mobile'));
        }
        $data = array(
            'infoUrl' => U('Home/Member/memberInfo'),
            'msgUrl' => U('Home/Member/msgList'),
            'pushUrl' => U('Home/Member/pushList'),
            'viewUrl' => U('Home/Member/viewList'),
            'likeUrl' => U('Home/Member/likeList'),
            'memberList' => $memberList,
            'pageHtml' => $page->show(),
        );
        $this->assign($data);
        $this->display();
    }

    /**
* view the member info
*/
    public function memberInfo()
    {
        $memberObj = D('Member');
        $member_id = $this->_get('member_id', 'intval');
        $memberInfo = $memberObj->getInfoById($member_id);
        $memberInfo = $memberObj->format($memberInfo, array('avatar_name'));
        $data = array(
            'memberInfo' => $memberInfo,
        );
        $this->assign($data);
        $this->display();
    }

    /**
* view the member visit log
*/
    public function viewList()
    {
        $member_id = $this->_get('member_id', 'intval');
        $visitObj = D('MemberVisit');
        $arrField = array();
        $arrMap['member_id'] = array('eq', $member_id);
        $arrOrder = array('date_visit');
        $page = page($visitObj->getCount($arrMap));
        $visitList = $visitObj->getList($arrField, $arrMap, $arrOrder, $page->firstRow, $page->listRows);
        foreach($visitList as $k=>$v){
            $visitList[$k]['item_title'] = D('Item')->where('id='.$v['item_id'])->getField('title');
        }
        $data = array(
            'visitList' => $visitList,
            'pageHtml' => $page->show(),
        );
        $this->assign($data);
        $this->display();
    }

    /**
* view the member visit log
*/
    public function likeList()
    {
        $member_id = $this->_get('member_id', 'intval');
        $eventObj = D('MemberCol');
        $arrField = array();
        $arrMap['member_id'] = array('eq', $member_id);
        $arrOrder = array('date_col');
        $page = page($eventObj->getCount($arrMap));
        $eventList = $eventObj->getList($arrField, $arrMap, $arrOrder, $page->firstRow, $page->listRows);
        $data = array(
            'eventList' => $eventList,
            'pageHtml' => $page->show(),
        );
        $this->assign($data);
        $this->display();
    }

    /**
* wechat push list
*/
    public function pushList()
    {
        $member_id = $this->_get('member_id', 'intval');
        $pushObj = D('MemberPush');
        $arrField = array();
        if(!empty($member_id)){
            $arrMap['member_id'] = array('eq', $member_id);
        }else{
            $member_id_list = D('Member')->where('user_id='.$_SESSION['uid'])->getField('id', true);
            $arrMap['member_id'] = array('in', $member_id_list);
        }
        $arrOrder = array('date_push desc');
        $page = page($pushObj->getCount($arrMap));
        $pushList = $pushObj->getList($arrField, $arrMap, $arrOrder, $page->firstRow, $page->listRows);
        foreach($pushList as $k=>$v){
            $pushList[$k]['member_name'] = D('Member')->where('id='.$v['member_id'])->getField('name');
        }
        $data = array(
            'member_id' => $member_id,
            'pushList' => $pushList,
            'pageHtml' => $page->show(),
            'pushDelUrl' => U('Home/Member/pushDel'),
        );
        $this->assign($data);
        $this->display();
    }

    /**
* view the site message list
*/
    public function msgList()
    {
        $member_id = $this->_get('member_id', 'intval');
        $msgObj = D('MemberMsg');
        $arrField = array();
        if(!empty($member_id)){
            $arrMap['member_id'] = array('eq', $member_id);
        }else{
            $member_id_list = D('Member')->where('user_id='.$_SESSION['uid'])->getField('id', true);
            $arrMap['member_id'] = array('in', $member_id_list);
        }
        $arrOrder = array('date_msg desc');
        $page = page($msgObj->getCount($arrMap));
        $msgList = $msgObj->getList($arrField, $arrMap, $arrOrder, $page->firstRow, $page->listRows);
        foreach($msgList as $k=>$v){
            $msgList[$k] = $msgObj->format($v, array('member_name'));
        }
        $data = array(
            'member_id' => $member_id,
            'msgList' => $msgList,
            'pageHtml' => $page->show(),
            'msgDelUrl' => U('Home/Member/msgDel'),
        );
        $this->assign($data);
        $this->display();
    }

    public function pushDel()
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
        D('MemberPush')->where($map)->delete();
        $this->success('删除成功');
    }

    /**
* 删除
*/
    public function msgDel()
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
        D('MemberMsg')->where($map)->delete();
        $this->success('删除成功');
    }
    /**
     * 导出EXCEL表格
     */
    public function exportExcel()
    {
        /** Include PHPExcel */
        require_once './core/PHPExcel/PHPExcel.php';
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("深蓝解码")
							 ->setLastModifiedBy("深蓝解码")
							 ->setTitle("蛋糕商城")
							 ->setSubject("蛋糕商城")
							 ->setDescription("蛋糕商城订单数据");
        // Add some data
        $orderInfoObj = D('OrderInfo');
        $arrField = array();
        $arrMap = array();
        $arrOrder = array('ctime desc');
        $orderList = $orderInfoObj->getList($arrField, $arrMap, $arrOrder);
        $arrFormatField = array('order_status_name', 'goods_name', 'goods_size');
		foreach ($orderList as $key => $value) {
            $orderList[$key] = $orderInfoObj->format($value, $arrFormatField);
			$orderList[$key]['pay_time'] = date("Y-m-d", $value['pay_time']);
			$orderList[$key]['pay_type'] = ($value['pay_type'] == 0) ? '在线支付' : '货到付款';
			$orderList[$key]['pay_status'] = ($value['pay_status'] == 0) ? '未付款' : '已付款';
            $orderList[$key]['ctime_text'] = date("Y-m-d", $value['ctime']);
		}

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '订单ID')
            ->setCellValue('B1', '订单编号')
            ->setCellValue('C1', '用户姓名')
            ->setCellValue('D1', '商品名称')
            ->setCellValue('E1', '订单总额')
            ->setCellValue('F1', '订购人姓名')
            ->setCellValue('G1', '订购人手机号码')
            ->setCellValue('H1', '订购人地址')
            ->setCellValue('I1', '收货人姓名')
            ->setCellValue('J1', '收货人手机号码')
            ->setCellValue('K1', '收货人地区')
            ->setCellValue('L1', '收货人详细地址')
            ->setCellValue('M1', '运费')
            ->setCellValue('N1', '送达时间')
            ->setCellValue('O1', '订制语')
            ->setCellValue('P1', '备注')
            ->setCellValue('Q1', '支付方式')
            ->setCellValue('R1', '支付状态')
            ->setCellValue('S1', '订单创建时间');
        foreach($orderList as $k=>$v){
            $objPHPExcel->getActiveSheet()
                ->setCellValue('A'.($k+2), $v['id'])
                ->setCellValue('B'.($k+2), $v['order_sn'])
                ->setCellValue('C'.($k+2), $v['user_name'])
                ->setCellValue('D'.($k+2), $v['goods_name'])
                ->setCellValue('E'.($k+2), $v['order_total'])
                ->setCellValue('F'.($k+2), $v['order_name'])
                ->setCellValue('G'.($k+2), $v['order_mobile'])
                ->setCellValue('H'.($k+2), $v['order_address'])
                ->setCellValue('I'.($k+2), $v['consignee_name'])
                ->setCellValue('J'.($k+2), $v['consignee_mobile'])
                ->setCellValue('K'.($k+2), $v['consignee_district'])
                ->setCellValue('L'.($k+2), $v['consignee_address'])
                ->setCellValue('M'.($k+2), $v['freight'])
                ->setCellValue('N'.($k+2), $v['arrive_time'])
                ->setCellValue('O'.($k+2), $v['custom_lang'])
                ->setCellValue('P'.($k+2), $v['postscript'])
                ->setCellValue('Q'.($k+2), $v['pay_type'])
                ->setCellValue('R'.($k+2), $v['pay_status'])
                ->setCellValue('S'.($k+2), $v['ctime_text']);
        }
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('订单数据');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="订单数据.xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
}
