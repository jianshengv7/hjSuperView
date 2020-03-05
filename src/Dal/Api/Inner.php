<?php

namespace SuperView\Dal\Api;

/**
* Mini Dal.
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

    /**
     * 首页底部推荐
     *
     * @param $group
     * @return array|bool
     */
    public function getFooter($group)
    {
        $params = [
            'group' => $group,
        ];
        return $this->getData('footer', $params);
    }

    /**
     * 友链
     *
     * @param $ztid
     * @return array|bool
     */
    public function getFriendLink($ztid)
    {
        $params = [
            'ztid' => $ztid,
        ];
        return $this->getData('friendLink', $params);
    }

}