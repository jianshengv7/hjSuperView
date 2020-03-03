<?php

namespace SuperView\Dal\Api;

/**
* Content Dal.
*/
class Content extends Base
{

     /**
     * 排名因子枚举
     */
    private static $periods = [
        'day', 'week', 'month', 'all'
    ];

    /**
     * 排序因子枚举
     */
    private static $orderKeys = [
        'newstime', 'newstimeasc', 'allhits', 'monthhits', 'weekhits', 'id','lastdotime', 'totalip',
    ];

    /**
     * 内容详情
     * @return boolean | array
     */
    public function getInfo($id = 0)
    {
        if (intval($id) <= 0) {
            return false;
        }
        $params = [
            'id' => intval($id)
        ];

        return $this->getData('info', $params);
    }

    /**
     * 最新列表
     * @return boolean | array
     */
    public function getRecentList($classid, $page, $limit, $isPic)
    {
        $params = [
            'classid' => ($classid),
            'page'    => intval($page),
            'limit'   => intval($limit),
            'ispic'   => intval($isPic),
        ];
        return $this->getData('recent', $params);
    }

    /**
     * 排名列表
     * @return boolean | array
     */
    public function getRankList($classid, $page, $limit, $isPic, $period)
    {
        $params = [
            'classid' => ($classid),
            'page'    => intval($page),
            'limit'   => intval($limit),
            'ispic'   => intval($isPic),
            'rank'    => $period,
        ];

        return $this->getData('rank', $params);
    }

    /**
     * 推荐信息列表
     * @return boolean | array
     */
    public function getLevelList($type, $classid, $page, $limit, $isPic, $level, $order)
    {
        if (!$this->isValidOrder($order) || !$this->isValidLevel($level)) {
            return false;
        }

        if (empty($type) || !in_array($type, ['good', 'top', 'firsttitle'])) {
            return false;
        }

        $params = [
            'level'   => ($level),
            'classid' => ($classid),
            'page'    => intval($page),
            'limit'   => intval($limit),
            'ispic'   => intval($isPic),
            'order'   => $order,
        ];
        return $this->getData($type, $params);
    }

    /**
     * 今日更新列表
     * @return boolean | array
     */
    public function getTodayList($classid, $page, $limit, $isPic, $order)
    {
        if (!$this->isValidOrder($order)) {
            return false;
        }

        $params = [
            'classid' => ($classid),
            'page'    => intval($page),
            'limit'   => intval($limit),
            'ispic'   => intval($isPic),
            'order'   => $order,
        ];
        return $this->getData('today', $params);
    }

    /**
     * 时间段列表
     * @return boolean | array
     */
    public function getIntervalList($startTime, $endTime, $classid, $page, $limit, $isPic, $order)
    {
        if (!$this->isValidOrder($order)) {
            return false;
        }

        if($startTime > $endTime || $startTime < 0 || $endTime < 0) {
            return false;
        }

        $params = [
            'start'   => intval($startTime),
            'end'     => intval($endTime),
            'classid' => ($classid),
            'page'    => intval($page),
            'limit'   => intval($limit),
            'ispic'   => intval($isPic),
            'order'   => $order,
        ];
        return $this->getData('interval', $params);
    }

    /**
     * 时间段列表
     * @return boolean | array
     */
    public function getListByTitle($title, $classid, $page, $limit, $isPic, $order)
    {
        if (!$this->isValidOrder($order)) {
            return false;
        }

        $params = [
            'title'   => $title,
            'classid' => ($classid),
            'page'    => intval($page),
            'limit'   => intval($limit),
            'ispic'   => intval($isPic),
            'order'   => $order,
        ];
        return $this->getData('title', $params);
    }

    /**
     * 信息相关列表
     * @return boolean | array
     */
    public function getRelatedList($id, $page, $limit, $isPic, $order)
    {
        if (!$this->isValidOrder($order)) {
            return false;
        }

        $params = [
            'id'    => ($id),
            'page'  => intval($page),
            'limit' => intval($limit),
            'ispic' => intval($isPic),
            'order' => $order,
        ];
        return $this->getData('related', $params);
    }

    /**
     * TAG信息列表
     * @return boolean | array
     */
    public function getListByTag($tag,$classid, $page, $limit, $isPic, $order)
    {
        if (!$this->isValidOrder($order)) {
            return false;
        }

        $params = [
            'tag'   => $tag,
            'classid' => $classid,
            'page'  => intval($page),
            'limit' => intval($limit),
            'ispic' => intval($isPic),
            'order' => $order,
        ];
        return $this->getData('tag', $params);
    }

    /**
     * 信息所属专题列表
     * @return boolean | array
     */
    public function getInfoTopics($id, $limit)
    {
        $params = [
            'id'    => ($id),
            'limit' => intval($limit),
        ];
        return $this->getData('infoTopics', $params);
    }


    /**
     * 专题信息列表
     * @return boolean | array
     */
    public function getListByTopicId($topicId, $page, $limit)
    {
        $params = [
            'ztid'  => ($topicId),
            'page'  => intval($page),
            'limit' => intval($limit),
        ];
        return $this->getData('special', $params);
    }

    /**
     * 信息搜索列表
     * @return boolean | array
     */
    public function getListByKeyword($str, $classid, $page, $limit, $isPic, $order)
    {
        $params = [
            'str'     => $str,
            'classid' => ($classid),
            'page'    => intval($page),
            'limit'   => intval($limit),
            'ispic'   => intval($isPic),
            'order'   => $order,
        ];
        return $this->getData('search', $params);
    }

