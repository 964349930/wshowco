<?php
/**
 * ext value model
 */
class ExtValModel extends CommonModel
{
    /**
     * update val
     * @param array2 $extList
     * @param int $res_id
     * @return int $id
     */
    public function updateExtVal($extList, $res_id)
    {
        foreach($extList as $k=>$v){
            $id = $v['id'];
            $v['date_modify'] = time();
            if(empty($id)){
                //add
                $v['res_id'] = $res_id;
                $v['date_add'] = time();
                $id = $this->add($v);
            }else{
                $this->save($v);
            }
        }
        return $id;
    }
}
