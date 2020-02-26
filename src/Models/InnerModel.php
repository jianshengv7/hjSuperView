<?php

namespace SuperView\Models;

class InnerModel extends BaseModel
{

    /**
     * 获取内联表信息
     *
     * @param int $is_ztid
     * @param int $classid
     * @param int $limit
     * @param string $order
     * @return mixed
     */
    public function lists($is_ztid = 0, $classid = 0, $limit=0 ,$random = 1)
    {
        return $this->dal['inner']->getInfo($is_ztid, $classid, $limit, $random);
    }
}