    /**
     * 信息搜索列表：根据指定字段指定值
     * @return boolean | array
     */
    public function getListByFieldValue($field,$value, $classid, $page, $limit, $isPic, $order)
    {
        $params = [
            'field'   => $field,
            'value'   => $value,
            'classid' => ($classid),
            'page'    => intval($page),
            'limit'   => intval($limit),
            'ispic'   => intval($isPic),
            'order'   => $order,
        ];
        return $this->getData('match', $params);
    }

    /**
     * 查询小于[等于]某id的$limit范围内的信息列表
     *
     * @param integer $id 
     * @param integer $limit
     * @param integer $classid
     * @param integer $equal 默认为0小于$id，1小于等于$id
     *
     * @return array 符合查询条件的帝国cms的信息列表
     */
    public function near($id,$limit,$classid,$equal,$isPic,$order)
    {
        $params = [
            'id'   => $id,
            'limit'   => $limit,
            'classid' => ($classid),
            'equal'    => intval($equal),
            'ispic'   => intval($isPic),
            'order'   => $order,
        ];
        return $this->getData('near', $params);
    }


    /**
     * 获取数量统计
     * @return boolean | array
     */
    public function getCount($period, $classid)
    {
        if (!in_array($period, self::$periods)) {
            return false;
        }
        $params = [
            'interval' => $period,
            'classid'  => ($classid)
        ];

        return $this->getData('count', $params);
    }


    /**
     * 检查level参数是否正确
     * @param int $level 等级
     * @return boolean
     */
    public function isValidLevel($level)
    {
        return 0 <= intval($level) && intval($level) <= 9;
    }

    /**
     * 检查order参数是否正确
     * @param string $order 排序因子
     * @return boolean
     */
    public function isValidOrder($order)
    {
        return empty($order) || in_array($order, self::$orderKeys);
    }

    /**
     * 根据Tag词查询title定制方法
     *
     * @param $str
     * @param int $classid
     * @param int $limit
     * @param int $isPic
     * @param string $order
     * @return mixed
     */
    public function getRelatedSearch($str, $classid, $limit, $isPic, $order)
    {
        $params = [
            'str'     => $str,
            'classid' => $classid,
            'limit' => $limit,
            'ispic'   => intval($isPic),
            'order'   => $order,

        ];
        return $this->getData('relatedSearch', $params);

    }

    /**
     * 根据字段搜索
     *
     * @param $field
     * @param $value
     * @param $classid
     * @param $page
     * @param $limit
     * @param $ispic
     * @param $order
     * @return array|bool|mixed
     */
    public function getExactMatch($field,$value, $classid, $page, $limit, $ispic, $order)
    {
        $params = [
            'value'   => $value,
            'field'   => $field,
            'classid' => ($classid),
            'page'    => intval($page),
            'limit'   => intval($limit),
            'ispic'   => intval($ispic),
            'order'   => $order,
        ];
        return $this->getData('exactMatch', $params);
    }

    /**
     * 查询多个class下的推荐数据
     *
     * @param $firsttitle
     * @param $classidArr
     * @param $limit
     * @param $order
     * @return array|bool
     */
    public function firsttitleInClass($firsttitle, $classidArr, $limit, $order)
    {
        $params = [
            'firsttitle'   => $firsttitle,
            'classidArr'   => $classidArr,
            'limit'   => intval($limit),
            'order'   => $order,
        ];
        return $this->getData('firsttitleInClass', $params);
    }

    /**
     * 查询classid不等于某个值
     *
     * @param $classid
     * @param $limit
     * @param $order
     * @return array|bool
     */
    public function getNeq($classid, $limit, $order)
    {
        $params = [
            'classid'   => $classid,
            'limit'   => intval($limit),
            'order'   => $order,
        ];
        return $this->getData('neq', $params);
    }

    /**
     * 排序信息列表
     *
     * @param $classid
     * @param $page
     * @param $limit
     * @param $order
     * @return array|bool
     */
    public function getOrderList($classid, $page, $limit, $order)
    {
        $params = [
            'classid'   => $classid,
            'page'   => $page,
            'limit'   => intval($limit),
            'order'   => $order,
        ];
        return $this->getData('order', $params);
    }

    /**
     * 通过cid获取厂商
     *
     * @param $cid
     * @return array|bool
     */
    public function getCompany($cid)
    {
        $params = [
            'cid' => intval($cid),
        ];
        return $this->getData('company', $params);
    }

    /**
     * 获取厂商列表（仅限厂商使用）
     *
     * @param $classid
     * @param $limit
     * @param $order
     * @return array|bool
     */
    public function getHotList($classid, $limit, $order)
    {
        $params = [
            'classid' => intval($classid),
            'limit' => intval($limit),
            'order' => $order,
        ];
        return $this->getData('hotList', $params);
    }

    /**
     * 攻略列表
     *
     * @param $game_id
     * @param $page
     * @param $limit
     * @param $order
     * @return array|bool
     */
    public function getStrategy($game_id, $page, $limit, $order)
    {
        $params = [
            'game_id'   => $game_id,
            'page'   => $page,
            'limit'   => intval($limit),
            'order'   => $order,
        ];
        return $this->getData('strategy', $params);
    }
}
