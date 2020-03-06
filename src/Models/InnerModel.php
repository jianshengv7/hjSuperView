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


    /**
     * 首页底部推荐
     *
     * @param string $group
     * @return mixed
     */
    public function footer($group = 'data_type')
    {
        return $this->dal['foot']->getFooter($group);
    }

    /**
     * 友链
     *
     * @param $ztid
     * @return mixed
     */
    public function friendLink($ztid = 0)
    {
        return $this->dal['inner']->getFriendLink($ztid);
    }

    /**
     * 获取内联列表
     *
     * @param int $is_ztid
     * @param string $order
     * @return mixed
     */
    public function softInner($is_ztid = 0, $order = 'sum')
    {
        return $this->dal['inner']->getSoftInner($is_ztid, $order);
    }

    /**
     * 正文内联词
     *
     * @param int $classid
     * @param int $ztid
     * @param int $limit
     * @return mixed
     */
    public function getHotSearchForClass($classid = 0, $ztid = 0, $limit = 0)
    {
        return $this->dal['inner']->getSoftInner($classid, $ztid, $limit);
    }
}
