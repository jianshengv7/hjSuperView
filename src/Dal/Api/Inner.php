<?php

namespace SuperView\Dal\Api;

/**
* Comment Dal.
*/
class Inner extends Base
{
    /**
     * 获取内联表信息
     *
     * @param $is_ztid
     * @param $classid
     * @param $limit
     * @param $order
     * @return array|bool
     */
    public function getInfo($is_ztid, $classid, $limit, $random)
    {
        $params = [
            'is_ztid' => intval($is_ztid),
            'classid' => intval($classid),
            'limit'     => intval($limit),
            'random' => $random,
        ];
        return $this->getData('lists', $params);
    }


}