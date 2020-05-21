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
        'newstime', 'newstimeasc', 'allhits', 'monthhits', 'weekhits', 'id', 'lastdotime', 'totalip',
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
            'page' => intval($page),
            'limit' => intval($limit),
            'ispic' => intval($isPic),
        ];
        return $this->getData('recent', $params);
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
            'level' => ($level),
            'classid' => ($classid),
            'page' => intval($page),
            'limit' => intval($limit),
            'ispic' => intval($isPic),
            'order' => $order,
        ];
        return $this->getData($type, $params);
    }

    /**
     * 信息搜索列表：根据指定字段指定值
     * @return boolean | array
     */
    public function getListByFieldValue($field, $value, $classid, $page, $limit, $isPic, $order)
    {
        $params = [
            'field' => $field,
            'value' => $value,
            'classid' => ($classid),
            'page' => intval($page),
            'limit' => intval($limit),
            'ispic' => intval($isPic),
            'order' => $order,
        ];
        return $this->getData('match', $params);
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
            'classid' => ($classid)
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
            'classid' => $classid,
            'limit' => intval($limit),
            'order' => $order,
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
            'classid' => $classid,
            'page' => $page,
            'limit' => intval($limit),
            'order' => $order,
        ];
        return $this->getData('order', $params);
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
            'game_id' => $game_id,
            'page' => $page,
            'limit' => intval($limit),
            'order' => $order,
        ];
        return $this->getData('strategy', $params);
    }

    /**
     * 信息所属专题列表
     * @return boolean | array
     */
    public function getInfoTopics($id, $limit)
    {
        $params = [
            'id' => ($id),
            'limit' => intval($limit),
        ];
        return $this->getData('speciallist', $params);
    }

    /**
     * title列表
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
     * 自定义参数请求 （参数和值数量必须对应）
     *
     * @param string $fields 请求字段 多个参数以逗号分隔
     * @param string $values 值   多个值以多个逗号分隔
     * @param $limit
     * @param $order
     * @return array|bool
     */
    public function getCustomList($fields, $limit, $order, $page)
    {
        $params = [
            'fields' => $fields,
            'limit' => $limit,
            'order' => $order,
            'page' => $page
        ];
        return $this->getData('customList', $params);
    }

    /**
     * 获取评论
     *
     * @param $softid
     * @param $checked
     * @param $limit
     * @return array|bool
     */
    public function getPl($softid, $checked, $limit)
    {
        $params = [
            'softid' => $softid,
            'checked' => $checked,
            'limit' => $limit
        ];
        return $this->getData('getPl', $params);
    }

    /**
     * 获取所有评论
     *
     * @param $id
     * @param $order
     * @return array|bool
     */
    public function getAllPl($id, $order)
    {
        $params = [
            'id' => $id,
            'order' => $order,
        ];
        return $this->getData('getAllPl', $params);
    }

    public function getHotSearchForClass($classid, $limit)
    {
        $params = [
            'classid' => $classid,
            'limit' => $limit,
        ];
        return $this->getData('getHotSearchForClass', $params);
    }
}
