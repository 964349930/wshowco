<?php
/**
 * The Template Model
 * @author chen
 * @version 2014-03-15
 */
class ThemeTplModel extends CommonModel
{
    /**
     * Get the Theme template list
     * @return array $temlist
     */
    public function getTplList()
    {
        $theme_id = D('Setting')->field('id,name')->where('user_id='.$_SESSION['uid'])->getField('theme_id');
        $map['theme_id'] = array('in', array($theme_id, '1'));
        $tplList = D('ThemeTpl')->where($map)->select();
        foreach($tplList as $k=>$v){
            $list[$k]['title'] = $v['name'];
            $list[$k]['value'] = $v['id'];
        }
        return $list;
    }

    /**
     * format the template item
     * @param array $arrInfo
     * @param array $arrFormatField
     * @return array $arrInfo
     */
    public function format($arrInfo, $arrFormatField)
    {
        if(in_array('status_name', $arrFormatField)){
            $arrInfo['status_name'] = ($arrInfo['status'] == 1) ? '使用' : '未使用';
        }
        return $arrInfo;
    }

}
