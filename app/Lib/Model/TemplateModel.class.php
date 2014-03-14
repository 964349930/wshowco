<?php
/**
 * The Template Model
 * @author chen
 * @version 2014-03-15
 */
class TemplateModel extends CommonModel
{
    /**
     * Get the Theme template list
     * @return array $temlist
     */
    public function getTemplateList()
    {
        $templateObj = D('Template');
        $templateList = $templateObj->where('status=1')->select();
        return $templateList;
    }

}
